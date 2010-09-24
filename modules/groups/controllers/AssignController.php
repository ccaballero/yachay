<?php

class Groups_AssignController extends Yeah_Action
{
    public function indexAction() {
        $this->requirePermission('subjects', 'view');

        $request = $this->getRequest();
        if ($request->isPost()) {
            if (Yeah_Acl::hasPermission('subjects', 'teach')) {
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

        context('group', $group);

        $auxiliars = $group->findmodules_users_models_UsersViamodules_groups_models_Groups_Users($group->select()->where('type = ?', 'auxiliar'));
        $students = $group->findmodules_users_models_UsersViamodules_groups_models_Groups_Users($group->select()->where('type = ?', 'student'));
        $guests = $group->findmodules_users_models_UsersViamodules_groups_models_Groups_Users($group->select()->where('type = ?', 'guest'));

        $this->view->subject = $subject;
        $this->view->group = $group;
        $this->view->auxiliars = $auxiliars;
        $this->view->students = $students;
        $this->view->guests = $guests;

        history('subjects/' . $subject->url . '/groups/' . $group->url . '/assign/');
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
            $breadcrumb['Grupo ' . $group->label] = $this->view->url(array('subject' => $subject->url, 'group' => $group->url), 'groups_group_view');
        }
        breadcrumb($breadcrumb);
    }

    public function newAction() {
        global $USER;

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

        context('group', $group);

        $model = Yeah_Adapter::getModel('users');
        $assignement = Yeah_Adapter::getModel('groups', 'Groups_Users');
        $users = $subject->findmodules_users_models_UsersViamodules_subjects_models_Subjects_Users();

        $filtered = array();
        foreach ($users as $user) {
            if ($user->status == 'active') {
                if ($user->hasPermission('subjects', 'helper') || $user->hasPermission('subjects', 'study') || $user->hasPermission('subjects', 'participate')) {
                    if ($USER->ident != $user->ident) {
                        if ($user->hasPermission('subjects', 'helper') || $user->hasPermission('subjects', 'participate')) {
                            $assign = $assignement->findByGroupAndUser($group->ident, $user->ident);
                            if (empty($assign)) {
                                $filtered[] = $user;
                            }
                        } else if ($user->hasPermission('subjects', 'study')) {
                            $assign = $assignement->findByGroupAndUser($group->ident, $user->ident);
                            if (empty($assign)) {
                                $filtered[] = $user;
                            }
                        }
                    }
                }
            }
        }

        if ($request->isPost()) {
            $session = new Zend_Session_Namespace();
            $users = $request->getParam('users');
            $types = array('auxiliar', 'student', 'guest');

            foreach ($users as $ident_user => $type_assign) {
                $user = $model->findByIdent($ident_user);
                if (!empty($user)) {
                    if (in_array($type_assign, $types)) {
                        $assign = $assignement->createRow();
                        $assign->group = $group->ident;
                        $assign->user = $user->ident;
                        $assign->type = strtolower($type_assign);
                        $assign->tsregister = time();
                        $assign->save();
                    }
                }
            }

            $session->messages->addMessage("Se registraron las asignaciones hechas");
            $session->url = $subject->url;
            $this->_redirect($request->getParam('return'));
        }

        $this->view->model = $model;
        $this->view->subject = $subject;
        $this->view->group = $group;
        $this->view->users = $filtered;

        history('subjects/' . $subject->url . '/groups/' . $group->url . '/assign/new/');
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
            $breadcrumb['Grupo ' . $group->label] = $this->view->url(array('subject' => $subject->url, 'group' => $group->url), 'groups_group_view');
            $breadcrumb['Miembros'] = $this->view->url(array('subject' => $subject->url, 'group' => $group->url), 'groups_group_assign');
        }
        breadcrumb($breadcrumb);
    }

