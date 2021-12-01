<?php

// 9- (1 pts.) borrarVenta.php(por DELETE), debe recibir un número de pedido,se borra la venta y la foto se mueve a
// la carpeta /BACKUPVENTAS.


require_once "./clases/pizza.php";
require_once "./clases/ventaborrada.php";

$method = $_SERVER['REQUEST_METHOD'];
if ('DELETE' === $method) {
    parse_str(file_get_contents('php://input'), $_DELETE);

    $numero_pedido = $_DELETE['numero_pedido'];

    $pizza = Pizza::TraerUnPedido($numero_pedido);

    var_dump($pizza);
    $imagen = $pizza->imagen;

    $pizzaObj = VentaBorrada::InsertarVentaBorrada($pizza);

    if(Pizza::EliminarPedido($numero_pedido)){
        Pizza::borrarImagenVenta($imagen);
    }      

}

