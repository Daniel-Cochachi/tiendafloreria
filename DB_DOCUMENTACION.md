# 📦 BASE DE DATOS - TIENDA FLORERÍA ONLINE (PERÚ)

## Descripción General

Base de datos profesional diseñada para una tienda florería online con todas las características necesarias para un e-commerce completo.

---

## 📊 ESTRUCTURA DE TABLAS

### 1. **CATEGORÍAS** (`categorias`)
Almacena las categorías de productos disponibles.

| Campo | Tipo | Descripción |
|-------|------|-------------|
| id | INT | Identificador único |
| nombre | VARCHAR(100) | Nombre de la categoría |
| descripcion | TEXT | Descripción de la categoría |
| imagen | VARCHAR(255) | Imagen de la categoría |
| estado | ENUM | activo/inactivo |

**Ejemplo de uso:**
```php
$category = $this->model('Category');
$categorias = $category->getAllCategories();
```

---

### 2. **USUARIOS** (`usuarios`)
Almacena todos los usuarios del sistema (clientes, admin, repartidores, empleados).

| Campo | Tipo | Descripción |
|-------|------|-------------|
| id | INT | Identificador único |
| nombre | VARCHAR(255) | Nombre del usuario |
| apellido | VARCHAR(255) | Apellido |
| email | VARCHAR(255) | Email único |
| password | VARCHAR(255) | Contraseña encriptada (bcrypt) |
| telefono | VARCHAR(20) | Teléfono de contacto |
| rol | ENUM | admin, empleado, cliente, repartidor |
| estado | ENUM | activo, inactivo, bloqueado |

**Roles disponibles:**
- `admin`: Administrador del sistema
- `cliente`: Cliente que realiza compras
- `empleado`: Personal que prepara pedidos
- `repartidor`: Personal que entrega pedidos

**Ejemplo de uso:**
```php
$user = $this->model('User');
$login = $user->login($email, $password);
```

---

### 3. **DIRECCIONES** (`direcciones`)
Almacena direcciones de entrega de los usuarios (múltiples por usuario).

| Campo | Tipo | Descripción |
|-------|------|-------------|
| usuario_id | INT | FK a usuarios |
| calle | VARCHAR(255) | Nombre de la calle |
| numero | VARCHAR(20) | Número de la casa |
| departamento | VARCHAR(20) | Número de departamento (si aplica) |
| distrito | VARCHAR(100) | Distrito de Lima |
| provincia | VARCHAR(100) | Provincia del país |
| departamento_prov | VARCHAR(100) | Departamento/Región |
| referencia | TEXT | Punto de referencia |
| es_principal | BOOLEAN | Dirección por defecto |

**Distritos de Lima incluidos:** San Isidro, Miraflores, Lima Centro, etc.

**Ejemplo de uso:**
```php
$address = $this->model('Address');
$direcciones = $address->getAddressesByUser($usuario_id);
```

---

### 4. **PRODUCTOS** (`productos`)
Almacena todos los productos disponibles en la tienda.

| Campo | Tipo | Descripción |
|-------|------|-------------|
| categoria_id | INT | FK a categorías |
| nombre | VARCHAR(255) | Nombre del producto |
| descripcion | TEXT | Descripción detallada |
| precio_unitario | DECIMAL(10,2) | Precio base |
| descuento_porcentaje | DECIMAL(5,2) | % de descuento |
| precio_final | DECIMAL(10,2) | Precio con descuento |
| imagen_principal | VARCHAR(255) | Imagen principal |
| imagen_secundaria1-3 | VARCHAR(255) | Imágenes adicionales |
| stock | INT | Cantidad disponible |
| tipo_producto | ENUM | flor_individual, arreglo, ramo, combo |
| codigo_sku | VARCHAR(100) | Código único del producto |
| duracion_dias | INT | Duración estimada en días |
| estado | ENUM | activo, inactivo, descontinuado |

**Tipos de producto:**
- `flor_individual`: Una flor sola
- `arreglo`: Flores en florero
- `ramo`: Ramo envuelto
- `combo`: Flores + otros regalos

**Ejemplo de uso:**
```php
$product = $this->model('Product');
$productos = $product->getProductsByCategory($categoria_id);
$producto = $product->getProductById($id);
```

---

### 5. **COMPONENTES DE ARREGLOS** (`arreglo_componentes`)
Define qué flores componen un arreglo floral.

| Campo | Tipo | Descripción |
|-------|------|-------------|
| arreglo_id | INT | FK a producto (arreglo) |
| producto_id | INT | FK a producto (flor) |
| cantidad | INT | Cantidad de flores |

