<?php

class Evaluations_ManagerController extends Yachay_Controller_Action
{
    public function newAction() {
        $this->requirePermission('resources', 'new');

        $this->view->evaluation = new Evaluations_Empty();

        $request = $this->getRequest();
        if ($request->isPost()) {
            $session = new Zend_Session_Namespace('yachay');

            $model_evaluations = new Evaluations();

            $evaluation = $model_evaluations->createRow();
            $evaluation->label = $request->getParam('label');
            $evaluation->access = $request->getParam('access');
            $evaluation->description = $request->getParam('description');
            $evaluation->author = $this->user->ident;

            if ($evaluation->isValid()) {
                $evaluation->tsregister = time();
                $evaluation->save();
                $session->url = $evaluation->ident;
                $this->_redirect($this->view->url(array('evaluation' => $evaluation->ident), 'evaluations_evaluation_view'));
            } else {
                foreach ($evaluation->getMessages() as $message) {
                    $this->_helper->flashMessenger->addMessage($message);
                }
            }
            
            $this->view->evaluation = $evaluation;
        } else {
            $this->history('evaluations/new');
        }

        $breadcrumb = array();
        $breadcrumb['Recursos'] = $this->view->url(array(), 'resources_list');
        $breadcrumb['Evaluaciones'] = $this->view->url(array('filter' => 'evaluations'), 'resources_filtered');
        $this->breadcrumb($breadcrumb);
    }

    public function sandboxAction() {
        $request = $this->getRequest();

        $formula = '';
        $result = '--';

        if ($request->isPost()) {
            $formula = $request->getParam('formula');

            if (!empty($result)) {
                $parser = new Evaluations_Sandbox_Parser();
                $value = $parser->parse($formula);
                $result = $value->extract();
            }
        } else {
            $this->history('evaluations/new');
        }

        $this->view->formula = $formula;
        $this->view->result = $result;

        $breadcrumb = array();
        $breadcrumb['Recursos'] = $this->view->url(array(), 'resources_list');
        $breadcrumb['Evaluaciones'] = $this->view->url(array('filter' => 'evaluations'), 'resources_filtered');
        $this->breadcrumb($breadcrumb);
    }
}
