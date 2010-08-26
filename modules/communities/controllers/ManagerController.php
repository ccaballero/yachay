<?php

class Communities_ManagerController extends Yeah_Action
{
    public function indexAction() {
        global $USER;

        $this->requirePermission('communities', 'list');
        $this->requirePermission('communities', 'enter');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $delete = $request->getParam('delete');
            if (!empty($delete)) {
                $this->_forward('delete');
            }
        }

        $model_communities = Yeah_Adapter::getModel('communities');
        $communities = $model_communities->selectByAuthor($USER->ident);

        $this->view->model = $model_communities;
        $this->view->communities = $communities;

        history('communities/manager');
        breadcrumb();
    }

    public function newAction() {
        global $USER;

        $this->requirePermission('communities', 'enter');

        $this->view->community = new modules_communities_models_Communities_Empty;

        $request = $this->getRequest();
        if ($request->isPost()) {
            $session = new Zend_Session_Namespace();

            $model_communities = Yeah_Adapter::getModel('communities');

            $community = $model_communities->createRow();
            $community->label = $request->getParam('label');
            $community->mode = $request->getParam('mode');
            $community->interests = $request->getParam('interests');
            $community->description = $request->getParam('description');

            if ($area->isValid()) {
                $area->tsregister = time();
                $area->save();
                $session->messages->addMessage("El area {$area->label} se ha creado correctamente");
                $session->url = $area->url;
                $this->_redirect($request->getParam('return'));
            } else {
                foreach ($area->getMessages() as $message) {
                    $session->messages->addMessage($message);
                }
            }

            $this->view->area = $area;
        }

        history('communities/new');
        $breadcrumb = array();
        $breadcrumb['Comunidades'] = $this->view->url(array(), 'communities_manager');
        breadcrumb($breadcrumb);
    }

    public function deleteAction() {
        global $USER;

        $this->requirePermission('communities', 'enter');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $model_communities = Yeah_Adapter::getModel('communities');
            $check = $request->getParam("check");

            $count = 0;
            foreach ($check as $value) {
                $community = $model_communities->findByIdent($value);
                if (!empty($community)) {
                    if ($community->author == $USER->ident) {
                        $community->delete();
                        $count++;
                    }
                }
            }

            $session = new Zend_Session_Namespace();
            $session->messages->addMessage("Se han eliminado $count comunidades");
        }
        $this->_redirect($this->view->currentPage());
    }
}
