<?php

class Gestions_GestionController extends Yeah_Action
{
    public $_ignorePostDispatch;

    public function viewAction() {
        global $USER;

        $this->requirePermission('gestions', 'view');

        $request = $this->getRequest();
        $gestions = Yeah_Adapter::getModel('gestions');
        $gestion = $gestions->findByUrl($request->getParam('gestion'));

        $this->requireExistence($gestion, 'gestion', 'gestions_gestion_view', 'gestions_list');

        $subjects1 = Yeah_Adapter::getModel('subjects')->selectByStatus($gestion->ident, 'active');
        $assignement = Yeah_Adapter::getModel('subjects', 'Subjects_Users');
        $subjects2 = array();
        foreach ($subjects1 as $subject) {
            if ($subject->status == 'active' || Yeah_Acl::hasPermission('subjects', 'lock')) {
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
                            if (Yeah_Acl::hasPermission('subjects', 'edit')) {
                                $subjects2[] = $subject;
                            } else {
                                $assign = $assignement->findBySubjectAndUser($subject->ident, $USER->ident);
                                if (!empty($assign)) {
                                    $subjects2[] = $subject;
                                }
                            }
                        }
                        break;
                }
            }
        }

        $this->view->model = $gestions;
        $this->view->gestion = $gestion;
        $this->view->subjects = $subjects2;

        history('gestions/' . $gestion->url);
        $breadcrumb = array();
        if (Yeah_Acl::hasPermission('gestions', array('new', 'active', 'delete'))) {
            $breadcrumb['Gestiones'] = $this->view->url(array(), 'gestions_manager');
        } else if (Yeah_Acl::hasPermission('gestions', 'list')) {
            $breadcrumb['Gestiones'] = $this->view->url(array(), 'gestions_list');
        }
        breadcrumb($breadcrumb);
    }

    public function deleteAction() {
        $this->requirePermission('gestions', 'delete');
        $request = $this->getRequest();

        $url = $request->getParam('gestion');
        $gestions = Yeah_Adapter::getModel('gestions');
        $gestion = $gestions->findByUrl($url);

        $this->requireExistence($gestion, 'gestion', 'gestions_gestion_view', 'gestions_list');

        $session = new Zend_Session_Namespace();
        if (!empty($gestion) && $gestion->status == 'inactive' && $gestion->isEmpty()) {
            $label = $gestion->label;
            $gestion->delete();
            $session->messages->addMessage("La gestion $label ha sido eliminada");
        } else {
            $session->messages->addMessage("La gestion no puede ser eliminada");
        }

        $this->_redirect($this->view->currentPage());
    }

    public function activeAction() {
        $this->requirePermission('gestions', 'active');
        $request = $this->getRequest();

        $url = $request->getParam('gestion');
        $gestions = Yeah_Adapter::getModel('gestions');
        // Active the selected gestion
        $gestion = $gestions->findByUrl($url);

        $this->requireExistence($gestion, 'gestion', 'gestions_gestion_view', 'gestions_list');

        // clear all gestions
        $gestions->desactiveAll();
        $gestion->status = 'active';
        $gestion->save();

        $session = new Zend_Session_Namespace();
        $session->messages->addMessage("La gestion {$gestion->label} ha sido establecida como actual");

        $this->_redirect($this->view->currentPage());
    }

    public function subjectAction() {
        $this->_ignorePostDispatch = true;
        $this->_forward('view', 'subject', 'subjects');
    }
}
