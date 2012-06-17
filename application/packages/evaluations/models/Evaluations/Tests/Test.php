<?php

class Evaluations_Tests_Test extends Yachay_Models_Row_Validation
{
    protected $_foreignkey = 'evaluation';

    protected $_validationRules = array(
        'label' => array(
            'filters' => array('StringTrim'),
            'validators' => array(
                array(
                    'validator' => 'NotEmpty',
                    'message'   => 'El nombre de la calificacion no puede estar vacio',
                ),
                array(
                    'validator' => 'StringLength',
                    'options'   => array(1, 64),
                    'message'   => 'El nombre de la calificacion debe tener entre 1 y 64 caracteres',
                ),
                array(
                    'validator' => 'UniqueLabelDual',
                    'options'   => array('Evaluations_Tests'),
                    'message'   => 'El nombre seleccionado para la calificacion ya existe o no puede utilizarse',
                    'namespace' => 'Yachay_Validators',
                ),
            ),
        ),
        'key' => array(
            'filters' => array('StringTrim', 'StringToUpper'),
            'validators' => array(
                array(
                    'validator' => 'NotEmpty',
                    'message'   => 'El codigo de calificacion no puede estar vacio', 
                ),
                array(
                    'validator' => 'StringLength',
                    'options'   => array(1, 4),
                    'message'   => 'El codigo de la calificacion debe tener entre 1 y 4 caracteres',
                ),
                array(
                    'validator' => 'Regex',
                    'options'   => array('/^[\w\s]+$/i'),
                    'message'   => 'El codigo de la calificacion debe contener unicamente caracteres y numeros',
                ),
                array(
                    'validator' => 'UniqueKeyDual',
                    'options'   => array('Evaluations_Tests'),
                    'message'   => 'El nombre seleccionado para la calificacion ya existe o no puede utilizarse',
                    'namespace' => 'Yachay_Validators',
                ),
            ),
        ),
        'minimumnote' => array(
            'filters' => array('StringTrim', 'Int'),
            'validators' => array(
                array(
                    'validator' => 'Between',
                    'options'   => array(0, 99),
                    'message'   => 'La nota minima no es valida',
                ),
            ),
        ),
        'defaultnote' => array(
            'filters' => array('StringTrim', 'Int'),
            'validators' => array(
                array(
                    'validator' => 'Between',
                    'options'   => array(0, 100),
                    'message'   => 'La nota por omision no es valida',
                ),
            ),
        ),
        'maximumnote' => array(
            'filters' => array('StringTrim', 'Int'),
            'validators' => array(
                array(
                    'validator' => 'Between',
                    'options'   => array(1, 100),
                    'message'   => 'La nota maxima no es valida',
                ),
            ),
        ),
        'formula' => array(
            'filters' => array('StringTrim', 'StripNewlines', 'StripTags'),
        ),
        'order' => array(
            'filters' => array('StringTrim', 'Int'),
        ),
    );

    public function getEvaluation() {
        $model_evaluations = new Evaluations();
        return $model_evaluations->findByIdent($this->evaluation);
    }

    public function hasValues() {
        $values = $this->findEvaluations_Tests_Values();
        return count($values) != 0;
    }

    public function delete() {
        $db = Zend_Db_Table::getDefaultAdapter();
        $db->delete('groupset_group', '`group` = ' . $this->ident);
        $db->delete('group_user', '`group` = ' . $this->ident);
        parent::delete();
    }
}
