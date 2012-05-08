<?php

class Groups_MemberController extends Yachay_Controller_Action
{
    public function lockAction() {
        $this->requirePermission('subjects', 'teach');

        $request = $this->getRequest();
        $model_gestions = new Gestions();
        $active_gestion = $model_gestions->findByActive();

        $model_users = new Users();
        $model_subjects = new Subjects();
        $url_user = $request->getParam('user');
        $url_subject = $request->getParam('subject');

        $user = $model_users->findByUrl($url_user);
        $subject = $model_subjects->findByUrl($active_gestion->ident, $url_subject);

        $this->requireExistence($subject, 'subject', 'subjects_subject_view', 'subjects_list');

        $model_groups = new Groups();
        $url_group = $request->getParam('group');
        $group = $model_groups->findByUrl($subject->ident, $url_group);
        $this->requireExistenceGroup($group, $subject);
        $this->requireTeacher($group);

        $model_groups_users = new Groups_Users();
        $assign = $model_groups_users->findByGroupAndUser($group->ident, $user->ident);
        $assign->status = 'inactive';
        $assign->save();

        $this->_helper->flashMessenger->addMessage('El usuario ' . $user->label . ' ha sido deshabilitado del grupo');
        $this->_redirect($this->view->currentPage());
    }

    public function unlockAction() {
        $this->requirePermission('subjects', 'teach');

        $request = $this->getRequest();
        $model_gestions = new Gestions();
        $active_gestion = $model_gestions->findByActive();

        $model_users = new Users();
        $model_subjects = new Subjects();
        $url_user = $request->getParam('user');
        $url_subject = $request->getParam('subject');

        $user = $model_users->findByUrl($url_user);
        $subject = $model_subjects->findByUrl($active_gestion->ident, $url_subject);

        $this->requireExistence($subject, 'subject', 'subjects_subject_view', 'subjects_list');

        $model_groups = new Groups();
        $url_group = $request->getParam('group');
        $group = $model_groups->findByUrl($subject->ident, $url_group);
        $this->requireExistenceGroup($group, $subject);
        $this->requireTeacher($group);

        $model_groups_users = new Groups_Users();
        $assign = $model_groups_users->findByGroupAndUser($group->ident, $user->ident);
        $assign->status = 'active';
        $assign->save();

        $this->_helper->flashMessenger->addMessage('El usuario ' . $user->label . ' ha sido habilitado del grupo');
        $this->_redirect($this->view->currentPage());
    }

    public function deleteAction() {
        $this->requirePermission('subjects', 'teach');

        $request = $this->getRequest();
        $model_gestions = new Gestions();
        $active_gestion = $model_gestions->findByActive();

        $model_users = new Users();
        $model_subjects = new Subjects();
        $url_user = $request->getParam('user');
        $url_subject = $request->getParam('subject');

        $user = $model_users->findByUrl($url_user);
        $subject = $model_subjects->findByUrl($active_gestion->ident, $url_subject);

        $this->requireExistence($subject, 'subject', 'subjects_subject_view', 'subjects_list');

        $model_groups = new Groups();
        $url_group = $request->getParam('group');
        $group = $model_groups->findByUrl($subject->ident, $url_group);
        $this->requireExistenceGroup($group, $subject);
        $this->requireTeacher($group);

        $model_groups_users = new Groups_Users();
        $assign = $model_groups_users->findByGroupAndUser($group->ident, $user->ident);
        $assign->delete();

        $this->_helper->flashMessenger->addMessage('El usuario ' . $user->label . ' ha sido retirado del grupo');
        $this->_redirect($this->view->currentPage());
    }
}