---

### 6. **SERVICIOS ADICIONALES** (`servicios_adicionales`)
Servicios opcionales que se pueden agregar a cualquier orden.

| Campo | Tipo | Descripción |
|-------|------|-------------|
| nombre | VARCHAR(100) | Nombre del servicio |
| descripcion | TEXT | Descripción |
| precio | DECIMAL(10,2) | Costo del servicio |
| tipo | ENUM | envoltura, tarjeta, envio, otro |

**Servicios incluidos:**
- Envoltura Lujo (S/. 15.00)
- Tarjeta Personalizada (S/. 10.00)
- Envoltura Ecológica (S/. 8.00)
- Mensaje Especial (S/. 20.00)

---

### 7. **PROMOCIONES** (`promociones`)
Descuentos y ofertas válidas para productos o categorías.

| Campo | Tipo | Descripción |
|-------|------|-------------|
| nombre | VARCHAR(150) | Nombre de la promoción |
| tipo | ENUM | porcentaje, cantidad_fija, compra_lleva |
| valor | DECIMAL(10,2) | Valor del descuento |
| fecha_inicio | DATETIME | Inicio de la promoción |
| fecha_fin | DATETIME | Fin de la promoción |
| categoria_id | INT | FK (si es para categoría) |
| producto_id | INT | FK (si es para producto) |
| limite_usos | INT | Máximo de usos |

---

### 8. **CUPONES** (`cupones`)
Cupones de descuento con códigos únicos.

| Campo | Tipo | Descripción |
|-------|------|-------------|
| codigo | VARCHAR(50) | Código único del cupón |
| tipo | ENUM | porcentaje, cantidad_fija |
| valor | DECIMAL(10,2) | Valor del descuento |
| valor_minimo_compra | DECIMAL(10,2) | Compra mínima requerida |
| usos_maximos | INT | Máximo de usos |
| fecha_inicio | DATETIME | Válido desde |
| fecha_fin | DATETIME | Válido hasta |

**Ejemplo:** Código "FLORES20" = 20% de descuento

---

### 9. **CARRITO** (`carrito`)
Productos agregados al carrito antes de pagar.

| Campo | Tipo | Descripción |
|-------|------|-------------|
| usuario_id | INT | FK a usuarios |
| producto_id | INT | FK a productos |
| cantidad | INT | Cantidad agregada |
| precio_unitario | DECIMAL(10,2) | Precio al momento |

**Ejemplo de uso:**
```php
$cart = $this->model('Cart');
$cart->addToCart($usuario_id, $producto_id, 2);
$items = $cart->getCartByUser($usuario_id);
$total = $cart->getCartTotal($usuario_id);
```

---

### 10. **ÓRDENES** (`ordenes`)
Pedidos realizados por los clientes.

| Campo | Tipo | Descripción |
|-------|------|-------------|
| numero_orden | VARCHAR(50) | Número único (ORD-20260515-XXXX) |
| usuario_id | INT | FK a usuarios |
| subtotal | DECIMAL(10,2) | Subtotal |
| descuento_total | DECIMAL(10,2) | Descuento aplicado |
| costo_envio | DECIMAL(10,2) | Costo de envío |
| total | DECIMAL(10,2) | Total final |
| estado_orden | ENUM | pendiente, confirmada, preparando, listo_envio, enviada, entregada, cancelada |
| estado_pago | ENUM | pendiente, pagado, fallido, reembolsado |
| fecha_entrega_solicitada | DATETIME | Fecha deseada de entrega |
| notas_especiales | TEXT | Instrucciones especiales |

**Estados de orden:**
- `pendiente`: Recién creada, sin procesar
- `confirmada`: Cliente confirmó la compra
- `preparando`: En preparación
- `listo_envio`: Listo para enviar
- `enviada`: En camino
- `entregada`: Entregada al cliente
- `cancelada`: Cancelada

**Ejemplo de uso:**
```php
$order = $this->model('Order');
$orden_id = $order->createOrder([
    'usuario_id' => $user_id,
    'subtotal' => 150.00,
    'total' => 158.00,
    'direccion_id' => 5,
    'costo_envio' => 8.00
]);
```

---

### 11. **DETALLES DE ORDEN** (`orden_detalles`)
Productos incluidos en cada orden (relación de muchos a muchos).

| Campo | Tipo | Descripción |
|-------|------|-------------|
| orden_id | INT | FK a órdenes |
| producto_id | INT | FK a productos |
| cantidad | INT | Cantidad comprada |
| precio_unitario | DECIMAL(10,2) | Precio al momento |
| subtotal | DECIMAL(10,2) | cantidad × precio |

