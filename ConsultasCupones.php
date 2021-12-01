<?php

include_once "./clases/pizza.php";
include_once "./clases/cupon.php";


// $cupones = Cupon::obtenerCuponesJSON();

// foreach ($cupones as $cuponArr) {
//     $cupon = Cupon::crearCupon($cuponArr['descuento'],$cuponArr['precio'],$cuponArr['id_cupon'],$cuponArr['usado']);
//    $cupon->updateCupon();
// }

$opcion = $_POST['opcion'];
// $fecha = $_POST['fecha'];

switch ($opcion) {
    case 'obtenerCupones':
        $arr =  Cupon::obtenerCupones();
        Cupon::MostrarDatos($arr);
        break;
    case 'obtenerCuponesFecha':
        $arr =  Cupon::obtenerCuponesFecha($fecha);
        Cupon::MostrarDatos($arr);
        break;
    case 'obtenerCuponesUsuario':
        $arr =  Cupon::obtenerCuponesUsuario();
        Cupon::MostrarDatosInner($arr);
        break;

    default:
        echo 'err';
        break;
}