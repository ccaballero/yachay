<?php

class Evaluations_EvaluationController extends Yeah_Action
{
    public function viewAction() {
        global $USER;

        $this->requirePermission('subjects', 'teach');
        $request = $this->getRequest();

        $evaluations_model = Yeah_Adapter::getModel('evaluations');
        $evaluation = $evaluations_model->findByIdent($request->getParam('evaluation'));
        $this->requireExistence($evaluation, 'evaluation', 'evaluations_evaluation_view', 'resources_list');

        $evaluation_test = $evaluation->findmodules_evaluations_models_Evaluations_Tests($evaluation->select()->order('order ASC'));
        $groups = $evaluation->findDependentRowset('modules_groups_models_Groups');

        $this->view->model = $evaluations_model;
        $this->view->evaluation = $evaluation;
        $this->view->tests = $evaluation_test;
        $this->view->groups = $groups;

        history('evaluations/' . $evaluation->ident);
        $breadcrumb = array();
        $breadcrumb['Recursos'] = $this->view->url(array(), 'resources_list');
        $breadcrumb['Evaluaciones'] = $this->view->url(array('filter' => 'evaluations'), 'resources_filtered');
        breadcrumb($breadcrumb);
    }

    // FIXME Agregar restricciones de historial
    public function editAction() {
        global $CONFIG;
        global $USER;

        $this->requirePermission('subjects', 'teach');
        $request = $this->getRequest();
        $evaluation_url = $request->getParam('evaluation');

        $evaluations_model = Yeah_Adapter::getModel('evaluations');
        $evaluation = $evaluations_model->findByIdent($evaluation_url);
        $this->requireExistence($evaluation, 'evaluation', 'evaluations_evaluation_view', 'resources_list');

        if ($evaluation->author != $USER->ident) {
            $this->_redirect($CONFIG->wwwroot);
        }

        if ($request->isPost()) {
            $session = new Zend_Session_Namespace();

            $evaluation->label = $request->getParam('label');
            $evaluation->access = $request->getParam('access');
            $evaluation->description = $request->getParam('description');
            $evaluation->author = $USER->ident;

            if ($evaluation->isValid()) {
                $evaluation->save();
                $session->messages->addMessage('El criterio de evaluacion se modifico correctamente');
                $session->url = $evaluation->ident;
                $this->_redirect($request->getParam('return'));
            } else {
                foreach ($evaluation->getMessages() as $message) {
                    $session->messages->addMessage($message);
                }
            }

            $this->view->evaluation = $evaluation;
        }

        $evaluation_test = $evaluation->findmodules_evaluations_models_Evaluations_Tests($evaluation->select()->order('order ASC'));

        $this->view->model = $evaluations_model;
        $this->view->evaluation = $evaluation;
        $this->view->tests = $evaluation_test;

        history('evaluations/' . $evaluation->ident . '/edit');
        $breadcrumb = array();
        $breadcrumb['Recursos'] = $this->view->url(array(), 'resources_list');
        $breadcrumb['Evaluaciones'] = $this->view->url(array('filter' => 'evaluations'), 'resources_filtered');
        $breadcrumb[$evaluation->label] = $this->view->url(array('evaluation' => $evaluation->ident), 'evaluations_evaluation_view');
        breadcrumb($breadcrumb);
    }
}
