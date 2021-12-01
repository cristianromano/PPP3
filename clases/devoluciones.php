<?php

include_once "./clases/pizza.php";
include_once "./clases/cupon.php";

class Devolucion
{

    public $imagen;

    public $numero_pedido;
    public $motivo;
    public $id_cupon;


    public function __construct()
    {
    }


    public static function DevolverPizza($numero_pedido, $motivo, $imagen)
    {
        $pizza = new Devolucion();
        $pizza->numero_pedido = $numero_pedido;
        $pizza->motivo = $motivo;
        $pizza->imagen = $imagen;
        $pizza->id_cupon = 0;

        return $pizza;
    }

    public function insertarDevolucion()
    {           //`id`, `codigo`, `nombre`, `tipo`, `stock`, `precio`, `fecha_de_creacion`, `fecha_de_modificacion`
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("INSERT INTO devoluciones(numero_pedido,motivo,imagen,id_cupon) 
               VALUES (:numero_pedido,:motivo,:imagen,:id_cupon)");
        $consulta->bindValue(':numero_pedido', $this->numero_pedido, PDO::PARAM_INT);
        $consulta->bindValue(':motivo', $this->motivo, PDO::PARAM_STR);
        $consulta->bindValue(':imagen', $this->imagen, PDO::PARAM_STR);
        $consulta->bindValue(':id_cupon', $this->id_cupon, PDO::PARAM_INT);
        // $consulta->bindValue(':id_pedido', $this->id_pedido, PDO::PARAM_INT);
        $consulta->execute();
        return $objetoAccesoDato->RetornarUltimoIdInsertado();
    }

    public static function MostrarDatos($arrProductos)
    {

        $cadena = "<ul>";
        // Productos::guardarJSON($arrProductos);
        foreach ($arrProductos as $x) {
            $cadena .= "<li>" .
                "imagen:" . $x->imagen . " " .
                "numero_pedido:" . $x->numero_pedido . " " .
                "motivo:" . $x->motivo . " " .
                "id_cupon:" . $x->id_cupon . " " .
                "Fecha:" . $x->fecha . " ";
        }
        $cadena .= "</ul>";
        echo $cadena;
    }

    public static function MostrarDatosInner($arrProductos)
    {

        $cadena = "<ul>";
        // Productos::guardarJSON($arrProductos);
        foreach ($arrProductos as $x) {
            $cadena .= "<li>" .
                "email:" . $x->email . " " .
                "numero_pedido:" . $x->numero_pedido . " " .
                "motivo:" . $x->motivo . " " .
                "id_cupon:" . $x->id_cupon . " " .
                "Fecha:" . $x->fecha . " ";
        }
        $cadena .= "</ul>";
        echo $cadena;
    }

    public static function mostrarCuponesUso($arrProductos)
    {

        // email , c'.".descuento".'  , motivo , d'.".fecha".' , id_cupon , usado 
        $cadena = "<ul>";
        // Productos::guardarJSON($arrProductos);
        foreach ($arrProductos as $x) {

            if ($x->usado == 1) {
                $x->usado = 'fue usado';
            } else {
                $x->usado = 'no fue usado';
            }

            $cadena .= "<li>" .
                "descuento:" . $x->descuento . "/     " .
                "motivo:" . $x->motivo . "/     " .
                "fecha:" . $x->fecha . "/       " .
                "id_cupon:" . $x->id_cupon . "/     " .
                "usado:" . $x->usado;
                
        }
        $cadena .= "</ul>";
        echo $cadena;
    }



    public function verificoPedidoExiste()
    {
        $retorno = false;

        $arrProductos = Pizza::TraerTodosLosProductos();
        $cadena = '';
        foreach ($arrProductos as $productos) {
            // MODIFICA SOLAMENTE STOCK
            if ($productos->numero_pedido == $this->numero_pedido) {
                $retorno = true;
                break;
            }
        }
        return $retorno;
    }



    //     6- (2 pts.)ConsultasDevoluciones.php:-
    // a-Listar las devoluciones con sus cupones.
    // b-Listar las devoluciones ordenadas por usuarios.
    // c-Listar las devoluciones ordenadas por fecha.

    public static function obtenerDevoluciones()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * FROM devoluciones");
        if ($consulta->execute()) {
            return $consulta->fetchAll(PDO::FETCH_OBJ);
        } else {
            echo 'err';
        }
    }

    public static function obtenerDevolucionesPorNombre()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta('SELECT email , v' . ".numero_pedido" . '  , motivo , d' . ".fecha" . ' , id_cupon FROM devoluciones d
        INNER JOIN venta v ' . ' ON  v.numero_pedido = d.numero_pedido ' . ' ORDER BY email ASC ');
        if ($consulta->execute()) {
            return $consulta->fetchAll(PDO::FETCH_OBJ);
        } else {
            echo 'err';
        }
    }

    public static function obtenerCuponesVerUso()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta('SELECT  c' . ".descuento" . '  , motivo , d' . ".fecha" . ' , id_cupon , usado FROM devoluciones d
        INNER JOIN cupones c ' . ' ON  c.numero_cupon = d.id_cupon ' . ' ORDER BY usado ASC ');
        if ($consulta->execute()) {
            return $consulta->fetchAll(PDO::FETCH_OBJ);
        } else {
            echo 'err';
        }
    }

    public static function obtenerDevolucionesPorFecha()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * FROM devoluciones ORDER BY fecha");
        if ($consulta->execute()) {
            return $consulta->fetchAll(PDO::FETCH_OBJ);
        } else {
            echo 'err';
        }
    }
}
