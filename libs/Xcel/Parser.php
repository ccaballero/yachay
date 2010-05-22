<?php

abstract class Xcel_Parser
{
    public function parse($expression = '') {
        $evaluable = $this->generateTree(trim($expression), 'TREE');
        $value = $evaluable->getValue();
        $value->expression = $expression;
        return $value;
    }

    private function generateTree($expression = '', $type) {
        $tree = new Xcel_Syn_Tree();
        $set = new Xcel_Syn_Set();

        $acumulator = '';
        $number = TRUE;
        $point = FALSE;

        for ($i = 0; $i < strlen($expression); $i++) {
            // los elementos validos son: letras, numeros, +, -, *, /, %, (, ), ., un espacio
            $c = $expression[$i];
            switch ($c) {
            case '(':
                if (Xcel_Syn_Function::isFunctionValid(trim($acumulator))) {      // se ingreso una funcion
                    $aux1 = $this->generateTree(substr($expression, $i + 1), 'SET');
                    $func = Xcel_Syn_Function::fetchFunction(trim($acumulator));
                    $value = $func->getValue($aux1);
                    $tree->add($value);
                    $i += $aux1->interpreted;
                    $acumulator = '';
                    $number = TRUE;
                    $point = FALSE;
                } else {
                    $aux2 = $this->generateTree(substr($expression, $i + 1), 'TREE');
                    $tree->add($aux2->getValue());
                    $i += $aux2->interpreted;
                }
                break;
            case ')':
                if ($type == 'SET') {
                    if ($tree->getTurn() == 'VALUE') {
                        if (trim($acumulator) != '') {
                            $value = $this->addValue($number, $point, trim($acumulator));
                            $tree->add($value);
                        }
                    }
                    $set->addElement($tree->getValue());
                    $tree->clean();
                    $acumulator = '';
                    $number = TRUE;
                    $point = FALSE;
                    $set->interpreted = $i + 1;
                } else {
                    $tree->interpreted = $i + 1;      // longitud de lo que haya dentro del parentesis.
                }

                $i = strlen($expression);
                break;
            case '+':
                if ($tree->getTurn() == 'VALUE') {
                    $value = $this->addValue($number, $point, trim($acumulator));
                    $tree->add($value);
                }
                $tree->add('ADDITION');
                $acumulator = '';
                $number = TRUE;
                $point = FALSE;
                break;
            case '-':
                if ($tree->getTurn() == 'VALUE' && trim($acumulator) == '') {
                    $acumulator .= $c;
                } else {
                    if ($tree->getTurn() == 'VALUE') {
                        $value = $this->addValue($number, $point, trim($acumulator));
                        $tree->add($value);
                    }
                    $tree->add('SUBTRACTION');
                    $acumulator = '';
                    $number = TRUE;
                    $point = FALSE;
                }
                break;
            case '*':
                if ($tree->getTurn() == 'VALUE') {
                    $value = $this->addValue($number, $point, trim($acumulator));
                    $tree->add($value);
                }
                $tree->add('MULTIPLICATION');
                $acumulator = '';
                $number = TRUE;
                $point = FALSE;
                break;
			case '/':
				if ($tree->getTurn() == 'VALUE') {
                    $value = $this->addValue($number, $point, trim($acumulator));
                    $tree->add($value);
                }
                $tree->add('DIVISION');
                $acumulator = '';
                $number = TRUE;
                $point = FALSE;
                break;
			case '%':
				if ($tree->getTurn() == 'VALUE') {
                    $value = $this->addValue($number, $point, trim($acumulator));
                    $tree->add($value);
                }
                $tree->add('MODULE');
                $acumulator = '';
                $number = TRUE;
                $point = FALSE;
                break;
            case ' ':
                $acumulator .= $c;
                break;
            case ',':
                if ($tree->getTurn() == 'VALUE') {
                    $value = $this->addValue($number, $point, trim($acumulator));
                    $tree->add($value);
                }
                $set->addElement($tree->getValue());
                $tree->clean();
                $acumulator = '';
                $number = TRUE;
                $point = FALSE;
                break;
            case '.':
                if (!$point) {
                    $point = TRUE;
                    $acumulator .= $c;
                    break;
                }
            default:
                $acumulator .= $c;
                if (is_numeric($c)) {
                    $number &= TRUE;
                } else {
                    $number &= FALSE;
                }
            }
        }

        if (trim($acumulator) != '') {
            $value = $this->addValue($number, $point, $acumulator);
            $tree->add($value);
        }

        if ($type == 'SET') {
            return $set;
        }
        return $tree;
    }

    private function addValue($number, $point, $acumulator = '') {
        $add = new Xcel_Syn_Value();
        if ($number) {
            if ($point) {
                $add = new Xcel_Syn_Value(floatval(trim($acumulator)));
            } else {
                $add = new Xcel_Syn_Value(intval(trim($acumulator)));
            }
        } else {
            if ($this->isVariableValid(trim($acumulator))) {
                $add = $this->fetchValue(trim($acumulator));
            } else {
                $add = new Xcel_Syn_Value($acumulator);
            }
        }
        return $add;
    }

    abstract function isVariableValid($variable);
    abstract function fetchValue($variable);
}
