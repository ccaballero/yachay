<?php 

class Xcel_Syn_Tree implements Xcel_Syn_Evaluable
{
    public $interpreted = 0;
    public $values = array();
    public $operators = array();

    // TURNES: VALUE, OPERATOR
    private $current = 'VALUE';

    public function add($element) {
        switch($this->current) {
        case 'VALUE':
            $this->values[] = $element;
            $this->current = 'OPERATOR';
            break;
        case 'OPERATOR':
            $this->operators[] = $element;
            $this->current = 'VALUE';
            break;
        }
    }

    public function clean() {
        $this->current = 'VALUE';
        $this->values = array();
        $this->operators = array();
    }

    public function getTurn() {
        return $this->current;
    }

    public function getValue(Xcel_Syn_Set $set = null) {
        // si las listas estan vacias se devuelve un valor neutro
        if (count($this->values) == 0) {
            return new Xcel_Syn_Value();
        }

        if (count($this->values) == count($this->operators) + 1) {
            $send = $this->values[0]->getValue();
            for ($i = 0; $i < count($this->operators); $i++) {
                // extraigo un operador
                $operator = $this->operators[$i];
                // extraigo un valor
                $value = $this->values[$i + 1];

                switch ($operator) {
                case 'ADDITION':        $send = Xcel_Syn_Value::add($send, $value->getValue());      break;
				case 'SUBTRACTION':     $send = Xcel_Syn_Value::subtract($send, $value->getValue()); break;
				case 'MULTIPLICATION':  $send = Xcel_Syn_Value::multiply($send, $value->getValue()); break;
				case 'DIVISION':        $send = Xcel_Syn_Value::divide($send, $value->getValue());   break;
				case 'MODULE':          $send = Xcel_Syn_Value::residue($send, $value->getValue());  break;
                }
            }
/*            echo 'RETORNANDO: ' . $send->extract() . '
';*/
            return $send;
        }
        return new Xcel_Syn_Value();
    }
}
