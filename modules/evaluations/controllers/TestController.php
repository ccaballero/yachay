<?php

class Evaluations_TestController extends Yeah_Action
{
    
    // FIXME Agregar restricciones de historial, sea lo que eso haya significado en ese momento
    public function valueAction() {
        global $USER;

        $this->requirePermission('subjects', 'teach');
        $request = $this->getRequest();

        $evaluations_model = Yeah_Adapter::getModel('evaluations');
        $evaluation = $evaluations_model->findByIdent($request->getParam('evaluation'));
        $this->requireExistence($evaluation, 'evaluation', 'evaluations_evaluation_view', 'resources_list');

        if ($evaluation->author != $USER->ident) {
            $this->_redirect($CONFIG->wwwroot);
        }

        $tests_model = Yeah_Adapter::getModel('evaluations', 'Evaluations_Tests');
        $test = $tests_model->findByIdent($request->getParam('test'));
        if (empty($test)) {
            $this->_redirect($CONFIG->wwwroot);
        }

        $values_model = Yeah_Adapter::getModel('evaluations', 'Evaluations_Tests_Values');
        $value = $values_model->findByIdent($request->getParam('value'));

        $session = new Zend_Session_Namespace();
        if (!empty($value)) {
		    $value->delete();
		    $session->messages->addMessage("La calificacion ha sido eliminada");
        }

        $this->_redirect($this->view->currentPage());
    }

    // FIXME Agregar restricciones de historial, sea lo que eso haya significado en ese momento
    public function configAction() {
        global $USER;

        $this->requirePermission('subjects', 'teach');
        $request = $this->getRequest();

        $evaluations_model = Yeah_Adapter::getModel('evaluations');
        $evaluation = $evaluations_model->findByIdent($request->getParam('evaluation'));
        $this->requireExistence($evaluation, 'evaluation', 'evaluations_evaluation_view', 'resources_list');

        if ($evaluation->author != $USER->ident) {
            $this->_redirect($CONFIG->wwwroot);
        }

        $tests_model = Yeah_Adapter::getModel('evaluations', 'Evaluations_Tests');
        $test = $tests_model->findByIdent($request->getParam('test'));
        if (empty($test)) {
            $this->_redirect($CONFIG->wwwroot);
        }

        $empty = new modules_evaluations_models_Evaluations_Tests_Values_Empty();
        $this->view->value = $empty;

        if ($request->isPost()) {
            $session = new Zend_Session_Namespace();

            $values_model = Yeah_Adapter::getModel('evaluations', 'Evaluations_Tests_Values');
            $value = $values_model->createRow();
            $value->label = $request->getParam('label');
            $value->value = $request->getParam('value');
            $value->evaluation = $evaluation->ident;
            $value->test = $test->ident;

            if ($value->isValid()) {
                if ($test->minimumnote <= $value->value && $value->value <=  $test->maximumnote) {
                    $value->save();
                    $session->messages->addMessage("Se ha agregado un nuevo valor cualitativo");
                } else {
                    $session->messages->addMessage("El valor de la nota no esta dentro del rango");
                    $this->view->value = $value;
                }
            } else {
                foreach ($value->getMessages() as $message) {
                    $session->messages->addMessage($message);
                }
                $this->view->value = $value;
            }
        }

        $values = $test->findmodules_evaluations_models_Evaluations_Tests_Values($test->select()->order('value ASC'));

        $this->view->model = $tests_model;
        $this->view->evaluation = $evaluation;
        $this->view->test = $test;
        $this->view->values = $values;

        history('evaluations/' . $evaluation->ident . '/' . $test->ident);
        $breadcrumb = array();
        $breadcrumb['Recursos'] = $this->view->url(array(), 'resources_list');
        $breadcrumb['Evaluaciones'] = $this->view->url(array('filter' => 'evaluations'), 'resources_filtered');
        $breadcrumb[$evaluation->label] = $this->view->url(array('evaluation' => $evaluation->ident), 'evaluations_evaluation_view');
        breadcrumb($breadcrumb);
    }

