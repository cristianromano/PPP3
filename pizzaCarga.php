<?php

// B- (1 pt.) PizzaCarga.php: (por POST)se ingresa Sabor, precio, Tipo (“molde” o “piedra”), cantidad( de unidades).
// Se guardan los datos en en el archivo de texto Pizza.json, tomando un id autoincremental como
// identificador(emulado) .Sí el sabor y tipo ya existen , se actualiza el precio y se suma al stock existente.
// completar el alta con imagen de la pizza, guardando la imagen con el tipo y el sabor como nombre en la carpeta
// /ImagenesDePizzas.
include_once "./clases/pizza.php";

$sabor = $_POST['sabor'];
$precio = $_POST['precio'];
$tipo = $_POST['tipo'];
$cantidad = $_POST['cantidad'];
$opcion = $_POST['opcion'];
$imagen = $_FILES['archivo'];

if (isset($sabor) && isset($precio) && isset($tipo) && isset($cantidad)) {

    switch ($opcion) {
        case 'cargarPizza':
            $pizzaArr = array();
            $pizzaArr = json_decode(file_get_contents('./archivos/Pizza.json', true));
            $pizza = new Pizza($sabor, $precio, $tipo, $cantidad, 0);
            
            if (Pizza::verificarJSON($pizza)) {
                echo 'se agrega stock';
                break;
            } else {
                $pizza->GuardarImagenCarga($imagen);
                array_push($pizzaArr, $pizza);
                Pizza::guardarJSON($pizzaArr);
                break;
            }
    }
}
