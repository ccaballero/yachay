<?php

class Groups_IndexController extends Yachay_Controller_Action
{
    public function indexAction() {
        $this->requirePermission('subjects', array('teach', 'helper', 'study', 'participate'));

        $model_gestions = new Gestions();
        $active_gestion = $model_gestions->findByActive();

        $model_groups = new Groups();
        $model_groups_users = new Groups_Users();

        $groups_in_teach = $model_groups->listGroupsWithTeacher($this->user->ident);
        $groups_in_helper = $this->user->findGroupsViaGroups_Users($this->user->select()->where('type = ?', 'auxiliar'));
        $groups_in_study = $this->user->findGroupsViaGroups_Users($this->user->select()->where('type = ?', 'student'));
        $groups_in_participate = $this->user->findGroupsViaGroups_Users($this->user->select()->where('type = ?', 'guest'));

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
        $this->breadcrumb();
    }
}
