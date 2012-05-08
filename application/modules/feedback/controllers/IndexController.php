<?php

class Feedback_IndexController extends Yachay_Controller_Action
{
    public function indexAction() {
        $this->requirePermission('feedback', 'list');

        $model_feedback = new Feedback();

        $this->view->model_feedback = $model_feedback;
        $this->view->feedback = $model_feedback->selectByResolved(false);

        $resources = array();
        foreach ($this->view->feedback as $entry) {
            $resources[] = $entry->getResource();
        }
        $this->view->resources = $resources;

        $this->history('feedback');
        $breadcrumb = array();
        $breadcrumb['Sugerencias'] = $this->view->url(array(), 'feedback_list');
        if ($this->acl('feedback', array('resolv', 'mark', 'delete'))) {
            $breadcrumb['Administrador de sugerencias'] = $this->view->url(array(), 'feedback_manager');
        }
        $this->breadcrumb($breadcrumb);
    }
}
