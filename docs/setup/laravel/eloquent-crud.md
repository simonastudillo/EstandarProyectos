# 🔄 Operaciones CRUD con Eloquent

Guía práctica para crear, consultar, actualizar y eliminar registros usando Eloquent, siguiendo las convenciones y patrones definidos en este estándar.

---

## 📥 Crear un registro

```php
$post = PostsModel::create([
    'created_by' => 1,
    'title' => 'Nuevo post',
    'content' => 'Este es el contenido',
]);
```

> Asegúrate de que los campos estén definidos en `$fillable`.

---

## 📤 Obtener registros

```php
// Todos los activos
$posts = PostsModel::where('is_active', true)->get();

// Con paginación
$posts = PostsModel::where('is_active', true)
    ->orderBy('created_at', 'desc')
    ->paginate(10);

// Obtener uno por ID
$post = PostsModel::where('is_active', true)->find($id);
```

---

## ✏️ Editar un registro

```php
$post = PostsModel::where('is_active', true)->find($id);
$post->title = 'Título actualizado';
$post->save();
```

---

## ❌ Eliminar registros

### 🔹 Soft delete (estado `is_active = false`)

Si usas el trait `SoftDeactivatesTrait`:

```php
$post = PostModel::where('is_active', true)->find($id);
$post->delete();
```

Esto marca el registro como inactivo (`is_active = false`) y actualiza el campo `deleted_at`.

### 🔸 Restaurar registro

```php
$post->restore(); // is_active = true
```

### 🔥 Hard delete

```php
$post = PostModel::where('is_active', true)->find($id);
$post->forceDelete();
```

---

## 🔐 Tokens únicos para seguridad o edición

Puedes generar un token seguro en el evento `creating`:

```php
protected static function booted()
{
    static::creating(function ($post) {
        $uuid = (string) \Illuminate\Support\Str::uuid();
        $post->post_token = hash('sha256', $uuid);
    });
}
```

> Esto asegura que cada post tenga un token único al momento de ser creado, útil para ediciones seguras por URL, APIs, etc.

---

## ✅ Buenas prácticas

- Filtrar siempre por `is_active = true` para evitar mostrar eliminados.
- Validar existencia del registro antes de hacer update/delete.
- Usa `create()` en lugar de `new` + `save()` para mayor claridad.
- Usa `paginate()` para paginar resultados en APIs.