    public function lockAction() {
        $this->requirePermission('subjects', 'teach');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $gestions = Yeah_Adapter::getModel('gestions');
            $gestion = $gestions->findByActive();

            $users_model = Yeah_Adapter::getModel('users');
            $subjects_model = Yeah_Adapter::getModel('subjects');
            $subject_url = $request->getParam('subject');
            $subject = $subjects_model->findByUrl($gestion->ident, $subject_url);
            $this->requireExistence($subject, 'subject', 'subjects_subject_view', 'subjects_list');

            $groups_model = Yeah_Adapter::getModel('groups');
            $group_url = $request->getParam('group');
            $group = $groups_model->findByUrl($subject->ident, $group_url);
            $this->requireExistenceGroup($group, $subject);
            $this->requireTeacher($group);

            $assignement = Yeah_Adapter::getModel('groups', 'Groups_Users');
            $members = $request->getParam("members");

            foreach ($members as $member) {
                $user = $users_model->findByIdent($member);
                if (!empty($user)) {
                    $assign = $assignement->findByGroupAndUser($group->ident, $user->ident);
                    $assign->status = 'inactive';
                    $assign->save();
                }
            }
            $count = count($members);

            $session = new Zend_Session_Namespace();
            $session->messages->addMessage("Se han deshabilitado $count miembros");
        }
        $this->_redirect($this->view->currentPage());
    }

    public function unlockAction() {
        $this->requirePermission('subjects', 'teach');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $gestions = Yeah_Adapter::getModel('gestions');
            $gestion = $gestions->findByActive();

            $users_model = Yeah_Adapter::getModel('users');
            $subjects_model = Yeah_Adapter::getModel('subjects');
            $subject_url = $request->getParam('subject');
            $subject = $subjects_model->findByUrl($gestion->ident, $subject_url);
            $this->requireExistence($subject, 'subject', 'subjects_subject_view', 'subjects_list');

            $groups_model = Yeah_Adapter::getModel('groups');
            $group_url = $request->getParam('group');
            $group = $groups_model->findByUrl($subject->ident, $group_url);
            $this->requireExistenceGroup($group, $subject);
            $this->requireTeacher($group);

            $assignement = Yeah_Adapter::getModel('groups', 'Groups_Users');
            $members = $request->getParam("members");

            foreach ($members as $member) {
                $user = $users_model->findByIdent($member);
                if (!empty($user)) {
                    $assign = $assignement->findByGroupAndUser($group->ident, $user->ident);
                    $assign->status = 'active';
                    $assign->save();
                }
            }
            $count = count($members);

            $session = new Zend_Session_Namespace();
            $session->messages->addMessage("Se han habilitado $count miembros");
        }
        $this->_redirect($this->view->currentPage());
    }

    public function deleteAction() {
        $this->requirePermission('subjects', 'teach');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $gestions = Yeah_Adapter::getModel('gestions');
            $gestion = $gestions->findByActive();

            $users_model = Yeah_Adapter::getModel('users');
            $subjects_model = Yeah_Adapter::getModel('subjects');
            $subject_url = $request->getParam('subject');
            $subject = $subjects_model->findByUrl($gestion->ident, $subject_url);
            $this->requireExistence($subject, 'subject', 'subjects_subject_view', 'subjects_list');

            $groups_model = Yeah_Adapter::getModel('groups');
            $group_url = $request->getParam('group');
            $group = $groups_model->findByUrl($subject->ident, $group_url);
            $this->requireExistenceGroup($group, $subject);
            $this->requireTeacher($group);

            $assignement = Yeah_Adapter::getModel('groups', 'Groups_Users');
            $members = $request->getParam("members");

            foreach ($members as $member) {
                $user = $users_model->findByIdent($member);
                if (!empty($user)) {
                    $assign = $assignement->findByGroupAndUser($group->ident, $user->ident);
                    $assign->delete();
                }
            }
            $count = count($members);

            $session = new Zend_Session_Namespace();
            $session->messages->addMessage("Se han retirado $count miembros");
        }
        $this->_redirect($this->view->currentPage());
    }

    public function importAction() {
        global $CONFIG;

        $this->requirePermission('subjects', 'teach');

        $gestions = Yeah_Adapter::getModel('gestions');
        $gestion = $gestions->findByActive();

        $request = $this->getRequest();

        $subjects_model = Yeah_Adapter::getModel('subjects');
        $subject_url = $request->getParam('subject');
        $subject = $subjects_model->findByUrl($gestion->ident, $subject_url);
        $this->requireExistence($subject, 'subject', 'subjects_subject_view', 'subjects_list');

        $groups = Yeah_Adapter::getModel('groups');
        $group_url = $request->getParam('group');
        $group = $groups->findByUrl($subject->ident, $group_url);
        $this->requireExistenceGroup($group, $subject);
        $this->requireTeacher($group);

        context('group', $group);
        $this->view->step = 1;
        $this->view->subject = $subject;
        $this->view->group = $group;

        if ($request->isPost()) {
            $session = new Zend_Session_Namespace();
            $users_model = Yeah_Adapter::getModel('users');

            $types = array(
                'auxiliar'   => array('helper', 'auxiliar'),
                'estudiante' => array('study', 'student'),
                'invitado'   => array('participate', 'guest'),
            );
            $_types = array(
                'auxiliar' => 'Auxiliar',
                'student'  => 'Estudiante',
                'guest'    => 'Invitado',
            );

            $selections = $request->getParam('users');
            if (empty($selections)) {
                $upload = new Zend_File_Transfer_Adapter_Http();
                $upload->setDestination($CONFIG->dirroot . 'media/upload');
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

                            $headers = $csv->getHeaders();
                            $_headers = array();
                            foreach ($headers as $header) {
                                $key = trim(strtoupper(normalize($header)));
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
                                    $user = $users_model->{$method}($user_info);

                                    if (!empty($user)) {
                                        $result['CODIGO'] = $user->code;
                                        $result['USUARIO_OBJ'] = $user;
                                        $result['ERROR'] = FALSE;
                                        $result['ASSIGN_RES'] = TRUE;

                                        $result['CARGO'] = isset($_headers['CARGO']) ? $row[$_headers['CARGO']] : $_types[$type];
                                        $assign_type = trim(strtolower(normalize($result['CARGO'])));

                                        if (isset($types[$assign_type])) {
                                            if ($user->hasPermission('subjects', $types[$assign_type][0])) {
                                                $assign_subject = Yeah_Adapter::getModel('subjects', 'Subjects_Users');
                                                $assign_group = Yeah_Adapter::getModel('groups', 'Groups_Users');

                                                $assign1 = $assign_subject->findBySubjectAndUser($subject->ident, $user->ident);
                                                if (!empty($assign1)) {
                                                    $assign2 = $assign_group->findByGroupAndUser($group->ident, $user->ident);
                                                    if (empty($assign2)) {
                                                        $result['ACL'] = $types[$assign_type][0];
                                                        $result['TYPE'] = $types[$assign_type][1];
                                                        $result['ASSIGN_RES'] = FALSE;
                                                    } else {
                                                        $result['CARGO_MES'] = 'El usuario ya esta asignado a este grupo';
                                                    }
                                                } else {
                                                    $result['CARGO_MES'] = 'El usuario no esta asignado a la materia';
                                                }
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
                                    $session->messages->addMessage('La columna CODIGO no fue encontrada');
                                    $this->_redirect($this->view->currentPage());

                                }
                                if (!$csv->hasColumn($_headers['USUARIO'])) {
                                    $session->messages->addMessage('La columna USUARIO no fue encontrada');
                                    $this->_redirect($this->view->currentPage());
                                }
                            }
                        break;
                    }
                    unlink($filename);
                }
            } else {
                if (isset($session->assign_users)) {
                    $assign_subject = Yeah_Adapter::getModel('subjects', 'Subjects_Users');
                    $assign_group = Yeah_Adapter::getModel('groups', 'Groups_Users');

                    $count_new = 0;
                    $count_over = 0;

                    foreach ($session->assign_users as $result) {
                        if (in_array($result['CODIGO'], $selections)) {
                            $user = $result['USUARIO_OBJ'];
                            if ($user->hasPermission('subjects', $result['ACL'])) {
                                $assign1 = $assign_subject->findBySubjectAndUser($subject->ident, $user->ident);
                                if (!empty($assign1)) {
                                    $assign2 = $assign_group->findByGroupAndUser($group->ident, $user->ident);
                                    if (empty($assign2)) {
                                        $assign = $assign_group->createRow();
                                        $assign->group = $group->ident;
                                        $assign->user = $user->ident;
                                        $assign->type = $result['TYPE'];
                                        $assign->status = TRUE;
                                        $assign->tsregister = time();
                                        $assign->save();
                                        $count_new++;
                                    } else {
                                        $count_over++;
                                    }
                                } else {
                                    $count_over++;
                                }
                            }
                        }
                    }
                    $session->messages->addMessage("Se han asignado $count_new usuarios al grupo y se saltaron $count_over usuarios ");
                    $this->_redirect($this->view->currentPage());
                }
                unset($session->assign_users);
            }
        }

        history('subjects/' . $subject->url . '/groups/' . $group->url . '/assign/import/');
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
            $breadcrumb['Grupo ' .$group->label] = $this->view->url(array('subject' => $subject->url, 'group' => $group->url), 'groups_group_view');
            $breadcrumb['Miembros'] = $this->view->url(array('subject' => $subject->url, 'group' => $group->url), 'groups_group_assign');
        }
        breadcrumb($breadcrumb);
    }

    public function exportAction() {
        $this->requirePermission('subjects', 'teach');

        $request = $this->getRequest();
        $gestions = Yeah_Adapter::getModel('gestions');
        $gestion = $gestions->findByActive();

        $users_model = Yeah_Adapter::getModel('users');
        $subjects_model = Yeah_Adapter::getModel('subjects');
        $subject_url = $request->getParam('subject');
        $subject = $subjects_model->findByUrl($gestion->ident, $subject_url);
        $this->requireExistence($subject, 'subject', 'subjects_subject_view', 'subjects_list');

        $groups_model = Yeah_Adapter::getModel('groups');
        $group_url = $request->getParam('group');
        $group = $groups_model->findByUrl($subject->ident, $group_url);
        $this->requireExistenceGroup($group, $subject);
        $this->requireTeacher($group);

        context('group', $group);

        if ($request->isPost()) {
            $extension = $request->getParam('extension');
            switch ($extension) {
                case 'csv':
                    $csv = '';

                    $headers = array('"Codigo"', '"Nombre Completo"', '"Usuario"', '"Cargo"');
                    $csv .= implode(', ', $headers) . '
';
                    $auxiliars = $group->findmodules_users_models_UsersViamodules_groups_models_Groups_Users($group->select()->where('type = ?', 'auxiliar'));
                    $students = $group->findmodules_users_models_UsersViamodules_groups_models_Groups_Users($group->select()->where('type = ?', 'student'));
                    $guests = $group->findmodules_users_models_UsersViamodules_groups_models_Groups_Users($group->select()->where('type = ?', 'guest'));

                    foreach ($auxiliars as $auxiliar) {
                        $row = array('"' . $auxiliar->code . '"', '"' . $auxiliar->formalname . '"', '"' . $auxiliar->label . '"', '"Auxiliar"');
                        $csv .= implode(', ', $row) . '
';
                    }
                    foreach ($students as $student) {
                        $row = array('"' . $student->code . '"', '"' . $student->formalname . '"', '"' . $student->label . '"', '"Estudiante"');
                        $csv .= implode(', ', $row) . '
';
                    }
                    foreach ($guests as $guest) {
                        $row = array('"' . $guest->code . '"', '"' . $guest->formalname . '"', '"' . $guest->label . '"', '"Invitado"');
                        $csv .= implode(', ', $row) . '
';
                    }

                    header("HTTP/1.1 200 OK"); //mandamos código de OK
                    header("Status: 200 OK"); //sirve para corregir un bug de IE (fuente: php.net)
                    header('Content-Type: text/csv');
                    header('Content-Disposition: attachment; filename="' . $subject->label .' (Grupo ' . $group->label . ')' . '.csv"');
                    header('Content-Length: '. strlen($csv));
                    echo $csv;
                    die();
                    break;
            }
        }

        history('subjects/' . $subject->url . '/groups/' . $group->url . '/assign/export/');
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
            $breadcrumb['Grupo ' . $group->label] = $this->view->url(array('subject' => $subject->url, 'group' => $group->url), 'groups_group_view');
            $breadcrumb['Miembros'] = $this->view->url(array('subject' => $subject->url, 'group' => $group->url), 'groups_group_assign');
        }
        breadcrumb($breadcrumb);
    }
}
