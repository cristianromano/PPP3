<?php

include_once "./clases/pizza.php";
include_once "./clases/cupon.php";
include_once "./clases/devoluciones.php";

$opcion = $_POST['opcion'];

switch ($opcion) {
    case 'obtenerDevoluciones':
        $arr =  Devolucion::obtenerDevoluciones();
        Devolucion::MostrarDatos($arr);
        break;
    case 'obtenerDevolucionesPorFecha':
        $arr =  Devolucion::obtenerDevolucionesPorFecha();
        Devolucion::MostrarDatos($arr);
        break;
    case 'obtenerDevolucionesPorNombre':
        $arr =   Devolucion::obtenerDevolucionesPorNombre();
        Devolucion::MostrarDatosInner($arr);
        break;

    default:
        echo 'err';
        break;
}
