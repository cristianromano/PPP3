<?php

include_once "./clases/pizza.php";


class Cupon{

    public $descuento;
    public $precio;
    public $id_cupon;
    public $usado;


    public function __construct(float $precio = 0 , int $descuento) {
        $this->id_cupon = rand(1,1000);
        $this->precio = $precio;
        $this->descuento = $descuento;
        $this->usado = false;
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
                $descuento = ($this->descuento * $pizzaArr['precio'] / 100);
                $this->precio = $descuento;
                array_push($arrAux, $pizzaArr);
                $retorno = true;
            } else {
                array_push($arrAux, $pizzaArr);
            }
        }

        $json_string = json_encode($arrAux);
        $file = './archivos/Pizza.json';
        file_put_contents($file, $json_string);

        return $retorno;
    }














    
}
