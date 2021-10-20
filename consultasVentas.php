<?php

// 3- (1 pts.)ConsultasVentas.php: necesito saber :
// a- la cantidad de pizzas vendidas en un día en particular, si no se pasa fecha, se muestran las del dia de hoy
// b- el listado de ventas entre dos fechas ordenado por sabor.
// c- el listado de ventas de un usuario ingresado
// d- el listado de ventas de un sabor ingresado

$fecha1 = $_POST['fechaUno'];
// $fecha2 = $_POST['fechaDos'];
// $sabor = $_POST['sabor'];
// $email = $_POST['email'];
$opcion = $_POST['opcion'];

include_once "./clases/pizza.php";

switch ($opcion) {
    case 'porFechaEspecifica':
        if ($fecha1 == "") {
            $arr = Pizza::traerVentasPorFecha($fecha1);
            Pizza::MostrarDatos($arr);
        }else{
            $arr = Pizza::traerVentasPorFecha($fecha1);
            echo 'la cantidad vendida en la fecha ' . $fecha1 . 'es de:' . $arr[0]->CantidadVendidos;
        }

        break;
    case 'porFechas':
        $arr = Pizza::TraerVentasEntreFechas($fecha1, $fecha2);
        Pizza::MostrarDatos($arr);
        break;
    case 'value':
        $arr = Pizza::TraerPorUsuario("lionelmessi30@gmail.com");
        Pizza::MostrarDatos($arr);
        break;
    case 'porSabor':
        $arr = Pizza::TraerPorSabor("Clasica");
        Pizza::MostrarDatos($arr);
        break;

    default:
        # code...
        break;
}
