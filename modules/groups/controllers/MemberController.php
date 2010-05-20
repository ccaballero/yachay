<?php

class Groups_MemberController extends Yeah_Action
{
    public function lockAction() {
        $this->requirePermission('subjects', 'teach');

        $request = $this->getRequest();
        $gestions = Yeah_Adapter::getModel('gestions');
        $gestion = $gestions->findByActive();

        $users_model = Yeah_Adapter::getModel('users');
        $subjects_model = Yeah_Adapter::getModel('subjects');
        $user_url = $request->getParam('user');
        $subject_url = $request->getParam('subject');

        $user = $users_model->findByUrl($user_url);
        $subject = $subjects_model->findByUrl($gestion->ident, $subject_url);

        $this->requireExistence($subject, 'subject', 'subjects_subject_view', 'subjects_list');

        $groups_model = Yeah_Adapter::getModel('groups');
        $group_url = $request->getParam('group');
        $group = $groups_model->findByUrl($subject->ident, $group_url);
        $this->requireExistenceGroup($group, $subject);
        $this->requireTeacher($group);

        $assignement = Yeah_Adapter::getModel('groups', 'Groups_Users');
        $assign = $assignement->findByGroupAndUser($group->ident, $user->ident);
        $assign->status = 'inactive';
        $assign->save();

        $session = new Zend_Session_Namespace();
        $session->messages->addMessage('El usuario ' . $user->label . ' ha sido deshabilitado del grupo');

        $this->_redirect($this->view->currentPage());
    }

    public function unlockAction() {
        $this->requirePermission('subjects', 'teach');

        $request = $this->getRequest();
        $gestions = Yeah_Adapter::getModel('gestions');
        $gestion = $gestions->findByActive();

        $users_model = Yeah_Adapter::getModel('users');
        $subjects_model = Yeah_Adapter::getModel('subjects');
        $user_url = $request->getParam('user');
        $subject_url = $request->getParam('subject');

        $user = $users_model->findByUrl($user_url);
        $subject = $subjects_model->findByUrl($gestion->ident, $subject_url);

        $this->requireExistence($subject, 'subject', 'subjects_subject_view', 'subjects_list');

        $groups_model = Yeah_Adapter::getModel('groups');
        $group_url = $request->getParam('group');
        $group = $groups_model->findByUrl($subject->ident, $group_url);
        $this->requireExistenceGroup($group, $subject);
        $this->requireTeacher($group);

        $assignement = Yeah_Adapter::getModel('groups', 'Groups_Users');
        $assign = $assignement->findByGroupAndUser($group->ident, $user->ident);
        $assign->status = 'active';
        $assign->save();

        $session = new Zend_Session_Namespace();
        $session->messages->addMessage('El usuario ' . $user->label . ' ha sido habilitado del grupo');

        $this->_redirect($this->view->currentPage());
    }

    public function deleteAction() {
        $this->requirePermission('subjects', 'teach');

        $request = $this->getRequest();
        $gestions = Yeah_Adapter::getModel('gestions');
        $gestion = $gestions->findByActive();

        $users_model = Yeah_Adapter::getModel('users');
        $subjects_model = Yeah_Adapter::getModel('subjects');
        $user_url = $request->getParam('user');
        $subject_url = $request->getParam('subject');

        $user = $users_model->findByUrl($user_url);
        $subject = $subjects_model->findByUrl($gestion->ident, $subject_url);

        $this->requireExistence($subject, 'subject', 'subjects_subject_view', 'subjects_list');

        $groups_model = Yeah_Adapter::getModel('groups');
        $group_url = $request->getParam('group');
        $group = $groups_model->findByUrl($subject->ident, $group_url);
        $this->requireExistenceGroup($group, $subject);
        $this->requireTeacher($group);

        $assignement = Yeah_Adapter::getModel('groups', 'Groups_Users');
        $assign = $assignement->findByGroupAndUser($group->ident, $user->ident);
        $assign->delete();

        $session = new Zend_Session_Namespace();
        $session->messages->addMessage('El usuario ' . $user->label . ' ha sido retirado del grupo');

        $this->_redirect($this->view->currentPage());
    }
}
