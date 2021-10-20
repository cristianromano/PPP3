<?php

// (1 pts.) AltaVenta.php: (por POST)se recibe el email del usuario y el sabor,tipo y cantidad ,si el ítem existe en
// Pizza.json, y hay stock guardar en la base de datos( con la fecha, número de pedido y id autoincremental ) y se
// debe descontar la cantidad vendida del stock y en en la tabla ventas guardar el precio calculado, y si tuvo
// descuento .

// 4- (2 pts.) AltaVenta.php, ...( continuación)Todo lo anterior más...
// a-Debe recibir un cupón de descuento, se verifica que exista y que no esté usado, (si existe) y guardar el importe
// final y el descuento aplicado en la venta.
// b-Debe marcarse el cupón como ya usado.

include_once "./clases/pizza.php";
include_once "./clases/cupon.php";

$sabor = $_POST['sabor'];
$tipo = $_POST['tipo'];
$email = $_POST['email'];
$imagen = $_FILES['archivo'];
$cantidad = $_POST['cantidad'];


// if (isset($sabor) && isset($email) & isset($tipo) & isset($cantidad)) {
$nombre = explode('@', $email);

$path = $imagen['name'];
$extension = pathinfo($path, PATHINFO_EXTENSION);

$nombrePizza = $tipo . '-' . $sabor . '-' . $nombre[0] . '-' . "2021-10-19" . '.' . $extension;

$pizza = Pizza::crearPizzaAlta($email, $sabor, $tipo, $cantidad, $nombrePizza);
var_dump($pizza);
$cupon = new Cupon(0, 20);

if ($cupon->usado == false) {
    if ($cupon->verificarJSON($pizza)) {
        'descuento aplicado';
        $cuponArr = array();
        $cuponArr = json_decode(file_get_contents('./archivos/Cupon.json', true));
        array_push($cuponArr, $cupon);
        Cupon::guardarJSON($cuponArr);
    }
}


    if ($pizza->VentaPizza()) {
        $pizza->GuardarImagen($imagen);
    }

