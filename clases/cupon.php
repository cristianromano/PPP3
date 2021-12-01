<?php

include_once "./clases/pizza.php";


class Cupon{

    public $descuento;
    // public $precio;
    public $id_cupon;
    public $usado;

    // public $numero_cupon;
    public $precio_descontado;


    // public function __construct(float $precio = 0 , int $descuento , int $id_cupon) {
    //     $this->id_cupon = $id_cupon;
    //     $this->precio = $precio;
    //     $this->descuento = $descuento;
    //     $this->usado = false;
    // }

    public static function crearCupon($descuento, $precio_descontado, $id_cupon , $usado)
    {
        $cupon  = new Cupon();
        $cupon ->descuento = $descuento;
        $cupon ->precio_descontado = $precio_descontado;
        $cupon ->id_cupon = $id_cupon;
        $cupon ->usado = $usado;

        return $cupon ;
    }

    public function __construct() {
      
    }

    public static function guardarJSON($objeto)
    {
        $json_string = json_encode($objeto);
        $file = './archivos/Cupon.json';
        file_put_contents($file, $json_string);
    }


    public function verificarJSON($pizza)
    {
        $retorno = false;
        $arrAux = array();
        $datos_productos = file_get_contents('./archivos/Pizza.json');
        $arrayPizza = json_decode($datos_productos, true);
        foreach ($arrayPizza as $pizzaArr) {
            if (strcmp($pizzaArr['sabor'], $pizza->sabor) == 0 && strcmp($pizzaArr['tipo'], $pizza->tipo) == 0) {
                $this->usado = true;
                $total = $pizza->cantidad * $pizzaArr['precio'];
                $descuento = (($this->descuento * $total) / 100);
                $pizza->descuento = 'tiene descuento de: $'.$descuento;
                
                $pizza->precio =  $total - $descuento;
                $this->precio = $descuento;
                $pizza->numero_descuento = $this->id_cupon;
                array_push($arrAux, $pizzaArr);
                $retorno = true;
                break;
            } else {
                array_push($arrAux, $pizzaArr);
            }
        }

        $json_string = json_encode($arrAux);
        $file = './archivos/Pizza.json';
        file_put_contents($file, $json_string);

        return $retorno;
    }



    public static function obtenerCuponesJSON()
    {
        $datos_productos = file_get_contents('./archivos/Cupon.json');
        $arrayProductos = json_decode($datos_productos, true);
        return $arrayProductos;
    }

    public  function cambiarEstadoCupon()
    {
        $retorno = false;
        $arrAux = array();
        $datos_productos = file_get_contents('./archivos/Cupon.json');
        $arrayProductos = json_decode($datos_productos, true);
        foreach ($arrayProductos as $prod) {
            if ($prod['id_cupon'] == $this->id_cupon) {
                echo 'hola';
                $prod['usado'] = true;
                $prod['precio'] = $this->precio;
                array_push($arrAux, $prod);
                $retorno = true;
                
            } else {
                array_push($arrAux, $prod);
            }
        }

        $json_string = json_encode($arrAux);
        $file = './archivos/Cupon.json';
        file_put_contents($file, $json_string);

        return $retorno;
    }


    public function insertarCupon()
    {           //`id`, `codigo`, `nombre`, `tipo`, `stock`, `precio`, `fecha_de_creacion`, `fecha_de_modificacion`
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("INSERT INTO cupones(descuento,precio_descontado,numero_cupon,usado) 
               VALUES (:descuento,:precio_descontado,:numero_cupon,:usado)");
        $consulta->bindValue(':descuento', $this->descuento, PDO::PARAM_INT);
        $consulta->bindValue(':precio_descontado', $this->precio_descontado, PDO::PARAM_STR);
        $consulta->bindValue(':numero_cupon', $this->id_cupon, PDO::PARAM_STR);
        $consulta->bindValue(':usado', $this->usado, PDO::PARAM_INT);
        // $consulta->bindValue(':id_pedido', $this->id_pedido, PDO::PARAM_INT);
        $consulta->execute();
        return $objetoAccesoDato->RetornarUltimoIdInsertado();
    }

    public function updateCupon()
    {           //`id`, `codigo`, `nombre`, `tipo`, `stock`, `precio`, `fecha_de_creacion`, `fecha_de_modificacion`
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("UPDATE cupones SET descuento = :descuento , precio_descontado = :precio_descontado
        , usado = :usado WHERE numero_cupon = :numero_cupon ");

        $consulta->bindValue(':descuento', $this->descuento, PDO::PARAM_INT);
        $consulta->bindValue(':precio_descontado', $this->precio_descontado, PDO::PARAM_STR);
        $consulta->bindValue(':numero_cupon', $this->id_cupon, PDO::PARAM_STR);
        $consulta->bindValue(':usado', $this->usado, PDO::PARAM_INT);
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
                "descuento:" . $x->descuento . " " .
                "precio descontado:" . $x->precio_descontado . " " .
                "id_cupon:" . $x->numero_cupon . " " .
                "usado:" . $x->usado;
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
                "precio descontado:" . $x->descuento . " " .
                "id_cupon:" . $x->numero_pedido . " " .
                "usado:" . $x->usado;
        }
        $cadena .= "</ul>";
        echo $cadena;
    }



//     7- (2 pts.)ConsultasCuponesz.php:-
// a-Listar todos los cupones y su estado.
// b-Listar todos los cupones ordenados por usuarios.
// b-Listar todos los cupones por fecha, desde una fecha en particular.

public static function obtenerCupones()
{
    $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
    $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * FROM cupones");
    if ($consulta->execute()) {
        return $consulta->fetchAll(PDO::FETCH_OBJ);
    } else {
        echo 'err';
    }
}

public static function obtenerCuponesUsuario()
{
    $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
    $consulta = $objetoAccesoDato->RetornarConsulta('SELECT email , v'.".numero_pedido".'  ,  c'.".descuento".' , v'.".fecha".' , usado  FROM cupones c
    INNER JOIN venta v '. ' ON  v.numero_descuento = c.numero_cupon ' . ' ORDER BY email ASC ');
    if ($consulta->execute()) {
        return $consulta->fetchAll(PDO::FETCH_OBJ);
    } else {
        echo 'err';
    }
}

public static function obtenerCuponesFecha($fecha)
{
    $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
    $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * FROM cupones WHERE fecha >= :fecha");
    $consulta->bindValue(':fecha', $fecha, PDO::PARAM_STR);
    if ($consulta->execute()) {
        return $consulta->fetchAll(PDO::FETCH_OBJ);
    } else {
        echo 'err';
    }
}





    
}
