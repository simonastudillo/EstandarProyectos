# 🛠️ Crear Nuevo Proyecto en Laravel

Esta guía detalla los pasos recomendados para crear un nuevo proyecto Laravel siguiendo el estándar definido en este repositorio.

> ℹ️ Este estándar puede evolucionar con el tiempo. Se recomienda mantener este documento actualizado según se apliquen mejoras o nuevos flujos de trabajo.

---

## ✅ Requisitos Previos

### XAMPP

1. Asegúrate de tener XAMPP instalado. Puedes descargarlo desde [https://www.apachefriends.org](https://www.apachefriends.org).
2. Levanta los servicios de **Apache** y **MySQL**.

### Composer

1. Verifica si Composer está instalado:

   ```bash
   composer --version
   ```

2. Si no lo está, descárgalo desde [https://getcomposer.org](https://getcomposer.org).

### Laravel Installer

1. Verifica si tienes instalado `laravel/installer`:

   ```bash
   laravel --version
   ```

2. Si no está instalado:

   ```bash
   composer global require laravel/installer
   ```

---

## 🚀 Crear el Proyecto

1. Abre una terminal en el directorio donde se crearán los proyectos (por ejemplo: `C:\xampp\htdocs`).
2. Ejecuta el comando:

   ```bash
   laravel new nombre-de-tu-app
   ```

---

## ⚙️ Configuración Inicial del Proyecto

Durante el proceso de instalación de Laravel, se recomienda lo siguiente:

1. **Starter Kit**: Selecciona `none`.

   ```bash
   Which starter kit would you like to install? none
   ```

2. **Testing Framework**: Selecciona PHPUnit.

   ```bash
   Which testing framework do you prefer? 1
   ```

3. **Base de Datos**: Selecciona MariaDB.

   ```bash
   Which database will your application use? mariadb
   ```

4. **Migraciones**: Aún no ejecutar.

   ```bash
   Would you like to run the default database migrations? no
   ```

5. **Instalación de dependencias frontend**:

   ```bash
   Would you like to run npm install and npm run build? yes
   ```

---

📌 Para configurar el idioma del proyecto a español, sigue la guía en [locale.md](./locale.md).