<?php

class Teams_AssignController extends Yeah_Action
{
    public function indexAction() {
        $this->requirePermission('subjects', 'view');
        $request = $this->getRequest();

        $gestions = Yeah_Adapter::getModel('gestions');
        $gestion = $gestions->findByActive();

        $subjects = Yeah_Adapter::getModel('subjects');
        $urlsubject = $request->getParam('subject');
        $subject = $subjects->findByUrl($gestion->ident, $urlsubject);
        $this->requireExistence($subject, 'subject', 'subjects_subject_view', 'subjects_list');

        $groups = Yeah_Adapter::getModel('groups');
        $urlgroup = $request->getParam('group');
        $group = $groups->findByUrl($subject->ident, $urlgroup);
        $this->requireExistenceGroup($group, $subject);
        $this->requireTeacher($group);

        $teams = Yeah_Adapter::getModel('teams');
        $listteams = $teams->selectAll($group->ident);

        $assignement1 = Yeah_Adapter::getModel('groups', 'Groups_Users');
        $assignement2 = Yeah_Adapter::getModel('teams', 'Teams_Users');
        $group_members1 = $group->findmodules_users_models_UsersViamodules_groups_models_Groups_Users();
        $group_members2 = array();
        foreach ($group_members1 as $member) {
            $assign = $group->getAssignement($member);
            if ($assign->type != 'auxiliar') {
                $flag = true;
                foreach ($listteams as $team) {
                    $assign = $assignement2->findByTeamAndUser($team->ident, $member->ident);
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
            $session = new Zend_Session_Namespace();

            $selects = $request->getParam('team');
            foreach ($selects as $member_ident => $team_ident) {
                // FIXME
                $assign = $assignement2->createRow();
                $assign->team = $team_ident;
                $assign->user = $member_ident;
                $assign->tsregister = time();
                $assign->save();
            }
            
            $session->messages->addMessage('La asignacion de equipos ha sido almacenada');
            $this->_redirect($request->getParam('return'));
        }

        $this->view->subject = $subject;
        $this->view->group = $group;
        $this->view->members = $group_members2;

        history('subjects/' . $subject->url . '/groups/' . $group->url . '/teams/assign');
        $breadcrumb = array();
        if (Yeah_Acl::hasPermission('subjects', array('new', 'import', 'export', 'lock', 'delete'))) {
            $breadcrumb['Materias'] = $this->view->url(array(), 'subjects_manager');
        } else if (Yeah_Acl::hasPermission('subjects', 'list')) {
            $breadcrumb['Materias'] = $this->view->url(array(), 'subjects_list');
        }
        if (Yeah_Acl::hasPermission('subjects', 'view')) {
            $breadcrumb[$subject->label] = $this->view->url(array('subject' => $subject->url), 'subjects_subject_view');
            if ($subject->amModerator()) {
                $breadcrumb['Grupos'] = $this->view->url(array('subject' => $subject->url), 'groups_manager');
            }
            $breadcrumb[$group->label] = $this->view->url(array('subject' => $subject->url, 'group' => $group->url), 'groups_group_view');
            if ($group->amTeacher()) {
                $breadcrumb['Equipos'] = $this->view->url(array('subject' => $subject->url, 'group' => $group->url), 'teams_manager');
            }
        }
        breadcrumb($breadcrumb);
    }
}
