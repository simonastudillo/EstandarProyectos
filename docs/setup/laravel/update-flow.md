# 🔁 Flujo de Actualización (cuando cambia la base de datos)

Cuando se agregan o modifican campos en una tabla existente, es importante mantener sincronizadas todas las capas del proyecto.

---

> 🔗 [Volver al índice de desarrollo](./index.md)  
> 🔙 [Volver al paso anterior: Controladores por módulo](./controllers.md)

---

## 🧱 Migraciones
- [Revisar migraciones](./migrations.md)

Crea una migración nueva para modificar la tabla.

   ```bash
   php artisan make:migration add_field_to_pokemons_table
   ```

- Define los cambios en `up()` y su reversión en `down()`.
- Nombra correctamente las claves foráneas.
- Aplica la migración con:

   ```bash
   php artisan migrate
   ```

---

## 🧩 Modelo
- [Revisar modelos](./models.md)

Actualizar el modelo para:

- Agregar el nuevo campo en `$fillable` (si se puede asignar)
- Si es de solo lectura, agregar a `$guarded`
- Si requiere transformación, usar `Attribute`
- Si es fecha o booleano, agregar a `$casts`

---

## 🧪 Factory
- [Revisar factories](./factories.md)

Actualizar el factory correspondiente para:

- Incluir el nuevo campo (si aplica)
- Evitar `timestamps`, `tokens`, o `is_active` si se generan automáticamente

---

## 🌱 Seeder
- [Revisar seeders](./seeders.md)

Actualizar el seeder si necesitas poblar el nuevo campo o agregar datos de prueba adicionales.

---

## 📥 Request
- [Revisar requests](./requests.md)

Actualizar la clase `Save[Entidad]Request`:

- Agregar reglas en su propio método (`rulesForX`)
- Agregar mensajes de error y atributos personalizados
- Si depende de otra entidad (FK), actualizar `passedValidation()` y `validated()`

---

## 🧭 Rutas
- [Revisar rutas](./routes.md)

Generalmente no cambian, pero si el nuevo campo afecta endpoints específicos, revisar si se deben agregar filtros, parámetros u opciones adicionales.

---

## 🧑‍💻 Controlador
- [Revisar controladores](./controllers.md)

Verificar si el campo debe:

- Ser llenado en `store()` o `update()`
- Ser visible en `index()` o `show()`
- Ser filtrado en queries (por ejemplo: `where('is_active', true)`)

---

## 🛠️ Revisión final

✅ Migración aplicada  
✅ Modelo actualizado  
✅ Factory actualizado  
✅ Seeder coherente  
✅ Request actualizado  
✅ Controlador funcional  

> 💡 Tip: automatizá esta revisión con un checklist en tus commits o pull requests.