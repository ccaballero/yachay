<?php

class modules_evaluations_models_Evaluations_Evaluation extends Yeah_Model_Row_WithTsRegister
{
    public $__type = 'evaluation';
    public $__element = 'evaluations';
    protected $_foreignkey = 'author';

    protected $_validationRules = array(
        'label' => array(
            'filters' => array('StringTrim'),
            'validators' => array(
                array(
                    'validator' => 'NotEmpty',
                    'message'   => 'El nombre de la evaluacion no puede estar vacio',
                ),
                array(
                    'validator' => 'StringLength',
                    'options'   => array(1, 64),
                    'message'   => 'El nombre de la evaluacion debe tener entre 1 y 64 caracteres',
                ),
                array(
                    'validator' => 'UniqueLabelDual',
                    'options'   => array('evaluations'),
                    'message'   => 'El nombre seleccionado para la evaluacion ya existe o no puede utilizarse',
                    'namespace' => 'Yeah_Validators',
                ),
            ),
        ),
        'access' => array(
            'filters' => array('StringTrim'),
            'validators' => array(
                array(
                    'validator' => 'NotEmpty',
                    'message'   => 'Debe definir la accesibilidad del criterio de evaluacion',
                ),
                array(
                    'validator' => 'InArray',
                    'options'   => array(array('public', 'private')),
                    'message'   => 'La accesibilidad seleccionada no es valida',
                ),
            ),
        ),
        'description' => array(
            'filters' => array('StringTrim', 'StripNewlines', 'StripTags'),
        ),
    );

    public function getAuthor() {
        $users = Yeah_Adapter::getModel('users');
        return $users->findByIdent($this->author);
    }

    public function getExtended() {
        return $this;
    }

    public function checkUseful() {
    	$evaluation_test = $this->findmodules_evaluations_models_Evaluations_Tests();
    	if (count($evaluation_test) == 0) {
    		$this->useful = false;
    	} else {
    		$this->useful = true;
    	}
		$this->save();
    }

    public function amAuthor() {
        global $USER;
        return ($USER->ident == $this->author);
    }
}
