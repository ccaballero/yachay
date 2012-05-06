<?php

class Teams_AssignController extends Yachay_Action
{
    public function indexAction() {
        $this->requirePermission('subjects', 'view');
        $request = $this->getRequest();

        $model_gestions = new Gestions();
        $gestion = $model_gestions->findByActive();

        $model_subjects = new Subjects();
        $url_subject = $request->getParam('subject');
        $subject = $model_subjects->findByUrl($gestion->ident, $url_subject);
        $this->requireExistence($subject, 'subject', 'subjects_subject_view', 'subjects_list');

        $model_groups = new Groups();
        $url_group = $request->getParam('group');
        $group = $model_groups->findByUrl($subject->ident, $url_group);
        $this->requireExistenceGroup($group, $subject);
        $this->requireTeacher($group);

        $model_teams = new Teams();
        $list_teams = $model_teams->selectAll($group->ident);

        $assignement = new Teams_Users();

        $group_members1 = $group->findUsersViaGroups_Users();
        $group_members2 = array();
        foreach ($group_members1 as $member) {
            $assign = $group->getAssignement($member);
            if ($assign->type != 'auxiliar') {
                $flag = true;
                foreach ($list_teams as $team) {
                    $assign = $assignement->findByTeamAndUser($team->ident, $member->ident);
                    if (!empty($assign)) {
                        $flag &= false;
                    }
                }
                if ($flag) {
                    $group_members2[] = $member;
                }
            }
        }

        if ($request->isPost()) {
            $selects = $request->getParam('team');
            foreach ($selects as $member_ident => $team_ident) {
                $member_ident = intval($member_ident);
                $team_ident = intval($team_ident);
                if ($team_ident <> 0 && $member_ident <> 0) {
                    // FIXME
                    $assign = $assignement->createRow();
                    $assign->team = $team_ident;
                    $assign->user = $member_ident;
                    $assign->tsregister = time();
                    $assign->save();
                }
            }
            
            $this->_helper->flashMessenger->addMessage('La asignación de equipos ha sido almacenada');
            $this->_redirect($request->getParam('return'));
        }

        $this->view->gestion = $gestion;
        $this->view->subject = $subject;
        $this->view->group = $group;
        $this->view->members = $group_members2;

        $this->history('subjects/' . $subject->url . '/groups/' . $group->url . '/teams/assign');
        $breadcrumb = array();
        if ($this->acl('subjects', 'list')) {
            $breadcrumb['Materias'] = $this->view->url(array(), 'subjects_list');
        }
        if ($this->acl('subjects', array('new', 'import', 'export', 'lock', 'delete'))) {
            $breadcrumb['Administrador de materias'] = $this->view->url(array(), 'subjects_manager');
        }
        if ($this->acl('subjects', 'view')) {
            $breadcrumb[$subject->label] = $this->view->url(array('subject' => $subject->url), 'subjects_subject_view');
            if ($subject->amModerator()) {
                $breadcrumb['Grupos'] = $this->view->url(array('subject' => $subject->url), 'groups_manager');
            }
            $breadcrumb['Grupo ' . $group->label] = $this->view->url(array('subject' => $subject->url, 'group' => $group->url), 'groups_group_view');
            if ($group->amTeacher()) {
                $breadcrumb['Equipos'] = $this->view->url(array('subject' => $subject->url, 'group' => $group->url), 'teams_manager');
            }
        }
        $this->breadcrumb($breadcrumb);
    }
}
