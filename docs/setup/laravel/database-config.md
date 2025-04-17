# 🔗 Configuración de Base de Datos en Laravel

Esta guía detalla cómo conectar tu proyecto Laravel a una base de datos local utilizando `.env` y Artisan.

---

## ⚙️ Configuración del archivo `.env`

Abre el archivo `.env` en la raíz del proyecto y ajusta los siguientes valores:

```dotenv
DB_CONNECTION=mariadb
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=example
DB_USERNAME=root
DB_PASSWORD=
```

> 📌 Asegúrate de que la base de datos `example` exista antes de ejecutar las migraciones.

---

## 🧱 Crear las Tablas Iniciales

1. Verifica que la base de datos esté creada según la configuración de `.env`.

2. Ejecuta el comando:

```bash
php artisan migrate
```

> Esto creará las tablas definidas en `/database/migrations`.

---

## 🛠️ Comandos Útiles con Migraciones

### 🔁 Revertir la última migración ejecutada:

```bash
php artisan migrate:rollback
```

### ♻️ Refrescar la base de datos (elimina y vuelve a crear tablas del último lote):

```bash
php artisan migrate:refresh
```

> ⚠️ Este comando elimina las tablas y sus datos. **No ejecutar en producción.**

### 💥 Resetear toda la base de datos:

```bash
php artisan migrate:fresh
```

> ⚠️ Elimina **todas** las tablas. **No ejecutar en producción.**