---

### 12. **ENTREGAS** (`entregas`)
Información de entrega a domicilio en Perú.

| Campo | Tipo | Descripción |
|-------|------|-------------|
| orden_id | INT | FK a órdenes |
| repartidor_id | INT | FK a usuario (repartidor) |
| estado | ENUM | pendiente, en_transito, entregada, fallida, reprogramada |
| fecha_asignacion | DATETIME | Cuándo se asignó |
| fecha_entrega_real | DATETIME | Cuándo se entregó |
| ubicacion_lat | DECIMAL(10,8) | Latitud GPS |
| ubicacion_lon | DECIMAL(11,8) | Longitud GPS |
| evidencia_foto | VARCHAR(255) | Foto de entrega |
| firma_digital | VARCHAR(255) | Firma digital del cliente |
| observaciones | TEXT | Notas del repartidor |

---

### 13. **RESEÑAS** (`resenas`)
Calificaciones y comentarios de productos.

| Campo | Tipo | Descripción |
|-------|------|-------------|
| usuario_id | INT | FK a usuarios |
| producto_id | INT | FK a productos |
| orden_id | INT | FK a órdenes |
| calificacion | INT | 1-5 estrellas |
| titulo | VARCHAR(150) | Título de la reseña |
| comentario | TEXT | Comentario detallado |
| estado | ENUM | pendiente, aprobada, rechazada |

**Ejemplo de uso:**
```php
$review = $this->model('Review');
$review->addReview([
    'usuario_id' => 5,
    'producto_id' => 3,
    'calificacion' => 5,
    'titulo' => 'Excelentes flores',
    'comentario' => 'Llegaron en perfecto estado'
]);
```

---

### 14. **MÉTODOS DE PAGO** (`metodos_pago`)
Formas de pago disponibles.

| Método | Tipo | Estado |
|--------|------|--------|
| Tarjeta de Crédito/Débito | tarjeta | Activo |
| Transferencia Bancaria | transferencia | Activo |
| Efectivo contra Entrega | efectivo | Activo |
| Billetera Digital (Yape/Plin) | billetera_digital | Activo |

---

### 15. **TRANSACCIONES** (`transacciones`)
Historial de pagos realizados.

| Campo | Tipo | Descripción |
|-------|------|-------------|
| orden_id | INT | FK a órdenes |
| metodo_pago_id | INT | FK a métodos_pago |
| monto | DECIMAL(10,2) | Monto pagado |
| referencia_externa | VARCHAR(255) | ID de transacción externa |
| estado | ENUM | pendiente, completada, fallida |

---

## 🔑 CLAVES FORÁNEAS Y RELACIONES

```
usuarios (1) -----> (∞) órdenes
usuarios (1) -----> (∞) direcciones
usuarios (1) -----> (∞) reseñas
usuarios (1) -----> (∞) carrito
usuarios (1) -----> (∞) entregas (como repartidor)

categorias (1) -----> (∞) productos

productos (1) -----> (∞) resenas
productos (1) -----> (∞) carrito
productos (1) -----> (∞) orden_detalles

órdenes (1) -----> (∞) orden_detalles
órdenes (1) -----> (1) entregas
órdenes (1) -----> (1) direcciones

entregas (1) -----> (∞) historial_entregas
```

---

## 📝 MODELOS DISPONIBLES

### Product Model
```php
$product = $this->model('Product');

// Obtener todos los productos
$products = $product->getAllProducts($limit = 10, $offset = 0);

// Obtener producto por ID
$product_data = $product->getProductById($id);

// Obtener productos por categoría
$products = $product->getProductsByCategory($categoria_id);

// Buscar productos
$results = $product->searchProducts("rosa");

// Crear producto
$product->addProduct([
    'categoria_id' => 1,
    'nombre' => 'Rosa Roja',
    'precio_unitario' => 25.00,
    'stock' => 100,
    'codigo_sku' => 'SKU001'
]);
```

### User Model
```php
$user = $this->model('User');

// Registrar usuario
$user->register([
    'nombre' => 'Juan',
    'apellido' => 'Pérez',
    'email' => 'juan@example.com',
    'password' => 'segura123',
    'telefono' => '+51-987654321'
]);

// Login
$user_data = $user->login('juan@example.com', 'segura123');

// Obtener usuario por ID
$user_data = $user->getUserById($id);

// Actualizar perfil
$user->updateProfile($id, [
    'nombre' => 'Juan',
    'telefono' => '+51-987654321'
]);
```

