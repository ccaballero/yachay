<?php

class Subjects_AssignController extends Yachay_Controller_Action
{
    public function indexAction() {
        $this->requirePermission('subjects', 'view');

        $request = $this->getRequest();
        if ($request->isPost()) {
            if ($this->acl('subjects', 'moderate')) {
                $lock = $request->getParam('lock');
                $unlock = $request->getParam('unlock');
                if (!empty($lock)) {
                    $this->_forward('lock');
                } else if (!empty($unlock)) {
                    $this->_forward('unlock');
                }
                $delete = $request->getParam('delete');
                if (!empty($delete)) {
                    $this->_forward('delete');
                }
            }
        }

        $model_gestions = new Gestions();
        $gestion = $model_gestions->findByActive();

        $model_subjects = new Subjects();
        $url_subject = $request->getParam('subject');
        $subject = $model_subjects->findByUrl($gestion->ident, $url_subject);
        $this->requireExistence($subject, 'subject', 'subjects_subject_view', 'subjects_list');

        $this->context('subject', $subject);

        $teachers = $subject->findUsersViaSubjects_Users($subject->select()->where('type = ?', 'teacher'));
        $auxiliars = $subject->findUsersViaSubjects_Users($subject->select()->where('type = ?', 'auxiliar'));
        $students = $subject->findUsersViaSubjects_Users($subject->select()->where('type = ?', 'student'));
        $guests = $subject->findUsersViaSubjects_Users($subject->select()->where('type = ?', 'guest'));

        $this->view->model_subjects = $model_subjects;
        $this->view->subject = $subject;
        $this->view->teachers = $teachers;
        $this->view->auxiliars = $auxiliars;
        $this->view->students = $students;
        $this->view->guests = $guests;

        if ($request->isGet()) {
            $this->history('subjects/' . $subject->url . '/assign');
        }

        $breadcrumb = array();
        if ($this->acl('subjects', 'list')) {
            $breadcrumb['Materias'] = $this->view->url(array(), 'subjects_list');
        }
        if ($this->acl('subjects', array('new', 'import', 'export', 'lock', 'delete'))) {
            $breadcrumb['Administrador de materias'] = $this->view->url(array(), 'subjects_manager');
        }
        if ($this->acl('subjects', 'view')) {
            $breadcrumb[$subject->label] = $this->view->url(array('subject' => $subject->url), 'subjects_subject_view');
        }
        $this->breadcrumb($breadcrumb);
    }

    public function newAction() {
        $this->requirePermission('subjects', 'view');
        $this->requirePermission('subjects', 'moderate');

        $request = $this->getRequest();

        $model_gestions = new Gestions();
        $model_subjects = new Subjects();

        $gestion = $model_gestions->findByActive();
        $url_subject = $request->getParam('subject');
        $subject = $model_subjects->findByUrl($gestion->ident, $url_subject);

        $this->requireExistence($subject, 'subject', 'subjects_subject_view', 'subjects_list');
        $this->requireModerator($subject);

        $this->context('subject', $subject);

        $model_users = new Users();
        $model_subjects_users = new Subjects_Users();

        $users = $model_users->selectByStatus('active');

        $filtered = array();
        foreach ($users as $user) {
            $assign = $model_subjects_users->findBySubjectAndUser($subject->ident, $user->ident);
            if (empty($assign)) {
                if ($user->hasPermission('subjects', 'teach') || $user->hasPermission('subjects', 'helper') || $user->hasPermission('subjects', 'study') || $user->hasPermission('subjects', 'participate')) {
                    $filtered[] = $user;
                }
            }
        }

        if ($request->isPost()) {
            $session = new Zend_Session_Namespace('yachay');
            $users = $request->getParam('users');
            $types = array('teacher', 'auxiliar', 'student', 'guest');

            foreach ($users as $ident_user => $type_assign) {
                $user = $model_users->findByIdent($ident_user);
                if (!empty($user)) {
                    if (in_array($type_assign, $types)) {
                        $assign = $model_subjects_users->createRow();
                        $assign->subject = $subject->ident;
                        $assign->user = $user->ident;
                        $assign->type = strtolower($type_assign);
                        $assign->tsregister = time();
                        $assign->save();
                    }
                }
            }

            $this->_helper->flashMessenger->addMessage('Se registraron las asignaciones hechas');
            $session->url = $subject->url;
            $this->_redirect($request->getParam('return'));
        } else {
            $this->history('subjects/' . $subject->url . '/assign/new');
        }

        $this->view->model_users = $model_users;
        $this->view->gestion = $gestion;
        $this->view->subject = $subject;
        $this->view->users = $filtered;

        $breadcrumb = array();
        if ($this->acl('subjects', 'list')) {
            $breadcrumb['Materias'] = $this->view->url(array(), 'subjects_list');
        }
        if ($this->acl('subjects', array('new', 'import', 'export', 'lock', 'delete'))) {
            $breadcrumb['Administrador de materias'] = $this->view->url(array(), 'subjects_manager');
        }
        if ($this->acl('subjects', 'view')) {
            $breadcrumb[$subject->label] = $this->view->url(array('subject' => $subject->url), 'subjects_subject_view');
            $breadcrumb['Miembros'] = $this->view->url(array('subject' => $subject->url), 'subjects_subject_assign');
        }
        $this->breadcrumb($breadcrumb);
    }

