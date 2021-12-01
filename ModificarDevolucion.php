<?php

include_once "./clases/pizza.php";
include_once "./clases/cupon.php";


// 8- (1 pts.) ModificarDevolucion.php(por PUT), debe recibir el número de pedido, el email del usuario, el si existe
// se modifica , de lo contrario informar.

$method = $_SERVER['REQUEST_METHOD'];
if ('PUT' === $method) {
    parse_str(file_get_contents('php://input'), $_PUT);
    $pedido = $_PUT['pedido'];
    $mail = $_PUT['email'];
    
    $pedidoElegido = Pizza::TraerUnPedido($pedido);
    
    $pedido = Pizza::crearPizzaModificar($mail,$pedidoElegido->sabor,$pedidoElegido->tipo,$pedidoElegido->cantidad,$pedido);
    $pedido->ModificarEmail();
//    $pedidoElegido->ModificarEmail();
   
}   