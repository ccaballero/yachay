<?php

class Groups_IndexController extends Yachay_Action
{
    public function indexAction() {
        global $USER;

        $this->requirePermission('subjects', array('teach', 'helper', 'study', 'participate'));

        $model_gestions = new Gestions();
        $active_gestion = $model_gestions->findByActive();

        $model_users = new Users();
        $user = $model_users->findByIdent($USER->ident);

        $model_groups = new Groups();
        $model_groups_users = new Groups_Users();

        $groups_in_teach = $model_groups->listGroupsWithTeacher($USER->ident);
        $groups_in_helper = $user->findGroupsViaGroups_Users($user->select()->where('type = ?', 'auxiliar'));
        $groups_in_study = $user->findGroupsViaGroups_Users($user->select()->where('type = ?', 'student'));
        $groups_in_participate = $user->findGroupsViaGroups_Users($user->select()->where('type = ?', 'guest'));

        $subjects = array();
        $groups = array();
        foreach ($groups_in_teach as $group) {
            $subject = $group->getSubject();
            $gestion = $subject->getGestion();
            if ($gestion->ident == $active_gestion->ident) {
                $subjects[$subject->ident] = $subject;
                $groups[$subject->ident][] = $group;
            }
        }
        foreach ($groups_in_helper as $group) {
            $subject = $group->getSubject();
            $gestion = $subject->getGestion();
            if ($gestion->ident == $active_gestion->ident) {
                $subjects[$subject->ident] = $subject;
                $groups[$subject->ident][] = $group;
            }
        }
        foreach ($groups_in_study as $group) {
            $subject = $group->getSubject();
            $gestion = $subject->getGestion();
            if ($gestion->ident == $active_gestion->ident) {
                $subjects[$subject->ident] = $subject;
                $groups[$subject->ident][] = $group;
            }
        }
        foreach ($groups_in_participate as $group) {
            $subject = $group->getSubject();
            $gestion = $subject->getGestion();
            if ($gestion->ident == $active_gestion->ident) {
                $subjects[$subject->ident] = $subject;
                $groups[$subject->ident][] = $group;
            }
        }

        $this->view->gestion = $active_gestion;
        $this->view->subjects = $subjects;
        $this->view->groups = $groups;
        $this->view->model_groups_users = $model_groups_users;

        $this->history('groups');
        breadcrumb();
    }
}
