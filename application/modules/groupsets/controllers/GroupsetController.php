<?php

class Groupsets_GroupsetController extends Yachay_Action
{
    public function viewAction() {
        global $USER;

        $this->requirePermission('subjects', 'teach');

        $request = $this->getRequest();
        $model_groupsets = new Groupsets();
        $groupset = $model_groupsets->findByIdent($request->getParam('groupset'));
        $this->requireExistence($groupset, 'groupset', 'groupsets_groupset_view', 'groupsets_manager');

        if ($groupset->author != $USER->ident) {
            $this->_redirect($this->view->url(array(), 'groupsets_manager'));
            return;
        }

        $model_gestions = new Gestions();
        $current_gestion = $model_gestions->findByActive();

        $model_users = new Users();
        $user = $model_users->findByIdent($USER->ident);

        $model_groups = new Groups();
        $groups_in_teach = $model_groups->listGroupsWithTeacher($USER->ident);

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

        $assignement = new Groupsets_Groups();
        $groupset_groups = $groupset->findGroupsViaGroupsets_Groups();

        $this->view->model_groupsets = $model_groupsets;
        $this->view->groupset = $groupset;
        $this->view->groupset_groups = $groupset_groups;
        $this->view->subjects = $subjects;
        $this->view->groups = $groups;

        history('groupsets/' . $groupset->ident);
        $breadcrumb = array();
        $breadcrumb['Conjuntos'] = $this->view->url(array(), 'groupsets_manager');
        breadcrumb($breadcrumb);
    }

    public function editAction() {
        global $USER;

        $this->requirePermission('subjects', 'teach');

        $request = $this->getRequest();
        $model_groupsets = new Groupsets();
        $groupset = $model_groupsets->findByIdent($request->getParam('groupset'));
        $this->requireExistence($groupset, 'groupset', 'groupsets_groupset_view', 'groupsets_manager');

        if ($groupset->author != $USER->ident) {
            $this->_redirect($this->view->url(array(), 'groupsets_manager'));
            return;
        }

        $this->view->groupset = $groupset;

        $model_gestions = new Gestions();
        $current_gestion = $model_gestions->findByActive();

        $model_users = new Users();
        $user = $model_users->findByIdent($USER->ident);

        $model_groups = new Groups();
        $groups_in_teach = $model_groups->listGroupsWithTeacher($USER->ident);

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

        $assignement = new Groupsets_Groups();
        $groupset_groups = $groupset->findGroupsViaGroupsets_Groups();
        $array1 = array();
        foreach ($groupset_groups as $groupset_group) {
            $array1[] = $groupset_group->ident;
        }
        $this->view->checks = $array1;

        $request = $this->getRequest();
        if ($request->isPost()) {
            $session = new Zend_Session_Namespace();

            $groupset->label = $request->getParam('label');
 
            $checks = $request->getParam('groups');
            if (empty($checks)) {
                $checks = array();
            }

            if ($groupset->isValid()) {
                $groupset->tsregister = time();
                $groupset->save();

                // FIXME Llevar a modelo las modificaciones de base de datos
                $db = Zend_Db_Table::getDefaultAdapter();
                $db->delete('groupset_group', 'groupset = ' . $groupset->ident);
                $assignement = new Groupsets_Groups();
                foreach ($checks as $group) {
                    $assign = $assignement->createRow();
                    $assign->groupset = $groupset->ident;
                    $assign->group = $group;
                    $assign->save();
                }

                $session->messages->addMessage("El conjunto {$groupset->label} se ha editado correctamente");
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

        history('groupsets/' . $groupset->ident . '/edit');
        $breadcrumb = array();
        $breadcrumb['Conjuntos'] = $this->view->url(array(), 'groupsets_manager');
        $breadcrumb[$groupset->label] = $this->view->url(array('groupset' => $groupset->ident), 'groupsets_groupset_view');
        breadcrumb($breadcrumb);
    }

    public function deleteAction() {
        global $USER;

        $this->requirePermission('subjects', 'teach');

        $request = $this->getRequest();
        $model_groupsets = new Groupsets();
        $groupset = $model_groupsets->findByIdent($request->getParam('groupset'));
        $this->requireExistence($groupset, 'groupset', 'groupsets_groupset_view', 'groupsets_manager');

        if ($groupset->author != $USER->ident) {
            $this->_redirect($this->view->url(array(), 'groupsets_manager'));
            return;
        }

        $session = new Zend_Session_Namespace();
        $label = $groupset->label;
        if (!empty($groupset)) {
            $groupset->delete();
            $session->messages->addMessage("El conjunto $label ha sido eliminado");
        } else {
            $session->messages->addMessage("El conjunto $label no puede ser eliminado");
        }

        $this->_redirect($this->view->currentPage());
    }
}
