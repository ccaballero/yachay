<?php

class Feedback_IndexController extends Yeah_Action
{
    public function indexAction() {
        $this->requirePermission('feedback', 'list');

        $model_feedback = Yeah_Adapter::getModel('feedback');

        $this->view->model = $model_feedback;
        $this->view->feedback = $model_feedback->selectAll();

        history('feedback');
        $breadcrumb = array();
        if (Yeah_Acl::hasPermission('feedback', array('resolv', 'mark', 'delete'))) {
            $breadcrumb['Sugerencias'] = $this->view->url(array(), 'feedback_manager');
        }
        breadcrumb($breadcrumb);
    }
}
