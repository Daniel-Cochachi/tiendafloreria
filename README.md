# Tienda Florería - MVC PHP

Estructura MVC profesional para una tienda de flores con PHP.

## Estructura de carpetas

```
tienda-floreria-mvc-php/
├── app/
│   ├── controllers/      # Controladores
│   ├── models/          # Modelos (acceso a BD)
│   ├── views/           # Vistas (HTML)
│   └── core/            # Clases core (Router, Controller)
├── config/              # Configuración y conexión BD
├── public/              # Archivos públicos (punto de entrada)
│   ├── index.php        # Punto de entrada
│   ├── css/             # Estilos
│   ├── js/              # Scripts
│   └── images/          # Imágenes
└── README.md
```

## Configuración

1. **Base de datos:**
   - Edita `config/config.php` con tus datos de conexión
   - Asegúrate de que MySQL esté corriendo

2. **URL base:**
   - Actualiza `APP_URL` en `config/config.php`

3. **.htaccess:**
   - Asegúrate de que `mod_rewrite` esté habilitado en Apache

## Uso

### Crear un Controlador

```php
// app/controllers/ProductsController.php
class ProductsController extends Controller {
    public function index() {
        $productModel = $this->model('Product');
        $products = $productModel->getAllProducts();
        $data = ['products' => $products];
        $this->view('products', $data);
    }
}
```

### Crear un Modelo

```php
// app/models/Product.php
class Product {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
    }

    public function getAllProducts() {
        // Tu consulta SQL
    }
}
```

### Crear una Vista

```php
<!-- app/views/products.php -->
<h1>Productos</h1>
<?php foreach($data['products'] as $product): ?>
    <div>
        <h2><?php echo $product['nombre']; ?></h2>
        <p><?php echo $product['descripcion']; ?></p>
    </div>
<?php endforeach; ?>
```

## URLs

- Página de inicio: `/`
- Controlador con método: `/nombrecontrolador/metodo`
- Con parámetros: `/nombrecontrolador/metodo/parametro1/parametro2`

## Base de datos

Crea una tabla de ejemplo:

```sql
CREATE TABLE productos (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(255) NOT NULL,
    descripcion TEXT,
    precio DECIMAL(10, 2),
    imagen VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

¡Listo! Tu estructura MVC está lista para empezar a desarrollar.
