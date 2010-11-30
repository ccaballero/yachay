<?php

class Gestions_GestionController extends Yeah_Action
{
    public $_ignorePostDispatch;

    public function viewAction() {
        global $USER;

        $this->requirePermission('gestions', 'view');
        $request = $this->getRequest();

        $url = $request->getParam('gestion');

        $model_gestions = new Gestions();
        $gestion = $model_gestions->findByUrl($url);

        $this->requireExistence($gestion, 'gestion', 'gestions_gestion_view', 'gestions_list');

        $model_subjects = new Subjects();
        $model_subjects_users = new Subjects_Users();

        $subjects1 = $model_subjects->selectByStatus($gestion->ident, 'active');
        $subjects2 = array();

        foreach ($subjects1 as $subject) {
            if ($subject->status == 'active' || $this->acl('subjects', 'lock')) {
                switch ($subject->visibility) {
                    case 'public':
                        $subjects2[] = $subject;
                        break;
                    case 'register':
                        if ($USER->role != 1) {
                            $subjects2[] = $subject;
                        }
                        break;
                    case 'private':
                        if ($USER->role != 1) {
                            if ($this->acl('subjects', 'edit')) {
                                $subjects2[] = $subject;
                            } else {
                                $assign = $model_subjects_users->findBySubjectAndUser($subject->ident, $USER->ident);
                                if (!empty($assign)) {
                                    $subjects2[] = $subject;
                                }
                            }
                        }
                        break;
                }
            }
        }

        $this->view->model_gestions = $model_gestions;
        $this->view->gestion = $gestion;
        $this->view->subjects = $subjects2;

        history('gestions/' . $gestion->url);
        $breadcrumb = array();
        if ($this->acl('gestions', 'list')) {
            $breadcrumb['Gestiones'] = $this->view->url(array(), 'gestions_list');
        }
        if ($this->acl('gestions', array('new', 'active', 'delete'))) {
            $breadcrumb['Administrador de gestiones'] = $this->view->url(array(), 'gestions_manager');
        }
        breadcrumb($breadcrumb);
    }

    public function deleteAction() {
        $this->requirePermission('gestions', 'delete');
        $request = $this->getRequest();

        $url = $request->getParam('gestion');

        $model_gestions = new Gestions();
        $gestion = $model_gestions->findByUrl($url);

        $this->requireExistence($gestion, 'gestion', 'gestions_gestion_view', 'gestions_list');

        $session = new Zend_Session_Namespace();
        if (!empty($gestion) && $gestion->status == 'inactive' && $gestion->isEmpty()) {
            $label = $gestion->label;
            $gestion->delete();
            $session->messages->addMessage("La gestion $label ha sido eliminada");
        } else {
            $session->messages->addMessage("La gestion debe estar vacia e inactiva para ser eliminada");
        }

        $this->_redirect($this->view->currentPage());
    }

    public function activeAction() {
        $this->requirePermission('gestions', 'active');
        $request = $this->getRequest();

        $url = $request->getParam('gestion');
        $model_gestions = new Gestions();

        // Active the selected gestion
        $gestion = $model_gestions->findByUrl($url);

        $this->requireExistence($gestion, 'gestion', 'gestions_gestion_view', 'gestions_list');

        // clear all gestions
        $model_gestions->desactiveAll();
        $gestion->status = 'active';
        $gestion->save();

        $session = new Zend_Session_Namespace();
        $session->messages->addMessage("La gestion {$gestion->label} ha sido establecida como actual");

        $this->_redirect($this->view->currentPage());
    }
}
