<?php

include_once "./clases/pizza.php";
include_once "./clases/cupon.php";
include_once "./clases/devoluciones.php";
require_once "./clases/ventaborrada.php";

// a-Listar las ventas borradas.
// b-Listar Las imágenes dependiendo del parámetro que reciba , puedo mostrar las actuales o las del BackUp.
// c-Listar devoluciones y sus cupones y si fueron usados o no.

$opcion = $_POST['opcion'];

$method = $_SERVER['REQUEST_METHOD'];
if ('DELETE' === $method) {
    parse_str(file_get_contents('php://input'), $_DELETE);

    $numero_pedido = $_DELETE['numero_pedido'];

    $pizza = Pizza::TraerUnPedido($numero_pedido);

    var_dump($pizza);
    $imagen = $pizza->imagen;

    $pizzaObj = VentaBorrada::InsertarVentaBorrada($pizza);

    if (Pizza::EliminarPedido($numero_pedido)) {
        Pizza::borrarImagenVenta($imagen);
    }
}


switch ($opcion) {
    case 'backup':
        $b = VentaBorrada::traerImagenesBorradas();
        VentaBorrada::mostrarFotosBorradas($b);
        break;

    case 'nuevas':
        $a = Pizza::traerImagenesOriginales();
        Pizza::mostrarFotosOriginales($a);
        break;

    case 'verCupones':
        $cupones = Devolucion::obtenerCuponesVerUso();
        Devolucion::mostrarCuponesUso($cupones);
        break;

    default:
        echo 'err';
        break;
}
