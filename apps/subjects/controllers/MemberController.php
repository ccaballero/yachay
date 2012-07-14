<?php

class Subjects_MemberController extends Yachay_Controller_Action
{
    public function lockAction() {
        $this->requirePermission('subjects', 'moderate');

        $request = $this->getRequest();

        $gestions = new Gestions();
        $gestion = $gestions->findByActive();

        $model_users = new Users();
        $model_subjects = new Subjects();

        $url_user = $request->getParam('user');
        $url_subject = $request->getParam('subject');

        $user = $model_users->findByUrl($url_user);
        $subject = $model_subjects->findByUrl($gestion->ident, $url_subject);

        $this->requireExistence($subject, 'subject', 'subjects_subject_view', 'subjects_list');
        $this->requireModerator($subject);

        $model_subjects_users = new Subjects_Users();
        $assign = $model_subjects_users->findBySubjectAndUser($subject->ident, $user->ident);
        $assign->status = 'inactive';
        $assign->save();

        $this->_helper->flashMessenger->addMessage('El usuario ' . $user->label . ' ha sido deshabilitado de la materia');
        $this->_redirect($this->view->currentPage());
    }

    public function unlockAction() {
        $this->requirePermission('subjects', 'moderate');

        $request = $this->getRequest();
        $gestions = new Gestions();
        $gestion = $gestions->findByActive();

        $model_users = new Users();
        $model_subjects = new Subjects();
        $url_user = $request->getParam('user');
        $url_subject = $request->getParam('subject');

        $user = $model_users->findByUrl($url_user);
        $subject = $model_subjects->findByUrl($gestion->ident, $url_subject);

        $this->requireExistence($subject, 'subject', 'subjects_subject_view', 'subjects_list');
        $this->requireModerator($subject);

        $model_subjects_users = new Subjects_Users();
        $assign = $model_subjects_users->findBySubjectAndUser($subject->ident, $user->ident);
        $assign->status = 'active';
        $assign->save();

        $this->_helper->flashMessenger->addMessage('El usuario ' . $user->label . ' ha sido habilitado de la materia');
        $this->_redirect($this->view->currentPage());
    }

    public function deleteAction() {
        $this->requirePermission('subjects', 'moderate');

        $request = $this->getRequest();
        $gestions = new Gestions();
        $gestion = $gestions->findByActive();

        $model_users = new Users();
        $model_subjects = new Subjects();
        $url_user = $request->getParam('user');
        $url_subject = $request->getParam('subject');

        $user = $model_users->findByUrl($url_user);
        $subject = $model_subjects->findByUrl($gestion->ident, $url_subject);

        $this->requireExistence($subject, 'subject', 'subjects_subject_view', 'subjects_list');
        $this->requireModerator($subject);
        
        $model_subjects_users = new Subjects_Users();
        $assign = $model_subjects_users->findBySubjectAndUser($subject->ident, $user->ident);
        $assign->delete();

        $this->_helper->flashMessenger->addMessage('El usuario ' . $user->label . ' ha sido retirado de la materia');
        $this->_redirect($this->view->currentPage());
    }
}
