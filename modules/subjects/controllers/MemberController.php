<?php

class Subjects_MemberController extends Yeah_Action
{
    public function lockAction() {
        $this->requirePermission('subjects', 'moderate');

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
        $this->requireModerator($subject);

        $assignement = Yeah_Adapter::getModel('subjects', 'Subjects_Users');
        $assign = $assignement->findBySubjectAndUser($subject->ident, $user->ident);
        $assign->status = 'inactive';
        $assign->save();

        $session = new Zend_Session_Namespace();
        $session->messages->addMessage('El usuario ' . $user->label . ' ha sido deshabilitado de la materia');

        $this->_redirect($this->view->currentPage());
    }

    public function unlockAction() {
        $this->requirePermission('subjects', 'moderate');

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
        $this->requireModerator($subject);

        $assignement = Yeah_Adapter::getModel('subjects', 'Subjects_Users');
        $assign = $assignement->findBySubjectAndUser($subject->ident, $user->ident);
        $assign->status = 'active';
        $assign->save();

        $session = new Zend_Session_Namespace();
        $session->messages->addMessage('El usuario ' . $user->label . ' ha sido habilitado de la materia');

        $this->_redirect($this->view->currentPage());
    }

    public function deleteAction() {
        $this->requirePermission('subjects', 'moderate');

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
        $this->requireModerator($subject);
        
        $assignement = Yeah_Adapter::getModel('subjects', 'Subjects_Users');
        $assign = $assignement->findBySubjectAndUser($subject->ident, $user->ident);
        $assign->delete();

        $session = new Zend_Session_Namespace();
        $session->messages->addMessage('El usuario ' . $user->label . ' ha sido retirado de la materia');

        $this->_redirect($this->view->currentPage());
    }
}
