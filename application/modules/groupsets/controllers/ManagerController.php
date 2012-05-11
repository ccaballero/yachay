<?php

class Groupsets_ManagerController extends Yachay_Controller_Action
{
    public function indexAction() {
        $this->requirePermission('subjects', 'teach');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $delete = $request->getParam('delete');
            if (!empty($delete)) {
                $this->_forward('delete');
            }
        } else {
            $this->history('groupsets/manager');
        }

        $model_groupsets = new Groupsets();

        $model_gestions = new Gestions();
        $current_gestion = $model_gestions->findByActive();

        $array = $model_groupsets->selectByAuthor($this->user->ident);
        $array1 = array();
        foreach ($array as $element) {
            if ($element->gestion == $current_gestion->ident) {
                $array1[] = $element;
            } 
        }

        $this->view->model_groupsets = $model_groupsets;
        $this->view->groupsets = $array1;

        $this->breadcrumb();
    }

    public function newAction() {
        $this->requirePermission('subjects', 'teach');

        $this->view->groupset = new Groupsets_Empty();

        $model_gestions = new Gestions();
        $current_gestion = $model_gestions->findByActive();

        $model_groups = new Groups();
        $groups_in_teach = $model_groups->listGroupsWithTeacher($this->user->ident);

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
            $session = new Zend_Session_Namespace('yachay');

            $model_groupsets = new Groupsets();
            $groupset = $model_groupsets->createRow();
            $groupset->label = $request->getParam('label');
            $groupset->author = $this->user->ident;
            $groupset->gestion = $current_gestion->ident;

            $checks = $request->getParam('groups');
            if (empty($checks)) {
                $checks = array();
            }

            if ($groupset->isValid()) {
                $groupset->tsregister = time();
                $groupset->save();

                $assignement = new Groupsets_Groups();
                foreach ($checks as $group) {
                    $assign = $assignement->createRow();
                    $assign->groupset = $groupset->ident;
                    $assign->group = $group;
                    $assign->save();
                }

                $this->_helper->flashMessenger->addMessage("El conjunto {$groupset->label} se ha creado correctamente");

                $session->url = $groupset->ident;
                $this->_redirect($request->getParam('return'));
            } else {
                foreach ($groupset->getMessages() as $message) {
                    $this->_helper->flashMessenger->addMessage($message);
                }
            }
            
            $this->view->groupset = $groupset;
            $this->view->checks = $checks;
        } else {
            $this->history('groupsets/new');
        }

        $breadcrumb = array();
        $breadcrumb['Conjuntos'] = $this->view->url(array(), 'groupsets_manager');
        $this->breadcrumb($breadcrumb);
    }

    public function deleteAction() {
        $this->requirePermission('subjects', 'teach');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $model_groupsets = new Groupsets();
            $check = $request->getParam("check");

            $count = 0;
            foreach ($check as $value) {
                $groupset = $model_groupsets->findByIdent($value);
                if (!empty($groupset)) {
                    if ($groupset->author == $this->user->ident) {
                        $groupset->delete();
                        $count++;
                    }
                }
            }

            $this->_helper->flashMessenger->addMessage("Se han eliminado $count conjuntos");
        }

        $this->_redirect($this->view->currentPage());
    }
}
