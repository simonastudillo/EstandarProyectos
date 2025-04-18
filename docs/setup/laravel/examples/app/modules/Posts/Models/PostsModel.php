<?php

namespace App\Modules\Posts\Models;

use App\Modules\Shared\Traits\SoftDeactivatesTrait;
use Database\Factories\PostsModelFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PostsModel extends Model
{
   use HasFactory, SoftDeletes, SoftDeactivatesTrait;

   protected $table = 'posts'; // nombre de tabla en la base de datos
   protected $primaryKey = 'post_id'; // clave primaria de la tabla
   protected $fillable = ['title', 'content', 'slug']; // campos que se pueden llenar masivamente
   protected $guarded = ['post_id', 'created_at', 'updated_at', 'published_at', 'is_active']; // campos que no se pueden llenar masivamente

   public function getRouteKeyName(): string
   {
      return 'post_id'; // nombre de la clave primaria para las rutas
   }

   protected static function newFactory(): PostsModelFactory
   {
      return PostsModelFactory::new(); //Factory a utilizar
   }

   protected function casts(): array
   {
      return [
         'created_at' => 'datetime',
         'updated_at' => 'datetime',
         'published_at' => 'datetime',
         'is_active' => 'boolean'
      ]; // Casts para los campos de la tabla y poder usar carbon
   }

   protected function title(): Attribute
   {
      return Attribute::make(
         get: fn($value) => ucfirst($value),
         set: fn($value) => strtolower($value),
      ); // Cambia la primera letra a mayúscula y el resto a minúscula cada vez que se guarda el campo title y cuando se obtiene (getters and setters)
   }

   public function comments()
   {
      return $this->hasMany(CommentsModel::class, 'post_id', 'post_id'); // Relación uno a muchos con la tabla de comentarios (comments)
   }

   // Relación muchos a muchos con la tabla de etiquetas (tags)
   public function tags()
   {
      return $this->belongsToMany(TagsModel::class, 'posts_tags', 'post_id', 'tag_id')
         ->withPivot('created_at', 'updated_at')
         ->withTimestamps(); // Relación muchos a muchos con la tabla de etiquetas (tags) y los timestamps de la tabla pivote
   }
}
