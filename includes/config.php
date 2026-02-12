<?php
/**
 * Config Loader — reads data/config.json and provides $config array
 * Include this file in any page that needs dynamic config values.
 */

function loadConfig()
{
    $configPath = __DIR__ . '/../data/config.json';
    if (!file_exists($configPath)) {
        return [];
    }
    $json = file_get_contents($configPath);
    $config = json_decode($json, true);
    return $config ?: [];
}

// Auto-load into global $config
$config = loadConfig();

// Shortcut helpers
function cfg($key, $default = '')
{
    global $config;
    $keys = explode('.', $key);
    $value = $config;
    foreach ($keys as $k) {
        if (isset($value[$k])) {
            $value = $value[$k];
        }
        else {
            return $default;
        }
    }
    return $value;
}