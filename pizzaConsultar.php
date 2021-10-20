<?php

// (1pt.) PizzaConsultar.php: (por POST)Se ingresa Sabor,Tipo, si coincide con algún registro del archivo Pizza.json,
// retornar “Si Hay”. De lo contrario informar si no existe el tipo o el sabor.

include_once "./clases/pizza.php";

$sabor = $_POST['sabor'];
$tipo = $_POST['tipo'];
$opcion = $_POST['opcion'];

if (isset($sabor) && isset($tipo) ) {

    switch ($opcion) {
        case 'verificoPizza':
            Pizza::VerificoPizza($sabor,$tipo);
            break;

    }
}
