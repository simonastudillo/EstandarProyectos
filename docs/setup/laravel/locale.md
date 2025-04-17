# 🌐 Configuración de Idioma en Laravel

Esta guía explica cómo configurar Laravel para que use el idioma español por defecto, incluyendo los textos de validación, faker y los archivos de traducción.

---

## 🇪🇸 Cambiar Idioma por Defecto

1. Abre el archivo `config/app.php`.
2. Cambia el valor de `locale` a `es`:

```php
'locale' => env('APP_LOCALE', 'es'),
```

3. Cambia el valor de `faker_locale` a `es_ES`:

```php
'faker_locale' => env('APP_FAKER_LOCALE', 'es_ES'),
```

4. Abre el archivo `.env` en la raíz del proyecto y ajusta también:

```dotenv
APP_LOCALE=es
APP_FAKER_LOCALE=es_ES
```

> 🧠 Recuerda reiniciar el servidor para aplicar los cambios correctamente.

---

## 📦 Archivos de Traducción en Español

1. Publica los archivos actuales de idioma inglés:

```bash
php artisan lang:publish
```

> Esto creará la carpeta `lang/` con los archivos en inglés como base.

2. Instala el paquete de idiomas mantenido por la comunidad:

```bash
composer require --dev laravel-lang/common
```

3. Agrega el idioma español al proyecto:

```bash
php artisan lang:add es
```

> Esto reemplazará o complementará los archivos existentes con traducciones en español.

---

Con esto, tu aplicación estará lista para funcionar completamente en español, incluyendo validaciones y datos generados por faker.
