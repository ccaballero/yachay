<?php

class Evaluations_EvaluationController extends Yachay_Action
{
    public function viewAction() {
        global $USER;

        $this->requirePermission('subjects', 'teach');
        $request = $this->getRequest();

        $model_evaluations = new Evaluations();
        $evaluation = $model_evaluations->findByIdent($request->getParam('evaluation'));

        $this->requireExistence($evaluation, 'evaluation', 'evaluations_evaluation_view', 'resources_list');

        $tests_evaluation = $evaluation->findEvaluations_Tests($evaluation->select()->order('order ASC'));
        $groups = $evaluation->findGroups();

        $this->view->model_evaluations = $model_evaluations;
        $this->view->evaluation = $evaluation;
        $this->view->tests_evaluation = $tests_evaluation;
        $this->view->groups = $groups;

        history('evaluations/' . $evaluation->ident);
        $breadcrumb = array();
        $breadcrumb['Recursos'] = $this->view->url(array(), 'resources_list');
        $breadcrumb['Evaluaciones'] = $this->view->url(array('filter' => 'evaluations'), 'resources_filtered');
        breadcrumb($breadcrumb);
    }

    // FIXME Agregar restricciones de historial
    public function editAction() {
        global $USER;

        $this->requirePermission('subjects', 'teach');

        $request = $this->getRequest();
        $url_evaluation = $request->getParam('evaluation');

        $model_evaluations = new Evaluations();
        $evaluation = $model_evaluations->findByIdent($url_evaluation);
        $this->requireExistence($evaluation, 'evaluation', 'evaluations_evaluation_view', 'resources_list');

        if ($evaluation->author != $USER->ident) {
            $this->_redirect($this->view->url(array(), 'frontpage'));
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

        $tests_evaluation = $evaluation->findEvaluations_Tests($evaluation->select()->order('order ASC'));

        $this->view->model = $model_evaluations;
        $this->view->evaluation = $evaluation;
        $this->view->tests_evaluations = $tests_evaluation;

        history('evaluations/' . $evaluation->ident . '/edit');
        $breadcrumb = array();
        $breadcrumb['Recursos'] = $this->view->url(array(), 'resources_list');
        $breadcrumb['Evaluaciones'] = $this->view->url(array('filter' => 'evaluations'), 'resources_filtered');
        $breadcrumb[$evaluation->label] = $this->view->url(array('evaluation' => $evaluation->ident), 'evaluations_evaluation_view');
        breadcrumb($breadcrumb);
    }
}
