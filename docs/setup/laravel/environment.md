# ⚙️ Configuración del Entorno en Laravel

Guía para configurar correctamente el entorno de ejecución de Laravel utilizando el archivo `.env`.

---

## 🧾 Variables esenciales del archivo `.env`

```dotenv
APP_NAME="Mi Proyecto"
APP_ENV=local
APP_KEY=base64:...
APP_DEBUG=true
APP_URL=http://localhost
```

- `APP_NAME`: Nombre de la aplicación, aparece en logs y notificaciones.
- `APP_ENV`: Define el entorno (`local`, `production`, `staging`...).
- `APP_KEY`: Clave de cifrado (generada con `php artisan key:generate`).
- `APP_DEBUG`: `true` en desarrollo, `false` en producción.
- `APP_URL`: URL base del proyecto.

---

## 🔐 Generar clave de aplicación

```bash
php artisan key:generate
```

> Esto actualiza automáticamente `APP_KEY` en el archivo `.env`.

---

## 🚨 Buenas prácticas

- **Nunca subas el archivo `.env`** al repositorio.
- Usa `.env.example` como plantilla genérica con valores por defecto.
- En producción, asegúrate de que:
  - `APP_ENV=production`
  - `APP_DEBUG=false`
  - `APP_URL` esté correctamente configurada
  - El archivo `.env` esté protegido contra accesos no autorizados
