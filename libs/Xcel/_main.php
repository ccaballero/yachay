<?php

include ('Parser.php');
include ('Alone/Parser.php');

include('Syn/Evaluable.php');
include('Syn/Function.php');
include('Syn/Set.php');
include('Syn/Tree.php');
include('Syn/Value.php');

include('Functions/Absoluto.php');
include('Functions/Decimal.php');
include('Functions/Division.php');
include('Functions/Entero.php');
include('Functions/Escala.php');
include('Functions/Maximo.php');
include('Functions/Minimo.php');
include('Functions/Modulo.php');
include('Functions/Potencia.php');
include('Functions/Producto.php');
include('Functions/Promedio.php');
include('Functions/Proximo.php');
include('Functions/Raiz.php');
include('Functions/Random.php');
include('Functions/Resta.php');
include('Functions/Semilla.php');
include('Functions/Suma.php');

if (!isset($argv[1])) {
    echo 'No se establecio una expresion a evaluar.
';
    die;
}

global $CONFIG;
$CONFIG->dirroot = '/home/ubuntu/public_html/';

$expression = $argv[1];
$parser = new Xcel_Alone_Parser();
$value = $parser->parse($expression);

echo 'Expresion: [' . $expression . '] = [' . $value->extract() . ']
';
