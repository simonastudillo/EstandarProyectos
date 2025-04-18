# ⚙️ Configuración del Entorno en Laravel

Esta guía cubre las variables esenciales del entorno que se configuran en el archivo `.env`, su función y valores recomendados según el ambiente.

---

> 🔗 [Volver al índice de configuración inicial](./index.md)  
> 🔙 [Volver al paso anterior: Configuración de base de datos](./database-config.md)
> ⏭️ [Ir al paso 5: Comando personalizado: make:model modular](./make-model-command.md)

---

## 🧾 Variables esenciales del archivo `.env`

   ```dotenv
   APP_NAME="Mi Proyecto"
   APP_ENV=local
   APP_KEY=base64:...
   APP_DEBUG=true
   APP_URL=http://localhost
   ```

### Significado

- `APP_NAME`: Nombre de la aplicación (aparece en logs y notificaciones).
- `APP_ENV`: Entorno de ejecución (`local`, `production`, `staging`, etc.).
- `APP_KEY`: Clave de cifrado usada por Laravel.
- `APP_DEBUG`: Mostrar errores detallados (`true` en desarrollo, `false` en producción).
- `APP_URL`: URL base del proyecto.

---

## 🔐 Generar la clave de aplicación

Si `APP_KEY` está vacío, generala con el siguiente comando:

   ```bash
   php artisan key:generate
   ```

Esto actualiza automáticamente el valor en `.env`.

---

## 🚨 Buenas prácticas

- **Nunca subas el archivo `.env`** al repositorio.
- Usa `.env.example` como plantilla genérica con valores por defecto.
- En producción, asegúrate de que:
  - `APP_ENV=production`
  - `APP_DEBUG=false`
  - `APP_URL` esté correctamente configurada
  - El archivo `.env` esté protegido contra accesos no autorizados

---

🔎 **Ejemplo real del proyecto:**  
Podés ver una versión funcional en el repositorio:  
- [`.env`](./examples/.env)