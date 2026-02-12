# Huawei Hosting — Sitio Web

Sitio web profesional para **Venta de Hosting Huawei**, una empresa de alojamiento web con tecnología Huawei Cloud.

## Stack Técnico

| Tecnología | Versión |
|---|---|
| PHP | 8.0+ |
| Tailwind CSS | v3 (CDN) |
| Font Awesome | 6.5 (CDN) |
| Google Fonts | Outfit + Inter |

## Estructura de Archivos

```
├── index.php          ← Landing page (hero, servicios, precios, CTA)
├── hosting.php        ← Planes detallados, comparativa, FAQ
├── contacto.php       ← Formulario de contacto y datos de empresa
├── admin.php          ← Panel de administración/configuración
├── includes/
│   ├── header.php     ← Navbar responsiva, CSS, configuración
│   ├── footer.php     ← Footer con enlaces y redes sociales
│   └── config.php     ← Cargador de configuración (cfg() helper)
├── data/
│   └── config.json    ← Configuración persistente del sitio
├── api/
│   └── save_config.php ← Endpoint para guardar cambios del admin
├── assets/
│   └── img/           ← Imágenes del sitio
├── .htaccess          ← Seguridad, caché y compresión
└── README.md          ← Este archivo
```

## Características

- **Diseño responsivo** mobile-first con menú hamburguesa
- **Tema oscuro** tecnológico con acentos rojos Huawei
- **Animaciones** suaves con Intersection Observer
- **Panel admin funcional** — los cambios se guardan en `data/config.json` y se reflejan en todo el sitio
- **Secciones configurables**: empresa, hero, precios, redes sociales

## Admin ↔ Sitio

El panel admin guarda los cambios directamente en `data/config.json`. Todo el sitio lee sus valores dinámicos (teléfono, precios, textos, redes sociales) desde este archivo, por lo que cualquier cambio guardado en el admin se refleja inmediatamente en el sitio principal.

## Ejecución Local

```bash
php -S localhost:8888
```

Luego visitar `http://localhost:8888` en el navegador.

## Paleta de Colores

| Color | Hex | Uso |
|---|---|---|
| Dark BG | `#0d0d0d` | Fondo principal |
| Surface | `#1a1a2e` | Cards, secciones |
| Huawei Red | `#C7000B` | Acento, CTAs |
| Text Primary | `#ffffff` | Títulos |
| Text Secondary | `#cbd5e1` | Cuerpo |
| Text Muted | `#64748b` | Captions |
