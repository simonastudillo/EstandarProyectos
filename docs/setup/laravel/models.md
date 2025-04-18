# 🧩 Modelos y Relaciones en Laravel

Esta guía detalla cómo definir modelos en Laravel con enfoque en estructura clara, relaciones entre entidades, uso de traits y convenciones personalizadas.

---

## 🛠️ Crear un modelo

```bash
php artisan make:model Modules/Posts/Models/PostsModel
```

> 🎯 Convención: usar carpeta por módulo (`Modules/NOMBRE/Models`)  
> 📌 Nombre del modelo debe incluir `Model` al final (`PostsModel`, `UsersModel`, etc.)

---

## 📄 Estructura base recomendada

```php
namespace App\Modules\Posts\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Modules\Shared\Traits\SoftDeactivatesTrait;

class PostsModel extends Model
{
    use HasFactory, SoftDeactivatesTrait;

    protected $table = 'posts';
    protected $primaryKey = 'post_id';
    public $timestamps = false;

    protected $fillable = [
        'created_by',
        'title',
        'content',
        'post_token',
        'is_active'
    ];

    protected $dates = ['deleted_at'];

    public static function newFactory()
    {
        return \Database\Factories\PostsFactory::new();
    }

    public function creator()
    {
        return $this->belongsTo(UsersModel::class, 'created_by', 'user_id');
    }
}
```

---

## 🔁 Definir relaciones entre modelos

```php
// Uno a muchos
public function posts()
{
    return $this->hasMany(PostsModel::class, 'created_by', 'user_id');
}

// Uno a uno
public function profile()
{
    return $this->hasOne(ProfilesModel::class, 'user_id', 'user_id');
}

// Muchos a muchos
public function tags()
{
    return $this->belongsToMany(TagsModel::class, 'post_tag', 'post_id', 'tag_id');
}
```

---

## 🧪 Traits útiles

- `HasFactory`: enlaza con un factory para testing y seeds.
- `SoftDeletes`: (no necesario si usas `SoftDeactivatesTrait`, pero se puede combinar).
- `SoftDeactivatesTrait`: reemplaza el borrado lógico por cambio de estado con `is_active`.

### 🧩 Trait personalizado: SoftDeactivatesTrait

Permite manejar "soft deletes" mediante un campo booleano `is_active` en lugar del típico `deleted_at`.

```php
use App\Modules\Shared\Traits\SoftDeactivatesTrait;

class PostModel extends Model
{
    use SoftDeactivatesTrait;
}
```

Este trait:

- Al hacer `delete()`, marca `is_active = false`
- Al hacer `restore()`, vuelve `is_active = true`
- Y además, asigna la fecha actual al campo `deleted_at`, si está definido

> ⚠️ Es necesario que el modelo tenga el campo `deleted_at` y lo incluya en `$dates` si se desea mantener la fecha de inactivación como referencia adicional.

---

## 🛡️ Reglas y convenciones

- Prefiere `post_id`, `user_id` en vez de `id` para claridad entre tablas.
- Define explícitamente `primaryKey` y `table` si sales de lo convencional.
- Siempre usar `fillable` o `guarded` para proteger la asignación masiva.
