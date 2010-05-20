<?php

class Groupsets_ManagerController extends Yeah_Action
{
    public function indexAction() {
        global $USER;

        $this->requirePermission('subjects', 'teach');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $delete = $request->getParam('delete');
            if (!empty($delete)) {
                $this->_forward('delete');
            }
        }

        $groupsets = Yeah_Adapter::getModel('groupsets');

        $gestions_model = Yeah_Adapter::getModel('gestions');
        $current_gestion = $gestions_model->findByActive();

        $array = $groupsets->selectByAuthor($USER->ident);
        $array1 = array();
        foreach ($array as $element) {
            if ($element->gestion == $current_gestion->ident) {
                $array1[] = $element;
            } 
        }

        $this->view->model = $groupsets;
        $this->view->groupsets = $array1;

        history('groupsets/manager');
        breadcrumb();
    }

    public function newAction() {
        global $USER;

        $this->requirePermission('subjects', 'teach');

        $this->view->groupset = new modules_groupsets_models_Groupsets_Empty;

        $gestions_model = Yeah_Adapter::getModel('gestions');
        $current_gestion = $gestions_model->findByActive();

        $users_model = Yeah_Adapter::getModel('users');
        $user = $users_model->findByIdent($USER->ident);

        $groups_model = Yeah_Adapter::getModel('groups');
        $groups_in_teach = $groups_model->listGroupsWithTeacher($USER->ident);

        $subjects = array();
        $groups = array();
        foreach ($groups_in_teach as $group) {
            $subject = $group->getSubject();
            $gestion = $subject->getGestion();
            if ($gestion->ident == $current_gestion->ident) {
                $subjects[$subject->ident] = $subject;
                $groups[$subject->ident][] = $group;
            }
        }

        $this->view->gestion = $current_gestion;
        $this->view->subjects = $subjects;
        $this->view->groups = $groups;

        $this->view->checks = array();

        $request = $this->getRequest();
        if ($request->isPost()) {
            $session = new Zend_Session_Namespace();

            $groupsets = Yeah_Adapter::getModel('groupsets');
            $groupset = $groupsets->createRow();
            $groupset->label = $request->getParam('label');
            $groupset->author = $USER->ident;
            $groupset->gestion = $current_gestion->ident;

            $checks = $request->getParam('groups');
            if (empty($checks)) {
                $checks = array();
            }

            if ($groupset->isValid()) {
                $groupset->tsregister = time();
                $groupset->save();

                $assignement = Yeah_Adapter::getModel('groupsets', 'Groupsets_Groups');
                foreach ($checks as $group) {
                    $assign = $assignement->createRow();
                    $assign->groupset = $groupset->ident;
                    $assign->group = $group;
                    $assign->save();
                }

                $session->messages->addMessage("El conjunto {$groupset->label} se ha creado correctamente");
                $session->url = $groupset->ident;
                $this->_redirect($request->getParam('return'));
            } else {
                foreach ($groupset->getMessages() as $message) {
                    $session->messages->addMessage($message);
                }
            }
            
            $this->view->groupset = $groupset;
            $this->view->checks = $checks;
        }

        history('groupsets/new');
        $breadcrumb = array();
        $breadcrumb['Conjuntos'] = $this->view->url(array(), 'groupsets_manager');
        breadcrumb($breadcrumb);
    }

    public function deleteAction() {
        global $USER;
        $this->requirePermission('subjects', 'teach');
        $request = $this->getRequest();
        if ($request->isPost()) {
            $groupsets = Yeah_Adapter::getModel('groupsets');
            $check = $request->getParam("check");

            $count = 0;
            foreach ($check as $value) {
                $groupset = $groupsets->findByIdent($value);
                if (!empty($groupset)) {
                    if ($groupset->author == $USER->ident) {
                        $groupset->delete();
                        $count++;
                    }
                }
            }

            $session = new Zend_Session_Namespace();
            $session->messages->addMessage("Se han eliminado $count conjuntos");
        }
        $this->_redirect($this->view->currentPage());
    }
}
