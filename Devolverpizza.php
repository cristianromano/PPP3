<?php

// 5- (2 pts.)DevolverPizza.php Guardar en el archivo (devoluciones.json y cupones.json):
// a-Se ingresa el número de pedido y la causa de la devolución. El número de pedido debe existir, se ingresa una
// foto del cliente enojado,esto debe generar un cupón de descuento con el 10% de descuento para la próxima
// compra.

include_once "./clases/pizza.php";
include_once "./clases/cupon.php";
include_once "./clases/devoluciones.php";

$numero_pedido = $_POST['numero_pedido'];
$motivo = $_POST['motivo'];
$imagen = $_FILES['archivo'];


if (isset($numero_pedido) && isset($motivo)  && isset($imagen)) {
    
    $pizzaDevuelta = Devolucion::DevolverPizza($numero_pedido, $motivo, $imagen['name']);

    if ($pizzaDevuelta->verificoPedidoExiste()) {
        $cupon = new Cupon(0, 10);
        $cuponArr = array();
        $cuponArr = json_decode(file_get_contents('./archivos/Cupon.json', true));
        
        $pizzaDevuelta->id_cupon = $cupon->id_cupon;
        $pizzaDevuelta->insertarDevolucion();

        array_push($cuponArr, $cupon);
        Cupon::guardarJSON($cuponArr);
        echo "te pedimos disculpas por lo sucedio , aqui tiene un cupon de 10% para utilizar en su proxima compra , 
        deberias ingresar el numero a continuacion para activar el descuento: " . $pizzaDevuelta->id_cupon;
    }else{
        echo 'no existe ese pedido';
    }

} else {
    echo 'fijarse haber cargado todo correctamente';
}

