Para una documentación completa y explícita, es importante proporcionar información detallada sobre cómo utilizar cada método de la clase `DB` en tu proyecto. Aquí tienes una documentación completa paso a paso con ejemplos de uso:

## Documentación de la Clase `DB`

La clase `DB` proporciona métodos para interactuar con la base de datos de manera sencilla.

### 1. Conexión y Selección de la Tabla

Antes de utilizar cualquier otro método, debes establecer la tabla con la que deseas trabajar.

#### `table($table)`

Este método se utiliza para especificar la tabla con la que deseas interactuar.

- `$table` (string): El nombre de la tabla con la que deseas trabajar.

Ejemplo:

```php
use App\Core\DB;

// listar la tabla 'products'
DB::table('products');
```

### 2. Selección de Datos

Puedes utilizar estos métodos para seleccionar datos de la tabla.

#### `select($columns = ['*'])`

Este método se utiliza para seleccionar datos de la tabla.

- `$columns` (array|string, opcional): Las columnas que deseas seleccionar. Por defecto, selecciona todas las columnas (`'*'`).

Ejemplos:

```php
// Seleccionar todos los productos
$products = DB::select();

// Seleccionar solo ciertas columnas
$selectedColumns = DB::select(['name', 'price']);
```

#### `first()`

Este método se utiliza para obtener el primer resultado de la selección.

Ejemplo:

```php
// Obtener el primer producto
$firstProduct = DB::first();
```

#### `find($id)`

Este método se utiliza para encontrar un registro por su ID.

- `$id` (mixed): El valor del ID que deseas buscar.

Ejemplo:

```php
// Encontrar un producto por ID
$product = DB::find(1);
```

#### `findAll()`

Este método se utiliza para encontrar todos los registros de la tabla.

Ejemplo:

```php
// Encontrar todos los productos
$allProducts = DB::findAll();
```

#### `findOne($column, $value)`

Este método se utiliza para encontrar un registro por el valor de una columna específica.

- `$column` (string): El nombre de la columna por la que deseas buscar.
- `$value` (mixed): El valor que deseas buscar en la columna.

Ejemplo:

```php
// Encontrar un producto por el nombre
$product = DB::findOne('name', 'Product Name');
```

### 3. Inserción de Datos

Puedes utilizar estos métodos para insertar nuevos registros en la tabla.

#### `create($data)`

Este método se utiliza para crear un nuevo registro en la tabla.

- `$data` (array): Un array asociativo que contiene los valores de las columnas que deseas insertar.

Ejemplo:

```php
// Crear un nuevo producto
$newProductId = DB::create([
    'name' => 'New Product',
    'price' => 19.99,
    // Otras columnas
]);
```

### 4. Actualización de Datos

Puedes utilizar estos métodos para actualizar registros existentes en la tabla.

#### `update($data)`

Este método se utiliza para actualizar registros que cumplan con una cláusula WHERE específica.

- `$data` (array): Un array asociativo que contiene los valores de las columnas que deseas actualizar.

Ejemplo:

```php
// Actualizar un producto existente
$updatedRows = DB::where('id = ?', [1])->update([
    'price' => 29.99,
    // Otras columnas
]);
```

### 5. Eliminación de Datos

Puedes utilizar estos métodos para eliminar registros de la tabla.

#### `delete()`

Este método se utiliza para eliminar registros que cumplan con una cláusula WHERE específica.

Ejemplo:

```php
// Eliminar un producto
$deletedRows = DB::where('id = ?', [1])->delete();
```

### 6. Cláusulas WHERE

Puedes utilizar estas cláusulas para especificar condiciones en las operaciones de selección, actualización o eliminación.

#### `where($condition, $params = [])`

Este método se utiliza para agregar una cláusula WHERE a la consulta.

- `$condition` (string): La condición de la cláusula WHERE.
- `$params` (array, opcional): Los valores de los parámetros en la condición.

Ejemplo:

```php
// Usar una cláusula WHERE con parámetros
$products = DB::where('price > ? AND stock > ?', [20, 10])->select();
```

#### `orWhere($condition, $params = [])`

Este método se utiliza para agregar una cláusula WHERE OR a la consulta.

- `$

condition` (string): La condición de la cláusula WHERE OR.

- `$params` (array, opcional): Los valores de los parámetros en la condición.

Ejemplo:

```php
// Usar una cláusula WHERE OR
$products = DB::where('category = ?')->orWhere('subcategory = ?', 'Electronics')->select();
```

Estos ejemplos y la documentación te proporcionan una guía completa para utilizar la clase `DB` en tu proyecto. Asegúrate de personalizarlos según tus necesidades específicas y adaptarlos a tu aplicación.