    // FIXME Agregar restricciones de historial
    public function addAction() {
        global $USER;

        $this->requirePermission('subjects', 'teach');
        $request = $this->getRequest();

        $evaluations_model = Yeah_Adapter::getModel('evaluations');
        $evaluation = $evaluations_model->findByIdent($request->getParam('evaluation'));
        $this->requireExistence($evaluation, 'evaluation', 'evaluations_evaluation_view', 'resources_list');

        if ($evaluation->author != $USER->ident) {
            $this->_redirect($CONFIG->wwwroot);
        }

        $empty = new modules_evaluations_models_Evaluations_Tests_Empty();
        $this->view->test = $empty;

        if ($request->isPost()) {
            $session = new Zend_Session_Namespace();

            $test_model = Yeah_Adapter::getModel('evaluations', 'Evaluations_Tests');
            $test = $test_model->createRow();
            $test->label = $request->getParam('label');
            $test->key = $request->getParam('key');
            $test->minimumnote = $request->getParam('minimum');
            $test->defaultnote = $request->getParam('default');
            $test->maximumnote = $request->getParam('maximum');
            $test->formula = $request->getParam('formula');
            $test->order = $request->getParam('order');
            $test->evaluation = $evaluation->ident;

            if ($test->isValid()) {
                if ($test->minimumnote <= $test->defaultnote && $test->defaultnote <=  $test->maximumnote) {
                    $parser = new modules_evaluations_models_Parser($evaluation->ident);
                    $parser->mode = 'TEST';
                    $value = $parser->parse($test->formula);
                    if (!empty($value)) {
                        $test->save();
                        $evaluation->checkUseful();
                        $session->messages->addMessage("Se ha agregado una nueva calificaci&oacute;n");
                    }
                } else {
                    $session->messages->addMessage("Los rangos de notas no son adecuados");
                    $this->view->test = $test;
                }
            } else {
                foreach ($test->getMessages() as $message) {
                    $session->messages->addMessage($message);
                }
                $this->view->test = $test;
            }
        }

        $evaluation_test = $evaluation->findmodules_evaluations_models_Evaluations_Tests($evaluation->select()->order('order ASC'));

        $this->view->model = $evaluations_model;
        $this->view->evaluation = $evaluation;
        $this->view->tests = $evaluation_test;

        history('evaluations/' . $evaluation->ident . '/add');
        $breadcrumb = array();
        $breadcrumb['Recursos'] = $this->view->url(array(), 'resources_list');
        $breadcrumb['Evaluaciones'] = $this->view->url(array('filter' => 'evaluations'), 'resources_filtered');
        $breadcrumb[$evaluation->label] = $this->view->url(array('evaluation' => $evaluation->ident), 'evaluations_evaluation_view');
        breadcrumb($breadcrumb);
    }

    // FIXME Agregar restricciones de historial
    public function deleteAction() {
    	global $USER;

        $this->requirePermission('subjects', 'teach');
        $request = $this->getRequest();

        $evaluations_model = Yeah_Adapter::getModel('evaluations');
        $evaluation_url = $request->getParam('evaluation');
        $evaluation = $evaluations_model->findByIdent($evaluation_url);
        $this->requireExistence($evaluation, 'evaluation', 'evaluations_evaluation_view', 'resources_list');

        if ($evaluation->author != $USER->ident) {
            $this->_redirect($CONFIG->wwwroot);
        }

        $evaluations_test_model = Yeah_Adapter::getModel('evaluations', 'Evaluations_Tests');
        $evaluation_test_url = $request->getParam('test');
        $evaluation_test = $evaluations_test_model->findByIdent($evaluation_test_url);

        $session = new Zend_Session_Namespace();
        if (!empty($evaluation_test)) {
        	if ($evaluation->author == $USER->ident) {
		        $evaluation_test->delete();
		        $evaluation->checkUseful();
		        $session->messages->addMessage("La calificacion ha sido eliminada");
        	} else {
	            $session->messages->addMessage("Usted no puede eliminar la calificacion");
        	}
        }

        $this->_redirect($this->view->currentPage());
    }
}
