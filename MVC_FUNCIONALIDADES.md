# Auditoria MVC - Tienda Floreria

## Que tiene la base de datos

La base `tienda_floreria` incluye estas areas:

- Catalogo: `categorias`, `productos`, `arreglo_componentes`
- Clientes: `usuarios`, `direcciones`
- Compra: `carrito`, `ordenes`, `orden_detalles`
- Checkout: `metodos_pago`, `servicios_adicionales`, `orden_servicios`
- Descuentos: `promociones`, `cupones`, `cupones_usados`
- Postventa: `resenas`, `favoritos`, `notificaciones`
- Operacion: `transacciones`, `entregas`, `historial_entregas`
- Auditoria/reportes: `historial_cambios`, `estadisticas`

## Funcionalidades implementadas en el MVC

- Layout comun para todas las vistas.
- Sesion global desde `public/index.php`.
- Catalogo con categorias, busqueda y detalle de producto.
- Precios con descuento usando `precio_final` o `descuento_porcentaje`.
- Carrito con validacion de stock.
- Checkout con direcciones, fecha de entrega, notas, metodos de pago, servicios extra y cupones.
- Creacion de orden en transaccion: detalle, stock, servicios, cupon usado, transaccion y entrega.
- Cancelacion de orden pendiente con devolucion de stock.
- Registro, login, perfil y direcciones principales.
- Favoritos.
- Resenas pendientes de aprobacion.
- Panel admin: dashboard, productos, pedidos, resenas y cupones.

## Pendientes avanzados

- Pasarela real de tarjeta/Yape/Plin.
- Tracking GPS real de repartidores.
- Notificaciones por email, SMS o WhatsApp.
- CRUD completo para categorias, servicios y metodos de pago.
- Reportes graficos de ventas y estadisticas automaticas.
- Carga real de imagenes desde el panel admin.