    public function lockAction() {
        $this->requirePermission('subjects', 'moderate');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $model_users = new Users();
            $model_gestions = new Gestions();

            $gestion = $model_gestions->findByActive();

            $model_subjects_model = new Subjects();
            $subject_url = $request->getParam('subject');
            $subject = $model_subjects_model->findByUrl($gestion->ident, $subject_url);
            $this->requireExistence($subject, 'subject', 'subjects_subject_view', 'subjects_list');
            $this->requireModerator($subject);

            $model_subjects_users = new Subjects_Users();
            $members = $request->getParam("members");

            foreach ($members as $member) {
                $user = $model_users->findByIdent($member);
                if (!empty($user)) {
                    $assign = $model_subjects_users->findBySubjectAndUser($subject->ident, $user->ident);
                    $assign->status = 'inactive';
                    $assign->save();
                }
            }
            $count = count($members);

            $this->_helper->flashMessenger->addMessage("Se han deshabilitado $count miembros");
        }

        $this->_redirect($this->view->currentPage());
    }

    public function unlockAction() {
        $this->requirePermission('subjects', 'moderate');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $model_gestions = new Gestions();
            $gestion = $model_gestions->findByActive();

            $model_users = new Users();
            $model_subjects_model = new Subjects();
            $subject_url = $request->getParam('subject');
            $subject = $model_subjects_model->findByUrl($gestion->ident, $subject_url);
            $this->requireExistence($subject, 'subject', 'subjects_subject_view', 'subjects_list');
            $this->requireModerator($subject);

            $model_subjects_users = new Subjects_Users();
            $members = $request->getParam("members");

            foreach ($members as $member) {
                $user = $model_users->findByIdent($member);
                if (!empty($user)) {
                    $assign = $model_subjects_users->findBySubjectAndUser($subject->ident, $user->ident);
                    $assign->status = 'active';
                    $assign->save();
                }
            }
            $count = count($members);

            $this->_helper->flashMessenger->addMessage("Se han habilitado $count miembros");
        }

        $this->_redirect($this->view->currentPage());
    }

    public function deleteAction() {
        $this->requirePermission('subjects', 'moderate');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $model_gestions = new Gestions();
            $gestion = $model_gestions->findByActive();

            $model_users = new Users();
            $model_subjects_model = new Subjects();
            $subject_url = $request->getParam('subject');
            $subject = $model_subjects_model->findByUrl($gestion->ident, $subject_url);
            $this->requireExistence($subject, 'subject', 'subjects_subject_view', 'subjects_list');
            $this->requireModerator($subject);

            $model_subjects_users = new Subjects_Users();
            $members = $request->getParam("members");

            foreach ($members as $member) {
                $user = $model_users->findByIdent($member);
                if (!empty($user)) {
                    $assign = $model_subjects_users->findBySubjectAndUser($subject->ident, $user->ident);
                    $assign->delete();
                }
            }
            $count = count($members);

            $this->_helper->flashMessenger->addMessage("Se han deshabilitado $count miembros");
        }

        $this->_redirect($this->view->currentPage());
    }

    public function importAction() {
        $this->requirePermission('subjects', 'moderate');

        $model_subjects = new Subjects();
        $model_gestions = new Gestions();
        $gestion = $model_gestions->findByActive();
        $this->view->gestion = $gestion;

        $request = $this->getRequest();

        $url_subject = $request->getParam('subject');
        $subject = $model_subjects->findByUrl($gestion->ident, $url_subject);

        $this->requireExistence($subject, 'subject', 'subjects_subject_view', 'subjects_list');
        $this->requireModerator($subject);

        $this->context('subject', $subject);
        $this->view->step = 1;
        $this->view->subject = $subject;

        if ($request->isPost()) {
            $session = new Zend_Session_Namespace('yachay');
            $model_users = new Users();

            $types = array(
                'docente'    => array('teach', 'teacher'),
                'auxiliar'   => array('helper', 'auxiliar'),
                'estudiante' => array('study', 'student'),
                'invitado'   => array('participate', 'guest'),
            );
            $_types = array(
                'teacher'  => 'Docente',
                'auxiliar' => 'Auxiliar',
                'student'  => 'Estudiante',
                'guest'    => 'Invitado',
            );

            $selections = $request->getParam('users');
            if (empty($selections)) {
                $upload = new Zend_File_Transfer_Adapter_Http();
                $upload->setDestination(APPLICATION_PATH . '/data/upload/');
                $upload->addValidator('Size', false, 2097152)
                       ->addValidator('Extension', false, array('csv'));

                if ($upload->receive()) {
                    $filename = $upload->getFileName('file');
                    $extension = strtolower(substr($filename, -3));

                    $type = $request->getParam('type');

                    switch ($extension) {
                        case 'csv':
                            $csv = new File_CSV_DataSource;
                            $csv->load($filename); //se carga el archivo
                            $rows = $csv->connect(); //te devuelve el contenido del archivo

                            $this->view->step = 2;
                            
                            $normalize = new Yachay_Helpers_Normalize();

                            $headers = $csv->getHeaders();
                            $_headers = array();
                            foreach ($headers as $header) {
                                $key = trim(strtoupper($normalize->normalize($header)));
                                $_headers[$key] = $header;
                            }

                            if (isset($_headers['CODIGO']) || isset($_headers['USUARIO'])) {
                                $results = array();

                                if (isset($_headers['CODIGO'])) {
                                    $method = 'findByCode';
                                    $key = 'CODIGO';
                                } else {
                                    $method = 'findByLabel';
                                    $key = 'USUARIO';
                                }

                                foreach ($rows as $row) {
                                    $result = array();

                                    $user_info = trim($row[$_headers[$key]]);
                                    $user = $model_users->{$method}($user_info);

                                    if (!empty($user)) {
                                        $result['CODIGO'] = $user->code;
                                        $result['USUARIO_OBJ'] = $user;
                                        $result['ERROR'] = FALSE;

                                        $result['CARGO'] = isset($_headers['CARGO']) ? $row[$_headers['CARGO']] : $_types[$type];
                                        $assign_type = trim(strtolower($normalize->normalize($result['CARGO'])));

                                        if (isset($types[$assign_type])) {
                                            if ($user->hasPermission('subjects', $types[$assign_type][0])) {
                                                $result['ACL'] = $types[$assign_type][0];
                                                $result['TYPE'] = $types[$assign_type][1];
                                            } else {
                                                $result['CARGO_MES'] = 'El usuario no tiene los permisos para ese cargo';
                                            }
                                        } else {
                                            $result['CARGO_MES'] = 'El cargo no es valido';
                                        }

                                    } else {
                                        $result['USUARIO'] = $user_info;
                                        $result['ERROR'] = TRUE;
                                    }

                                    $results[] = $result;
                                }

                                $this->view->headers = array('CODIGO', 'USUARIO', 'CARGO');
                                $this->view->results = $results;
                                $this->view->type = $type;

                                $session->assign_users = $results;
                            } else {
                                if (!$csv->hasColumn($_headers['CODIGO'])) {
                                    $this->_helper->flashMessenger->addMessage('La columna CODIGO no fue encontrada');
                                    $this->_redirect($this->view->currentPage());
                                }
                                if (!$csv->hasColumn($_headers['USUARIO'])) {
                                    $this->_helper->flashMessenger->addMessage('La columna USUARIO no fue encontrada');
                                    $this->_redirect($this->view->currentPage());
                                }
                            }
                        break;
                    }
                    unlink($filename);
                } else {
                    $this->_helper->flashMessenger->addMessage('Debe escoger un archivo valido para poder interpretarlo adecuadamente');
                }
            } else {
                if (isset($session->assign_users)) {
                    $model_subjects_users = new Subjects_Users();
                    $count_new = 0;
                    $count_over = 0;
                    foreach ($session->assign_users as $result) {
                        if (in_array($result['CODIGO'], $selections)) {
                            $user = $result['USUARIO_OBJ'];
                            if ($user->hasPermission('subjects', $result['ACL'])) {
                                $assign = $model_subjects_users->findBySubjectAndUser($subject->ident, $user->ident);
                                if (empty($assign)) {
                                    $assign = $model_subjects_users->createRow();
                                    $assign->subject = $subject->ident;
                                    $assign->user = $user->ident;
                                    $assign->type = $result['TYPE'];
                                    $assign->status = TRUE;
                                    $assign->tsregister = time();
                                    $assign->save();
                                    $count_new++;
                                } else {
                                    $count_over++;
                                }
                            }
                        }
                    }
                    $this->_helper->flashMessenger->addMessage("Se han asignado $count_new usuarios a la materia y se encontraron $count_over usuarios ya asignados");
                    $this->_redirect($this->view->lastPage());
                }
                unset($session->assign_users);
            }
        } else {
            $this->history('subjects/' . $subject->url . '/assign/import');
        }

        $breadcrumb = array();
        if ($this->acl('subjects', 'list')) {
            $breadcrumb['Materias'] = $this->view->url(array(), 'subjects_list');
        }
        if ($this->acl('subjects', array('new', 'import', 'export', 'lock', 'delete'))) {
            $breadcrumb['Administrador de materias'] = $this->view->url(array(), 'subjects_manager');
        }
        if ($this->acl('subjects', 'view')) {
            $breadcrumb[$subject->label] = $this->view->url(array('subject' => $subject->url), 'subjects_subject_view');
            $breadcrumb['Miembros'] = $this->view->url(array('subject' => $subject->url), 'subjects_subject_assign');
        }
        $this->breadcrumb($breadcrumb);
    }

    public function exportAction() {
        $this->requirePermission('subjects', 'moderate');
        $request = $this->getRequest();

        $model_subjects = new Subjects();
        $model_gestions = new Gestions();
        $gestion = $model_gestions->findByActive();
        $this->view->gestion = $gestion;

        $subject_url = $request->getParam('subject');
        $subject = $model_subjects->findByUrl($gestion->ident, $subject_url);
        $this->view->subject = $subject;

        $this->requireExistence($subject, 'subject', 'subjects_subject_view', 'subjects_list');
        $this->requireModerator($subject);

        $this->context('subject', $subject);

        if ($request->isPost()) {
            $extension = $request->getParam('extension');
            switch ($extension) {
                case 'csv':
                    $csv = '';

                    $headers = array('"Codigo"', '"Nombre Completo"', '"Usuario"', '"Cargo"');
                    $csv .= implode(',', $headers) . '
';
                    $teachers = $subject->findUsersViaSubjects_Users($subject->select()->where('type = ?', 'teacher'));
                    $auxiliars = $subject->findUsersViaSubjects_Users($subject->select()->where('type = ?', 'auxiliar'));
                    $students = $subject->findUsersViaSubjects_Users($subject->select()->where('type = ?', 'student'));
                    $guests = $subject->findUsersViaSubjects_Users($subject->select()->where('type = ?', 'guest'));

                    foreach ($teachers as $teacher) {
                        $row = array('"' . $teacher->code . '"', '"' . $teacher->formalname . '"', '"' . $teacher->label . '"', '"Docente"');
                        $csv .= implode(',', $row) . '
';
                    }
                    foreach ($auxiliars as $auxiliar) {
                        $row = array('"' . $auxiliar->code . '"', '"' . $auxiliar->formalname . '"', '"' . $auxiliar->label . '"', '"Auxiliar"');
                        $csv .= implode(',', $row) . '
';
                    }
                    foreach ($students as $student) {
                        $row = array('"' . $student->code . '"', '"' . $student->formalname . '"', '"' . $student->label . '"', '"Estudiante"');
                        $csv .= implode(',', $row) . '
';
                    }
                    foreach ($guests as $guest) {
                        $row = array('"' . $guest->code . '"', '"' . $guest->formalname . '"', '"' . $guest->label . '"', '"Invitado"');
                        $csv .= implode(',', $row) . '
';
                    }

                    header("HTTP/1.1 200 OK"); //mandamos código de OK
                    header("Status: 200 OK"); //sirve para corregir un bug de IE (fuente: php.net)
                    header('Content-Type: text/csv');
                    header('Content-Disposition: attachment; filename="' . $subject->label . '.csv"');
                    header('Content-Length: '. strlen($csv));
                    echo $csv;
                    die();
                    break;
            }
        } else {
            $this->history('subjects/' . $subject->url . '/assign/export');
        }

        $breadcrumb = array();
        if ($this->acl('subjects', 'list')) {
            $breadcrumb['Materias'] = $this->view->url(array(), 'subjects_list');
        }
        if ($this->acl('subjects', array('new', 'import', 'export', 'lock', 'delete'))) {
            $breadcrumb['Administrador de materias'] = $this->view->url(array(), 'subjects_manager');
        }
        if ($this->acl('subjects', 'view')) {
            $breadcrumb[$subject->label] = $this->view->url(array('subject' => $subject->url), 'subjects_subject_view');
            $breadcrumb['Miembros'] = $this->view->url(array('subject' => $subject->url), 'subjects_subject_assign');
        }
        $this->breadcrumb($breadcrumb);
    }
}