### Cart Model
```php
$cart = $this->model('Cart');

// Agregar al carrito
$cart->addToCart($usuario_id, $producto_id, $cantidad = 1);

// Obtener carrito del usuario
$items = $cart->getCartByUser($usuario_id);

// Actualizar cantidad
$cart->updateCartItem($usuario_id, $producto_id, $cantidad = 5);

// Remover del carrito
$cart->removeFromCart($usuario_id, $producto_id);

// Obtener total
$total = $cart->getCartTotal($usuario_id);

// Contar items
$count = $cart->getCartItemCount($usuario_id);

// Limpiar carrito
$cart->clearCart($usuario_id);
```

### Order Model
```php
$order = $this->model('Order');

// Crear orden
$orden_id = $order->createOrder([
    'usuario_id' => $user_id,
    'subtotal' => 150.00,
    'descuento_total' => 10.00,
    'costo_envio' => 8.00,
    'total' => 148.00,
    'direccion_id' => 5,
    'fecha_entrega_solicitada' => '2026-05-20',
    'notas_especiales' => 'Dejar en portería'
]);

// Agregar detalles a la orden
$order->addOrderDetail($orden_id, $producto_id, $cantidad, $precio_unitario);

// Obtener orden completa
$orden = $order->getOrderById($orden_id);

// Obtener órdenes del usuario
$ordenes = $order->getOrdersByUser($usuario_id);

// Actualizar estado
$order->updateOrderStatus($orden_id, 'preparando');

// Actualizar estado de pago
$order->updatePaymentStatus($orden_id, 'pagado');
```

### Address Model
```php
$address = $this->model('Address');

// Agregar dirección
$address->addAddress([
    'usuario_id' => $user_id,
    'tipo' => 'domicilio',
    'calle' => 'Av. Paseo de la República',
    'numero' => '3210',
    'departamento' => '502',
    'distrito' => 'San Isidro',
    'provincia' => 'Lima',
    'departamento_prov' => 'Lima'
]);

// Obtener direcciones del usuario
$direcciones = $address->getAddressesByUser($usuario_id);

// Obtener dirección principal
$dir_principal = $address->getPrimaryAddress($usuario_id);

// Actualizar dirección
$address->updateAddress($id, [/* datos */]);

// Establecer como principal
$address->setPrimaryAddress($usuario_id, $address_id);
```

### Review Model
```php
$review = $this->model('Review');

// Agregar reseña
$review->addReview([
    'usuario_id' => $user_id,
    'producto_id' => $producto_id,
    'calificacion' => 5,
    'titulo' => 'Excelente producto',
    'comentario' => 'Llegó en perfecto estado'
]);

// Obtener reseñas de un producto
$resenas = $review->getReviewsByProduct($producto_id, $approved_only = true);

// Obtener calificación promedio
$rating = $review->getProductRating($producto_id);

// Obtener reseñas pendientes (admin)
$pendientes = $review->getPendingReviews();

// Aprobar reseña
$review->approveReview($id);

// Rechazar reseña
$review->rejectReview($id);
```

### Category Model
```php
$category = $this->model('Category');

// Obtener todas las categorías
$categorias = $category->getAllCategories();

// Obtener categoría por ID
$categoria = $category->getCategoryById($id);

// Crear categoría
$category->addCategory([
    'nombre' => 'Rosas',
    'descripcion' => 'Todas nuestras rosas'
]);

// Actualizar categoría
$category->updateCategory($id, [/* datos */]);

// Eliminar categoría
$category->deleteCategory($id);
```

---

## 🚀 CÓMO USAR EN CONTROLADORES

```php
<?php
class ProductsController extends Controller {
    public function index() {
        // Cargar modelo
        $productModel = $this->model('Product');
        
        // Obtener datos
        $products = $productModel->getAllProducts(12, 0);
        
        // Pasar datos a vista
        $data = ['products' => $products];
        $this->view('products/list', $data);
    }

    public function view($id) {
        $productModel = $this->model('Product');
        $reviewModel = $this->model('Review');
        
        $producto = $productModel->getProductById($id);
        $resenas = $reviewModel->getReviewsByProduct($id);
        $rating = $reviewModel->getProductRating($id);
        
        $data = [
            'product' => $producto,
            'reviews' => $resenas,
            'rating' => $rating
        ];
        
        $this->view('products/detail', $data);
    }
}
?>
```

---

## 📥 INSTALACIÓN

1. **Copiar y pegar el SQL** en phpMyAdmin o tu cliente MySQL
2. **Actualizar credenciales** en `config/config.php`
3. **Los modelos están listos** para usar en los controladores

¡Listo para empezar! 🎉

