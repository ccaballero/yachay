<?php

class Feedback_IndexController extends Yeah_Action
{
    public function indexAction() {
        $this->requirePermission('feedback', 'list');

        $model_feedback = new Feedback();

        $this->view->model_feedback = $model_feedback;
        $this->view->feedback = $model_feedback->selectByResolved(false);

        history('feedback');
        $breadcrumb = array();
        if ($this->acl('feedback', array('resolv', 'mark', 'delete'))) {
            $breadcrumb['Administrador de sugerencias'] = $this->view->url(array(), 'feedback_manager');
        }
        breadcrumb($breadcrumb);
    }
}
