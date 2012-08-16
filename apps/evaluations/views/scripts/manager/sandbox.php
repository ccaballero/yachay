<?php

echo '<h1>' . $this->route->label .'</h1>';

echo '<table border="1" width="100%">';
echo '<tr><td width="50%"><center>';
echo '<form method="post" action="" accept-charset="utf-8">';
echo '<input type="hidden" name="return" value="' . $this->lastPage() . '" />';
echo '<table>';
echo '<tr><td><b>Formula (*):</b></td><td><input type="text" name="formula" size="50" maxlength="300" value="' . $this->formula . '" /></td></tr>';
echo '<tr><td colspan="2">(*) Campos obligatorios.</td></tr>';
echo '<tr><td>&nbsp;</td><td><input type="submit" value="Evaluar formula" /> <a href="' . $this->lastPage() . '">Cancelar</a></td></tr>';
echo '</table>';
echo '</form>';
echo '</center></td>';
echo '<td width="50%"><center>';
echo '<p>' . $this->result . '</p>';
echo '</center></td></tr>';
echo '</table>';

echo '<h2>Lista de Funciones:</h2>
<p>Las siguientes funciones están disponibles:</p>
<table>
    <tr><td colspan="3"><b>Funciones Aritmeticas: </b>Que pueden ser utilizados en la evaluacion de expresiones aritmeticas.</td></tr>
    <tr><td>&nbsp;</td><td colspan="2"><b>SUMA: </b>Suma todos las celdas o constantes que se ingresen.</td></tr>
    <tr><td>&nbsp;</td><td><b>Ej:</b></td><td>&nbsp;</td></tr>
    <tr><td>&nbsp;</td><td>&nbsp;</td><td>SUMA(A1, A2, A3)</td></tr>
    <tr><td>&nbsp;</td><td>&nbsp;</td><td>SUMA(A1, A2, 3, 4)</td></tr>
    <tr><td>&nbsp;</td><td>&nbsp;</td><td>SUMA((B1 + B2) / 3, SUMA(A1, A3), A2)</td></tr>
    <tr><td>&nbsp;</td><td colspan="2"><b>RESTA: </b>Resta todos los terminos que se ingresen, respetando del orden en el que se ingresaron.</td></tr>
    <tr><td>&nbsp;</td><td><b>Ej:</b></td><td>&nbsp;</td></tr>
    <tr><td>&nbsp;</td><td>&nbsp;</td><td>RESTA(A1, A2, A3)</td></tr>
    <tr><td>&nbsp;</td><td>&nbsp;</td><td>RESTA(A1, A2, 3, 4)</td></tr>
    <tr><td>&nbsp;</td><td>&nbsp;</td><td>RESTA((B1 - B2) / 3, SUMA(A1, A3), A2)</td></tr>
    <tr><td>&nbsp;</td><td colspan="2"><b>PRODUCTO: </b>Multiplica todos los elementos del conjunto ingresado.</td></tr>
    <tr><td>&nbsp;</td><td><b>Ej:</b></td><td>&nbsp;</td></tr>
    <tr><td>&nbsp;</td><td>&nbsp;</td><td>PRODUCTO(A1, A2, A3)</td></tr>
    <tr><td>&nbsp;</td><td>&nbsp;</td><td>PRODUCTO(A1, A2, 3, 4)</td></tr>
    <tr><td>&nbsp;</td><td>&nbsp;</td><td>PRODUCTO((RESTA(C1, C2)) / 3, SUMA(A1, A3), A2)</td></tr>
    <tr><td>&nbsp;</td><td colspan="2"><b>DIVISION: </b>Divide los elementos del conjunto respetando el orden en el que se ingresaron.</td></tr>
    <tr><td>&nbsp;</td><td><b>Ej:</b></td><td>&nbsp;</td></tr>
    <tr><td>&nbsp;</td><td>&nbsp;</td><td>DIVISION(A1, A2, A3)</td></tr>
    <tr><td>&nbsp;</td><td>&nbsp;</td><td>DIVISION(A1, A2, 3, 4)</td></tr>
    <tr><td>&nbsp;</td><td>&nbsp;</td><td>DIVISION((RESTA(C1, C2)) / 3, SUMA(A1, A3), A2)</td></tr>
    <tr><td>&nbsp;</td><td colspan="2"><b>MODULO: </b>Extrae el modulo resultante del conjunto de elementos que se ingresen.</td></tr>
    <tr><td>&nbsp;</td><td><b>Ej:</b></td><td>&nbsp;</td></tr>
    <tr><td>&nbsp;</td><td>&nbsp;</td><td>MODULO(A1, A2, A3)</td></tr>
    <tr><td>&nbsp;</td><td>&nbsp;</td><td>MODULO(A1, A2, 3, 4)</td></tr>
    <tr><td>&nbsp;</td><td>&nbsp;</td><td>MODULO((RESTA(C1, C2)) / 3, DIVISION(A1, A3))</td></tr>
    <tr><td>&nbsp;</td><td colspan="2"><b>ABSOLUTO: </b>Devuelve el valor absoluto del primer elemento del conjunto que se ingrese, por tanto las expresiones siguientes son equivalentes:</td></tr>
    <tr><td>&nbsp;</td><td><b>Ej:</b></td><td>&nbsp;</td></tr>
    <tr><td>&nbsp;</td><td>&nbsp;</td><td>ABS(A1, A2, A3)</td></tr>
    <tr><td>&nbsp;</td><td>&nbsp;</td><td>ABS(A1, A2, 3, 4)</td></tr>
    <tr><td>&nbsp;</td><td>&nbsp;</td><td>ABS(A1, (RESTA(C1, C2)) / 3, DIVISION(A1, A3))</td></tr>
    <tr><td>&nbsp;</td><td colspan="2"><b>RAIZ: </b>Extrae la raiz n-esima del primer termino utilizando los demas como radicales, es decir si se tiene RAIZ(340, 2, 3) se interpretaria como raiz cubica de la raiz cuadrada de 340. Por tanto las siguientes expresiones son equivalentes:</td></tr>
    <tr><td>&nbsp;</td><td><b>Ej:</b></td><td>&nbsp;</td></tr>
    <tr><td>&nbsp;</td><td>&nbsp;</td><td>RAIZ(A1, 2, 3, A4)</td></tr>
    <tr><td>&nbsp;</td><td>&nbsp;</td><td>RAIZ(A1, A4, 3, 2)</td></tr>
    <tr><td>&nbsp;</td><td>&nbsp;</td><td>RAIZ(A1, PRODUCTO(A4, 3, 2))</td></tr>
    <tr><td>&nbsp;</td><td colspan="2"><b>POTENCIA: </b>Extrae la n-esima potencia del primer termino utilizando los demas como exponentes, es decir si se tiene POTENCIA(340, 2) se interpretaria como 340 elevado al cuadrado. Por tanto las siguientes expresiones son equivalentes:</td></tr>
    <tr><td>&nbsp;</td><td><b>Ej:</b></td><td>&nbsp;</td></tr>
    <tr><td>&nbsp;</td><td>&nbsp;</td><td>POTENCIA(A1, 2, 3, A4)</td></tr>
    <tr><td>&nbsp;</td><td>&nbsp;</td><td>POTENCIA(A1, A4, 3, 2)</td></tr>
    <tr><td>&nbsp;</td><td>&nbsp;</td><td>POTENCIA(A1, PRODUCTO(A4, 3, 2))</td></tr>
    <tr><td>&nbsp;</td><td colspan="2"><b>ENTERO: </b>Convierte el primer elemento del conjunto, ya sea decimal o entero en un termino entero, es decir si tuviera 3.1415, se devolveria 3, por tanto son equivalentes las siguientes expresiones.</td></tr>
    <tr><td>&nbsp;</td><td><b>Ej:</b></td><td>&nbsp;</td></tr>
    <tr><td>&nbsp;</td><td>&nbsp;</td><td>ENTERO(A1, 2, 3, A4)</td></tr>
    <tr><td>&nbsp;</td><td>&nbsp;</td><td>ENTERO(A1)</td></tr>
    <tr><td>&nbsp;</td><td colspan="2"><b>DECIMAL: </b>Convierte el primer elemento del conjunto, ya sea decimal o entero en un termino decimal, es decir si tuviera 3, se devolveria 3.00, esta funcion es de mucha utilidad combinada con la funcion RANDOM, por tanto son equivalentes las siguientes expresiones.</td></tr>
    <tr><td>&nbsp;</td><td><b>Ej:</b></td><td>&nbsp;</td></tr>
    <tr><td>&nbsp;</td><td>&nbsp;</td><td>DECIMAL(A1, 2, 3, A4)</td></tr>
    <tr><td>&nbsp;</td><td>&nbsp;</td><td>DECIMAL(A1)</td></tr>
    <tr><td>&nbsp;&nbsp;</td><td><b>&nbsp;</b></td><td>&nbsp;</td></tr>
    <tr><td colspan="3"><b>Funciones de Conjuntos: </b>Para el manejo de expresiones que contengan conjuntos de otras expresiones.</td></tr>
    <tr><td>&nbsp;</td><td colspan="2"><b>RANDOM: </b>Según el numero de elementos que se ingresen se presentan los siguientes casos:</td></tr>
    <tr><td>&nbsp;</td><td>&nbsp;</td><td><b>No contiene elementos:</b> Entonces se devuelve un numero aleatorio entre 0 y 1.</td></tr>
    <tr><td>&nbsp;</td><td>&nbsp;</td><td><b>Un solo elemento:</b> Entonces se devuelve un numero aleatorio entre 0 y el elemento que se ingreso, el numero devuelto sera del mismo tipo que el del elemento, es decir que si se ingreso un valor entero 3, el resultado podria ser 0 o 1 o 2 o 3, si se ingresa un elemento decimal si resultado seria un decimal del rango entre 0 y el elemento decimal.</td></tr>
    <tr><td>&nbsp;</td><td>&nbsp;</td><td><b>Dos elementos:</b> Entonces se devuelve un numero aleatorio entre el elemento menor y el elemento mayor. Siempre respetandose el dominio de los elementos ingresados.</td></tr>
    <tr><td>&nbsp;</td><td><b>Ej:</b></td><td>&nbsp;</td></tr>
    <tr><td>&nbsp;</td><td>&nbsp;</td><td>RANDOM()</td></tr>
    <tr><td>&nbsp;</td><td>&nbsp;</td><td>RANDOM(A1)</td></tr>
    <tr><td>&nbsp;</td><td>&nbsp;</td><td>RANDOM(A1, A2)</td></tr>
    <tr><td>&nbsp;</td><td colspan="2"><b>SEMILLA: </b>Devuelve un elemento al azar del conjunto dado. Es decir si se ingresan 3, 4, 5; el resultado podria ser cualquier de estos tres valores.</td></tr>
    <tr><td>&nbsp;</td><td><b>Ej:</b></td><td>&nbsp;</td></tr>
    <tr><td>&nbsp;</td><td>&nbsp;</td><td>SEMILLA(A1)</td></tr>
    <tr><td>&nbsp;</td><td>&nbsp;</td><td>SEMILLA(A1, A2, A3)</td></tr>
    <tr><td>&nbsp;</td><td>&nbsp;</td><td>SEMILLA(A1, (A2 + A3), RANDOM(), RANDOM())</td></tr>
    <tr><td>&nbsp;</td><td colspan="2"><b>MAXIMO: </b>Devuelve el elemento maximo del conjunto de elementos ingresados.</td></tr>
    <tr><td>&nbsp;</td><td><b>Ej:</b></td><td>&nbsp;</td></tr>
    <tr><td>&nbsp;</td><td>&nbsp;</td><td>MAX(A1)</td></tr>
    <tr><td>&nbsp;</td><td>&nbsp;</td><td>MAX(A1, A2, A3)</td></tr>
    <tr><td>&nbsp;</td><td>&nbsp;</td><td>MAX(A1, (A2 + A3), RANDOM(), RANDOM())</td></tr>
    <tr><td>&nbsp;</td><td colspan="2"><b>MINIMO: </b>Devuelve el elemento maximo del conjunto de elementos ingresados.</td></tr>
    <tr><td>&nbsp;</td><td><b>Ej:</b></td><td>&nbsp;</td></tr>
    <tr><td>&nbsp;</td><td>&nbsp;</td><td>MIN(A1)</td></tr>
    <tr><td>&nbsp;</td><td>&nbsp;</td><td>MIN(A1, A2, A3)</td></tr>
    <tr><td>&nbsp;</td><td>&nbsp;</td><td>MIN(A1, (A2 + A3), RANDOM(), RANDOM())</td></tr>
    <tr><td>&nbsp;</td><td colspan="2"><b>PROMEDIO: </b>Devuelve el promedio calculado del conjunto de elementos ingresados.</td></tr>
    <tr><td>&nbsp;</td><td><b>Ej:</b></td><td>&nbsp;</td></tr>
    <tr><td>&nbsp;</td><td>&nbsp;</td><td>PROMEDIO(A1)</td></tr>
    <tr><td>&nbsp;</td><td>&nbsp;</td><td>PROMEDIO(A1, A2, A3)</td></tr>
    <tr><td>&nbsp;</td><td>&nbsp;</td><td>PROMEDIO(A1, (A2 + A3), RANDOM(), RANDOM())</td></tr>
    <tr><td>&nbsp;</td><td colspan="2"><b>ESCALA: </b>Devuelve el valor equivalente del primer parametro que esta en la escala [segundo parametro, tercer parametro] transformado a la escala [cuarto parametro, quinto parametro].</td></tr>
    <tr><td>&nbsp;</td><td><b>Ej:</b></td><td>&nbsp;</td></tr>
    <tr><td>&nbsp;</td><td>&nbsp;</td><td>ESCALA(5, 0, 10, 0, 100)</td></tr>
    <tr><td>&nbsp;</td><td colspan="2"><b>PROXIMO: </b>Devuelve el valor cuyo diferencia entre el primer parametro y el resto sea mas cercano, si hay mas de uno, retorna el primero encontrado.</td></tr>
    <tr><td>&nbsp;</td><td><b>Ej:</b></td><td>&nbsp;</td></tr>
    <tr><td>&nbsp;</td><td>&nbsp;</td><td>PROXIMO(50, 0, 100)</td></tr>
</table>';
