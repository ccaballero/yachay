<?php

class Gestions_GestionController extends Yachay_Controller_Action
{
    public $_ignorePostDispatch;

    public function viewAction() {
        $this->requirePermission('gestions', 'view');
        $request = $this->getRequest();

        $url = $request->getParam('gestion');

        $model_gestions = new Gestions();
        $gestion = $model_gestions->findByUrl($url);

        $this->requireExistence($gestion, 'gestion', 'gestions_gestion_view', 'gestions_list');

        $model_subjects = new Subjects();
        $model_subjects_users = new Subjects_Users();

        $subjects1 = $model_subjects->selectByStatus('active', $gestion->ident);
        $subjects2 = array();

        foreach ($subjects1 as $subject) {
            if ($subject->status == 'active' || $this->acl('subjects', 'lock')) {
                switch ($subject->visibility) {
                    case 'public':
                        $subjects2[] = $subject;
                        break;
                    case 'register':
                        if ($this->user->role != 1) {
                            $subjects2[] = $subject;
                        }
                        break;
                    case 'private':
                        if ($this->user->role != 1) {
                            if ($this->acl('subjects', 'edit')) {
                                $subjects2[] = $subject;
                            } else {
                                $assign = $model_subjects_users->findBySubjectAndUser($subject->ident, $this->user->ident);
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

        $this->history('gestions/' . $gestion->url);
        $breadcrumb = array();
        if ($this->acl('gestions', 'list')) {
            $breadcrumb['Gestiones'] = $this->view->url(array(), 'gestions_list');
        }
        if ($this->acl('gestions', array('new', 'active', 'delete'))) {
            $breadcrumb['Administrador de gestiones'] = $this->view->url(array(), 'gestions_manager');
        }
        $this->breadcrumb($breadcrumb);
    }

    public function deleteAction() {
        $this->requirePermission('gestions', 'delete');
        $request = $this->getRequest();

        $url = $request->getParam('gestion');

        $model_gestions = new Gestions();
        $gestion = $model_gestions->findByUrl($url);

        $this->requireExistence($gestion, 'gestion', 'gestions_gestion_view', 'gestions_list');

        if (!empty($gestion) && $gestion->status == 'inactive' && $gestion->isEmpty()) {
            $label = $gestion->label;
            $gestion->delete();
            $this->_helper->flashMessenger->addMessage("La gestion $label ha sido eliminada");
        } else {
            $this->_helper->flashMessenger->addMessage("La gestion debe estar vacia e inactiva para ser eliminada");
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

        $this->_helper->flashMessenger->addMessage("La gestion {$gestion->label} ha sido establecida como actual");

        $this->_redirect($this->view->currentPage());
    }
}
