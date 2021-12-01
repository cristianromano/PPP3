<?php

include_once "./clases/pizza.php";
include_once "./clases/cupon.php";


class VentaBorrada{

    public $sabor;
    public $tipo;
    public $cantidad;
    public $numero_pedido;
    public $imagen;
    public $numero_descuento;


    public static function InsertarVentaBorrada($venta)
    {           //`id`, `codigo`, `nombre`, `tipo`, `stock`, `precio`, `fecha_de_creacion`, `fecha_de_modificacion`
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("INSERT INTO ventaborradas(email,sabor,tipo,cantidad,fecha,numero_pedido,id_pedido,imagen,precio,descuento,numero_descuento) 
               VALUES (:email,:sabor,:tipo,:cantidad,:fecha,:numero_pedido,:id_pedido,:imagen,:precio,:descuento,:numero_descuento)");
        $consulta->bindValue(':email', $venta->email, PDO::PARAM_STR);
        $consulta->bindValue(':sabor', $venta->sabor, PDO::PARAM_STR);
        $consulta->bindValue(':tipo', $venta->tipo, PDO::PARAM_STR);
        $consulta->bindValue(':cantidad', $venta->cantidad, PDO::PARAM_INT);
        $consulta->bindValue(':fecha', $venta->fecha, PDO::PARAM_STR);
        $consulta->bindValue(':numero_pedido', $venta->numero_pedido, PDO::PARAM_INT);
        $consulta->bindValue(':imagen', $venta->imagen, PDO::PARAM_STR);
        $consulta->bindValue(':precio', $venta->precio, PDO::PARAM_STR);
        $consulta->bindValue(':descuento', $venta->descuento, PDO::PARAM_STR);
        $consulta->bindValue(':numero_descuento', $venta->numero_descuento, PDO::PARAM_INT);
        $consulta->bindValue(':id_pedido', $venta->id_pedido, PDO::PARAM_INT);
        // $consulta->bindValue(':id_pedido', $this->id_pedido, PDO::PARAM_INT);
        $consulta->execute();
        return $objetoAccesoDato->RetornarUltimoIdInsertado();
    }


    public static function traerImagenesBorradas()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("SELECT imagen FROM ventaborradas ");

        if ($consulta->execute()) {
            return $consulta->fetchAll(PDO::FETCH_OBJ);
        } else {
            echo 'err';
        }
    }

    public static function mostrarFotosBorradas($arrProductos)
    {

        $cadena = "<ul>";
        // Productos::guardarJSON($arrProductos);
        foreach ($arrProductos as $x) {
            $cadena .= "<li>" .
                "Imagen:" . $x->imagen;
        }
        $cadena .= "</ul>";
        echo $cadena;
    }





}