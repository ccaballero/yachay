<?php

class modules_evaluations_models_Evaluations_Tests_Test extends Yeah_Model_Row_Validation
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
                    'options'   => array(array('evaluations', 'Evaluations_Tests')),
                    'message'   => 'El nombre seleccionado para la calificacion ya existe o no puede utilizarse',
                    'namespace' => 'Yeah_Validators',
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
                    'options'   => array(array('evaluations', 'Evaluations_Tests')),
                    'message'   => 'El nombre seleccionado para la calificacion ya existe o no puede utilizarse',
                    'namespace' => 'Yeah_Validators',
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
        $evaluations = Yeah_Adapter::getModel('evaluations');
        return $evaluations->findByIdent($this->evaluation);
    }

    public function isEmpty() {
        $model = Yeah_Adapter::getModel('teams');
        $teams = $model->selectAll($this->ident);
        return count($teams) == 0;
    }

    public function hasValues() {
        $values = $this->findmodules_evaluations_models_Evaluations_Tests_Values();
        return count($values) != 0;
    }

    public function delete() {
        // FIXME ??
        global $DB;
        $DB->delete('groupset_group', '`group` = ' . $this->ident);
        $DB->delete('group_user', '`group` = ' . $this->ident);
        parent::delete();
    }
}