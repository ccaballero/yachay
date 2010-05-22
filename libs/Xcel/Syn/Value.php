<?php

class Xcel_Syn_Value implements Xcel_Syn_Evaluable
{
    public $neutral = FALSE;
    // types: STRING, INT, FLOAT
    public $type;

    public $expression;
    public $value;

    // el constructor vacio sirve para crear valores neutros.
    public function Xcel_Syn_Value($value = null) {
        if ($value === 0) {
            $this->type = 'INT';
            $this->value = intval($value);
            return;
        }
        if (empty($value)) {
            $this->neutral = TRUE;
        } else if (is_float($value)) {
            $this->type = 'FLOAT';
            $this->value = floatval($value);
        } else if (is_int($value)) {
            $this->type = 'INT';
            $this->value = intval($value);
        } else {
            $this->type = 'STRING';
            $this->value = strval($value);
        }
    }

    public function extract() {
        if ($this->neutral) {
            return '???';
        }
        return $this->value;
	}

	public function getValue(Xcel_Syn_Set $set = null) {
	    return $this;
    }

    // Suma decimal o entera, si encuentra cadenas las concatena
    public static function add(Xcel_Syn_Value $v1, Xcel_Syn_Value $v2) {
        // primero reviso que no sean objetos neutros
        if ($v1->neutral) {
            return $v2;
        }
        if ($v2->neutral) {
            return $v1;
        }

        switch ($v1->type) {
        case 'FLOAT':
            switch ($v2->type) {
            case 'FLOAT':    return new Xcel_Syn_Value(floatval($v1->extract() + $v2->extract()));     // es una suma decimal
            case 'INT':      return new Xcel_Syn_Value(floatval($v1->extract() + $v2->extract()));     // es una suma decimal
            case 'STRING':   return new Xcel_Syn_Value($v1->extract() . $v2->extract());	              // concatenacion
            }
        case 'INT':
            switch ($v2->type) {
            case 'FLOAT':    return new Xcel_Syn_Value(floatval($v1->extract() + $v2->extract()));     // es una suma decimal
            case 'INT':      return new Xcel_Syn_Value(intval($v1->extract() + $v2->extract()));       // es una suma entera
            case 'STRING':   return new Xcel_Syn_Value($v1->extract() . $v2->extract());               // concatenacion
            }
        case 'STRING':
            switch ($v2->type) {
            case 'FLOAT':    return new Xcel_Syn_Value($v1->extract() . $v2->extract());               // concatenacion
            case 'INT':      return new Xcel_Syn_Value($v1->extract() . $v2->extract());               // concatenacion
            case 'STRING':   return new Xcel_Syn_Value($v1->extract() . $v2->extract());               // concatenacion
            }
        }
    }

    public static function subtract(Xcel_Syn_Value $v1, Xcel_Syn_Value $v2) {
        // primero reviso que no sean objetos neutros
        if ($v1->neutral) {
            return $v2;
        }
        if ($v2->neutral) {
            return $v1;
        }

        switch ($v1->type) {
        case 'FLOAT':
            switch ($v2->type) {
            case 'FLOAT':    return new Xcel_Syn_Value(floatval($v1->extract() - $v2->extract()));     // es una resta decimal
            case 'INT':      return new Xcel_Syn_Value(floatval($v1->extract() - $v2->extract()));     // es una resta decimal
            case 'STRING':   return;                                                                   // no valido
            }
        case 'INT':
            switch ($v2->type) {
            case 'FLOAT':    return new Xcel_Syn_Value(floatval($v1->extract() - $v2->extract()));     // es una resta decimal
            case 'INT':      return new Xcel_Syn_Value(intval($v1->extract() - $v2->extract()));       // es una resta entera
            case 'STRING':   return;                                                                   // no valido
            }
        }
    }

    public static function multiply(Xcel_Syn_Value $v1, Xcel_Syn_Value $v2) {
        // primero reviso que no sean objetos neutros
        if ($v1->neutral) {
            return $v2;
        }
        if ($v2->neutral) {
            return $v1;
        }

        switch ($v1->type) {
        case 'FLOAT':
            switch ($v2->type) {
            case 'FLOAT':    return new Xcel_Syn_Value(floatval($v1->extract() * $v2->extract()));     // es un producto decimal
            case 'INT':      return new Xcel_Syn_Value(floatval($v1->extract() * $v2->extract()));     // es un producto decimal
            case 'STRING':   return;                                                                   // no valido
            }
        case 'INT':
            switch ($v2->type) {
            case 'FLOAT':    return new Xcel_Syn_Value(floatval($v1->extract() * $v2->extract()));     // es un producto decimal
            case 'INT':      return new Xcel_Syn_Value(intval($v1->extract() * $v2->extract()));       // es un producto entero
            case 'STRING':   return;                                                                   // no valido
            }
        }
    }

    public static function divide(Xcel_Syn_Value $v1, Xcel_Syn_Value $v2) {
        // primero reviso que no sean objetos neutros
        if ($v1->neutral) {
            return $v2;
        }
        if ($v2->neutral) {
            return $v1;
        }
        if ($v2->extract() === 0) {
            return new Xcel_Syn_Value();
        }

        switch ($v1->type) {
        case 'FLOAT':
            switch ($v2->type) {
            case 'FLOAT':    return new Xcel_Syn_Value(floatval($v1->extract() / $v2->extract()));     // es una division decimal
            case 'INT':      return new Xcel_Syn_Value(floatval($v1->extract() / $v2->extract()));     // es una division decimal
            case 'STRING':   return;                                                                   // no valido
            }
        case 'INT':
            switch ($v2->type) {
            case 'FLOAT':    return new Xcel_Syn_Value(floatval($v1->extract() / $v2->extract()));     // es una division decimal
            case 'INT':
                if ($v1->extract() % $v2->extract() == 0) {                                            // es una division entera
                    return new Xcel_Syn_Value(intval($v1->extract() / $v2->extract()));
                } else {
                    return new Xcel_Syn_Value(floatval($v1->extract() / $v2->extract()));
                }
            case 'STRING':   return;                                                                    // no valido
            }
        }
    }

    public static function residue(Xcel_Syn_Value $v1, Xcel_Syn_Value $v2) {
        // primero reviso que no sean objetos neutros
        if ($v1->neutral) {
            return $v2;
        }
        if ($v2->neutral) {
            return $v1;
        }
        if ($v2->extract() === 0) {
            return new Xcel_Syn_Value();
        }

        switch ($v1->type) {
        case 'FLOAT':
            switch ($v2->type) {
            case 'FLOAT':    return new Xcel_Syn_Value(floatval($v1->extract() % $v2->extract()));     // es un resto decimal
            case 'INT':      return new Xcel_Syn_Value(floatval($v1->extract() % $v2->extract()));     // es un resto decimal
            case 'STRING':   return;                                                                   // no valido
            }
        case 'INT':
            switch ($v2->type) {
            case 'FLOAT':    return new Xcel_Syn_Value(floatval($v1->extract() % $v2->extract()));     // es un resto decimal
            case 'INT':      return new Xcel_Syn_Value(intval($v1->extract() % $v2->extract()));       // es un resto entero
            case 'STRING':   return;                                                                   // no valido
            }
        }
    }
}
