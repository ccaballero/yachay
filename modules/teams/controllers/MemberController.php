<?php

class Teams_MemberController extends Yeah_Action
{
    public function deleteAction () {
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

        $teams = Yeah_Adapter::getModel('teams');
        $urlteam = $request->getParam('team');
        $team = $teams->findByUrl($group->ident, $urlteam);
        $this->requireExistenceTeam($team, $group, $subject);
        $this->requireMemberTeam($team);

        $users = Yeah_Adapter::getModel('users');
        $urluser = $request->getParam('user');
        $user = $users->findByUrl($urluser);
        $this->requireExistence($user, 'user', 'users_user_view', 'users_list');

        $assignement = Yeah_Adapter::getModel('teams', 'Teams_Users');
        $assign = $assignement->findByTeamAndUser($team->ident, $user->ident);
        $assign->delete();

        $session = new Zend_Session_Namespace();
        $session->messages->addMessage('El usuario ' . $user->label . ' ha sido retirado del equipo');

        $this->_redirect($this->view->currentPage());
    }
}
