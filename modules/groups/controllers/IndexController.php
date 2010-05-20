<?php

class Groups_IndexController extends Yeah_Action
{
    public function indexAction() {
        global $USER;

        $this->requirePermission('subjects', array('teach', 'helper', 'study', 'participate'));

        $gestions_model = Yeah_Adapter::getModel('gestions');
        $current_gestion = $gestions_model->findByActive();

        $users_model = Yeah_Adapter::getModel('users');
        $user = $users_model->findByIdent($USER->ident);

        $groups_model = Yeah_Adapter::getModel('groups');
        $assignement = Yeah_Adapter::getModel('groups', 'Groups_Users');

        $groups_in_teach = $groups_model->listGroupsWithTeacher($USER->ident);
        $groups_in_helper = $user->findmodules_groups_models_GroupsViamodules_groups_models_Groups_Users($user->select()->where('type = ?', 'auxiliar'));
        $groups_in_study = $user->findmodules_groups_models_GroupsViamodules_groups_models_Groups_Users($user->select()->where('type = ?', 'student'));
        $groups_in_participate = $user->findmodules_groups_models_GroupsViamodules_groups_models_Groups_Users($user->select()->where('type = ?', 'guest'));

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
        foreach ($groups_in_helper as $group) {
            $subject = $group->getSubject();
            $gestion = $subject->getGestion();
            if ($gestion->ident == $current_gestion->ident) {
                $subjects[$subject->ident] = $subject;
                $groups[$subject->ident][] = $group;
            }
        }
        foreach ($groups_in_study as $group) {
            $subject = $group->getSubject();
            $gestion = $subject->getGestion();
            if ($gestion->ident == $current_gestion->ident) {
                $subjects[$subject->ident] = $subject;
                $groups[$subject->ident][] = $group;
            }
        }
        foreach ($groups_in_participate as $group) {
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
        $this->view->assignement = $assignement;

        history('groups');
        breadcrumb();
    }
}
