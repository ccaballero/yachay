<h1><?php echo $this->page->label ?></h1>

<form method="post" action="" accept-charset="utf-8">
    <input type="hidden" name="return" value="<?php echo $this->lastPage() ?>" />
    <p><label>Formula (*): </label><input type="text" name="formula" size="15" maxlength="300" value="<?php echo $this->formula ?>" /></p>
    <p>(*) Campos obligatorios.</p>
    <p class="submit"><input type="submit" value="Evaluar" /><input type="button" value="Cancelar" onclick="location.href='<?php echo $this->lastPage() ?>'" /></p>
</form>

<br />
<p class="message"><span class="bold">Resultado: </span><?php echo $this->result ?></p>

<h2>Lista de Funciones:</h2>
<p>Las siguientes funciones están disponibles:</p>
<dl>
    <dt>Funciones Aritmeticas:</dt>
    <dd>
        <p>Que pueden ser utilizados en la evaluacion de expresiones aritmeticas.</p>
        <dl>
            <dt>SUMA:</dt>
            <dd>
                <p>Suma todos las celdas o constantes que se ingresen.</p>
                <dl>
                    <dt>Ej:</dt>
                    <dd>
                        <p>SUMA (A1, A2, A3)</p>
                        <p>SUMA(A1, A2, 3, 4)</p>
                        <p>SUMA((B1 + B2) / 3, SUMA(A1, A3), A2)</p>
                    </dd>
                </dl>
            </dd>
            <dt>RESTA:</dt>
            <dd>
                <p>Resta todos los terminos que se ingresen, respetando del orden en el que se ingresaron.</p>
                <dl>
                    <dt>Ej:</dt>
                    <dd>
                        <p>RESTA(A1, A2, A3)</p>
                        <p>RESTA(A1, A2, 3, 4)</p>
                        <p>RESTA((B1 - B2) / 3, SUMA(A1, A3), A2)</p>
                    </dd>
                </dl>
            </dd>
            <dt>PRODUCTO:</dt>
            <dd>
                <p>Multiplica todos los elementos del conjunto ingresado.</p>
                <dl>
                    <dt>Ej:</dt>
                    <dd>
                        <p>PRODUCTO(A1, A2, A3)</p>
                        <p>PRODUCTO(A1, A2, 3, 4)</p>
                        <p>PRODUCTO((RESTA(C1, C2)) / 3, SUMA(A1, A3), A2)</p>
                    </dd>
                </dl>
            </dd>
            <dt>DIVISION:</dt>
            <dd>
                <p>Divide los elementos del conjunto respetando el orden en el que se ingresaron.</p>
                <dl>
                    <dt>Ej:</dt>
                    <dd>
                        <p>DIVISION(A1, A2, A3)</p>
                        <p>DIVISION(A1, A2, 3, 4)</p>
                        <p>DIVISION((RESTA(C1, C2)) / 3, SUMA(A1, A3), A2)</p>
                    </dd>
                </dl>
            </dd>
            <dt>MODULO:</dt>
            <dd>
                <p>Extrae el modulo resultante del conjunto de elementos que se ingresen.</p>
                <dl>
                    <dt>Ej:</dt>
                    <dd>
                        <p>MODULO(A1, A2, A3)</p>
                        <p>MODULO(A1, A2, 3, 4)</p>
                        <p>MODULO((RESTA(C1, C2)) / 3, DIVISION(A1, A3))</p>
                    </dd>
                </dl>
            </dd>
            <dt>ABSOLUTO:</dt>
            <dd>
                <p>Devuelve el valor absoluto del primer elemento del conjunto que se ingrese, por tanto las expresiones siguientes son equivalentes:</p>
                <dl>
                    <dt>Ej:</dt>
                    <dd>
                        <p>ABS(A1, A2, A3)</p>
                        <p>ABS(A1, A2, 3, 4)</p>
                        <p>ABS(A1, (RESTA(C1, C2)) / 3, DIVISION(A1, A3))</p>
                    </dd>
                </dl>
            </dd>
            <dt>RAIZ:</dt>
            <dd>
                <p>Extrae la raiz n-esima del primer termino utilizando los demas como radicales, es decir si se tiene RAIZ(340, 2, 3) se interpretaria como raiz cubica de la raiz cuadrada de 340. Por tanto las siguientes expresiones son equivalentes:</p>
                <dl>
                    <dt>Ej:</dt>
                    <dd>
                        <p>RAIZ(A1, 2, 3, A4)</p>
                        <p>RAIZ(A1, A4, 3, 2)</p>
                        <p>RAIZ(A1, PRODUCTO(A4, 3, 2))</p>
                    </dd>
                </dl>
            </dd>
            <dt>POTENCIA:</dt>
            <dd>
                <p>Extrae la n-esima potencia del primer termino utilizando los demas como exponentes, es decir si se tiene POTENCIA(340, 2) se interpretaria como 340 elevado al cuadrado. Por tanto las siguientes expresiones son equivalentes:</p>
                <dl>
                    <dt>Ej:</dt>
                    <dd>
                        <p>POTENCIA(A1, 2, 3, A4)</p>
                        <p>POTENCIA(A1, A4, 3, 2)</p>
                        <p>POTENCIA(A1, PRODUCTO(A4, 3, 2))</p>
                    </dd>
                </dl>
            </dd>
            <dt>ENTERO:</dt>
            <dd>
                <p>Convierte el primer elemento del conjunto, ya sea decimal o entero en un termino entero, es decir si tuviera 3.1415, se devolveria 3, por tanto son equivalentes las siguientes expresiones.</p>
                <dl>
                    <dt>Ej:</dt>
                    <dd>
                        <p>ENTERO(A1, 2, 3, A4)</p>
                        <p>ENTERO(A1)</p>
                    </dd>
                </dl>
            </dd>
            <dt>DECIMAL:</dt>
            <dd>
                <p>Convierte el primer elemento del conjunto, ya sea decimal o entero en un termino decimal, es decir si tuviera 3, se devolveria 3.00, esta funcion es de mucha utilidad combinada con la funcion RANDOM, por tanto son equivalentes las siguientes expresiones.</p>
                <dl>
                    <dt>Ej:</dt>
                    <dd>
                        <p>DECIMAL(A1, 2, 3, A4)</p>
                        <p>DECIMAL(A1)</p>
                    </dd>
                </dl>
            </dd>
        </dl>
    </dd>
    <dl>Funciones de Conjuntos:</dl>
    <dd>
        <p>Para el manejo de expresiones que contengan conjuntos de otras expresiones.</p>
        <dl>
            <dt>RANDOM:</dt>
            <dd>
                <p>Según el numero de elementos que se ingresen se presentan los siguientes casos:</p>
                <p>No contiene elementos: Entonces se devuelve un numero aleatorio entre 0 y 1.</p>
                <p>Un solo elemento: Entonces se devuelve un numero aleatorio entre 0 y el elemento que se ingreso, el numero devuelto sera del mismo tipo que el del elemento, es decir que si se ingreso un valor entero 3, el resultado podria ser 0 o 1 o 2 o 3, si se ingresa un elemento decimal si resultado seria un decimal del rango entre 0 y el elemento decimal.</p>
                <p>Dos elementos: Entonces se devuelve un numero aleatorio entre el elemento menor y el elemento mayor. Siempre respetandose el dominio de los elementos ingresados.</p>
                <dl>
                    <dt>Ej:</dt>
                    <dd>
                        <p>RANDOM()</p>
                        <p>RANDOM(A1)</p>
                        <p>RANDOM(A1, A2)</p>
                    </dd>
                </dl>
            </dd>
            <dt>SEMILLA:</dt>
            <dd>
                <p>Devuelve un elemento al azar del conjunto dado. Es decir si se ingresan 3, 4, 5; el resultado podria ser cualquier de estos tres valores.</p>
                <dl>
                    <dt>Ej:</dt>
                    <dd>
                        <p>SEMILLA(A1)</p>
                        <p>SEMILLA(A1, A2, A3)</p>
                        <p>SEMILLA(A1, (A2 + A3), RANDOM(), RANDOM())</p>
                    </dd>
                </dl>
            </dd>
            <dt>MAXIMO:</dt>
            <dd>
                <p>Devuelve el elemento maximo del conjunto de elementos ingresados.</p>
                <dl>
                    <dt>Ej:</dt>
                    <dd>
                        <p>MAX(A1)</p>
                        <p>MAX(A1, A2, A3)</p>
                        <p>MAX(A1, (A2 + A3), RANDOM(), RANDOM())</p>
                    </dd>
                </dl>
            </dd>
            <dt>MINIMO:</dt>
            <dd>
                <p>Devuelve el elemento maximo del conjunto de elementos ingresados.</p>
                <dl>
                    <dt>Ej:</dt>
                    <dd>
                        <p>MIN(A1)</p>
                        <p>MIN(A1, A2, A3)</p>
                        <p>MIN(A1, (A2 + A3), RANDOM(), RANDOM())</p>
                    </dd>
                </dl>
            </dd>
            <dt>PROMEDIO:</dt>
            <dd>
                <p>Devuelve el promedio calculado del conjunto de elementos ingresados.</p>
                <dl>
                    <dt>Ej:</dt>
                    <dd>
                        <p>PROMEDIO(A1)</p>
                        <p>PROMEDIO(A1, A2, A3)</p>
                        <p>PROMEDIO(A1, (A2 + A3), RANDOM(), RANDOM())</p>
                    </dd>
                </dl>
            </dd>
            <dt>ESCALA:</dt>
            <dd>
                <p>Devuelve el valor equivalente del primer parametro que esta en la escala [segundo parametro, tercer parametro] transformado a la escala [cuarto parametro, quinto parametro].</p>
                <dl>
                    <dt>Ej:</dt>
                    <dd>
                        <p>ESCALA(5, 0, 10, 0, 100)</p>
                    </dd>
                </dl>
            </dd>
            <dt>PROXIMO:</dt>
            <dd>
                <p>Devuelve el valor cuyo diferencia entre el primer parametro y el resto sea mas cercano, si hay mas de uno, retorna el primero encontrado.</p>
                <dl>
                    <dt>Ej:</dt>
                    <dd>
                        <p>PROXIMO(50, 0, 100)</p>
                    </dd>
                </dl>
            </dd>
        </dl>
    </dd>
</dl>
