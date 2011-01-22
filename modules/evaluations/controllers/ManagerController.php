<?php

class Evaluations_ManagerController extends Yeah_Action
{
    public function newAction() {
        global $USER;

        $this->requirePermission('resources', 'new');

        $this->view->evaluation = new Evaluations_Empty();

        $request = $this->getRequest();
        if ($request->isPost()) {
            $session = new Zend_Session_Namespace();

            $model_evaluations = new Evaluations();

            $evaluation = $model_evaluations->createRow();
            $evaluation->label = $request->getParam('label');
            $evaluation->access = $request->getParam('access');
            $evaluation->description = $request->getParam('description');
            $evaluation->author = $USER->ident;

            if ($evaluation->isValid()) {
                $evaluation->tsregister = time();
                $evaluation->save();
                $session->url = $evaluation->ident;
                $this->_redirect($this->view->url(array('evaluation' => $evaluation->ident), 'evaluations_evaluation_view'));
            } else {
                foreach ($evaluation->getMessages() as $message) {
                    $session->messages->addMessage($message);
                }
            }
            
            $this->view->evaluation = $evaluation;
        }

        history('evaluations/new');
        $breadcrumb = array();
        $breadcrumb['Recursos'] = $this->view->url(array(), 'resources_list');
        $breadcrumb['Evaluaciones'] = $this->view->url(array('filter' => 'evaluations'), 'resources_filtered');
        breadcrumb($breadcrumb);
    }
}
