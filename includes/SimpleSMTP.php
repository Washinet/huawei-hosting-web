<?php
/**
 * SimpleSMTP Class
 * Lightweight SMTP client for PHP to send authenticated emails without external dependencies.
 */
class SimpleSMTP
{
    private $host;
    private $port;
    private $user;
    private $pass;
    private $socket;
    private $log = [];
    private $timeout = 10;
    private $debug = false;

    public function __construct($host, $port, $user, $pass)
    {
        $this->host = $host;
        $this->port = $port;
        $this->user = $user;
        $this->pass = $pass;
    }

    public function setDebug($debug)
    {
        $this->debug = $debug;
    }

    public function getLog()
    {
        return $this->log;
    }

    private function addLog($msg)
    {
        if ($this->debug) {
            $this->log[] = date('H:i:s') . " " . $msg;
        }
    }

    private function sendCmd($cmd, $expect = 250)
    {
        // Mask password in logs
        $logCmd = $cmd;
        if (strpos($cmd, 'AUTH LOGIN') === false && base64_encode($this->pass) === $cmd) {
            $logCmd = '********';
        }
        $this->addLog("CLIENT: $logCmd");

        fwrite($this->socket, $cmd . "\r\n");
        $res = $this->readResponse();

        $code = substr($res, 0, 3);
        if ($code != $expect) {
            // Some servers return 250 for AUTH when 235 is expected or vice versa, be lenient if success code
            if (!in_array($code, ['250', '235', '334', '220', '221'])) {
                throw new Exception("SMTP Error: $res (Expected $expect)");
            }
        }
        return $res;
    }

    private function readResponse()
    {
        $res = '';
        while ($str = fgets($this->socket, 515)) {
            $res .= $str;
            if (substr($str, 3, 1) == ' ')
                break;
        }
        $this->addLog("SERVER: $res");
        return $res;
    }

    public function send($from, $to, $subject, $body, $headers = [])
    {
        $protocol = '';
        if ($this->port == 465) {
            $protocol = 'ssl://';
        }
        else if ($this->port == 587) {
            $protocol = 'tcp://';
        }
        else {
            $protocol = 'tcp://';
        }

        $this->addLog("Connecting to $protocol{$this->host}:{$this->port}...");

        // Context options to be permissive with SSL (common issue in shared hosting)
        $options = [
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true,
                'verify_depth' => 0
            ]
        ];
        $context = stream_context_create($options);

        $this->socket = @stream_socket_client(
            $protocol . $this->host . ':' . $this->port,
            $errno,
            $errstr,
            $this->timeout,
            STREAM_CLIENT_CONNECT,
            $context
        );

        if (!$this->socket) {
            $this->addLog("Connection failed: $errstr ($errno) - Posible bloqueo de Firewall o puerto incorrecto. Intente puerto 465 con SSL.");
            throw new Exception("Connection failed: $errstr ($errno)");
        }

        stream_set_timeout($this->socket, $this->timeout);

        try {
            $this->readResponse(); // Greeting

            // Use a valid hostname for EHLO/HELO
            $heloHost = $_SERVER['SERVER_NAME'] ?? 'localhost';
            if (empty($heloHost) || $heloHost == '_')
                $heloHost = 'localhost';

            $this->sendCmd('EHLO ' . $heloHost);

            // STARTTLS if port 587
            if ($this->port == 587) {
                $this->sendCmd('STARTTLS', 220);

                // Explicitly use TLS 1.2 as some PHP versions/cPanel envs fail with 'true'
                $cryptoMethod = STREAM_CRYPTO_METHOD_TLSv1_2_CLIENT;
                if (defined('STREAM_CRYPTO_METHOD_TLSv1_3_CLIENT')) {
                    $cryptoMethod |= STREAM_CRYPTO_METHOD_TLSv1_3_CLIENT;
                }

                if (!stream_socket_enable_crypto($this->socket, true, $cryptoMethod)) {
                    throw new Exception("TLS negotiation failed. El servidor no aceptó la encriptación.");
                }
                $this->sendCmd('EHLO ' . $heloHost);
            }

            // Auth
            $this->sendCmd('AUTH LOGIN', 334);
            $this->sendCmd(base64_encode($this->user), 334);
            $this->sendCmd(base64_encode($this->pass), 235);

            // Mail transaction
            $this->sendCmd("MAIL FROM: <$from>");
            $this->sendCmd("RCPT TO: <$to>");
            $this->sendCmd('DATA', 354);

            // Construct Headers
            $headerStr = "";
            $headerStr .= "Subject: $subject\r\n";
            $headerStr .= "From: $from\r\n";
            $headerStr .= "To: $to\r\n";
            $headerStr .= "MIME-Version: 1.0\r\n";
            $headerStr .= "Content-Type: text/plain; charset=UTF-8\r\n";

            if (!empty($headers)) {
                foreach ($headers as $k => $v) {
                    $headerStr .= "$k: $v\r\n";
                }
            }

            // Separate headers from body with blank line
            $data = $headerStr . "\r\n" . $body . "\r\n.";

            $this->sendCmd($data);
            $this->sendCmd('QUIT', 221);

            fclose($this->socket);
            return true;
        }
        catch (Exception $e) {
            if ($this->socket)
                fclose($this->socket);
            $this->addLog("ERROR: " . $e->getMessage());
            throw $e;
        }
    }
}