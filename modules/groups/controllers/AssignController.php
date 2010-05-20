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
            $breadcrumb[$group->label] = $this->view->url(array('subject' => $subject->url, 'group' => $group->url), 'groups_group_view');
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
            $breadcrumb[$group->label] = $this->view->url(array('subject' => $subject->url, 'group' => $group->url), 'groups_group_view');
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

        $request = $this->getRequest();
        $gestions = Yeah_Adapter::getModel('gestions');
        $gestion = $gestions->findByActive();

        $users_model = Yeah_Adapter::getModel('users');
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

        if ($request->isPost()) {
            $session = new Zend_Session_Namespace();
            $upload = new Zend_File_Transfer_Adapter_Http();
            $upload->setDestination($CONFIG->dirroot . 'media/upload');
            $upload->addValidator('Size', false, 2097152)
                   ->addValidator('Extension', false, array('csv'));

            if ($upload->receive()) {
                $filename = $upload->getFileName('file');
                $extension = strtolower(substr($filename, -3));
                $count = 0;
                $assignement1 = Yeah_Adapter::getModel('subjects', 'Subjects_Users');
                $assignement2 = Yeah_Adapter::getModel('groups', 'Groups_Users');
                $types = array(
                    'auxiliar'   => array('helper', 'auxiliar'),
                    'estudiante' => array('study', 'student'),
                    'invitado'   => array('participate', 'guest'),
                );

                switch ($extension) {
                    case 'csv':
                        $csv = new File_CSV_DataSource;
                        $csv->load($filename); //se carga el archivo
                        $rows = $csv->connect(); //te devuelve el contenido del archivo
                        // FIXME
                        if (($csv->hasColumn('Codigo') || $csv->hasColumn('Usuario')) && ($csv->hasColumn('Cargo'))) {
                            if ($csv->hasColumn('Codigo')) {
                                $method = 'findByCode';
                                $key = 'Codigo';
                            } else {
                                $method = 'findByLabel';
                                $key = 'Usuario';
                            }
                            foreach ($rows as $row) {
                                $user_info = $row[$key];
                                $user = $users_model->{$method}($user_info);
                                if (!empty($user)) {
                                    if (!empty($row['Cargo'])) {
                                        if (isset($types[strtolower($row['Cargo'])])) {
                                            $type = $types[strtolower($row['Cargo'])];
                                            if ($user->hasPermission('subjects', $type[0])) {
                                                $assign1 = $assignement1->findBySubjectAndUser($subject->ident, $user->ident);
                                                if (!empty($assign1)) {
                                                    $assign2 = $assignement2->findByGroupAndUser($group->ident, $user->ident);
                                                    if (empty($assign2)) {
                                                        $assign2 = $assignement2->createRow();
                                                        $assign2->group = $group->ident;
                                                        $assign2->user = $user->ident;
                                                        $assign2->type = $type[1];
                                                        $assign2->tsregister = time();
                                                        $assign2->save();
                                                        $count++;
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                            $session->messages->addMessage("Se han insertado $count miembros al grupo");
                            unlink($filename);
                        } else {
                            $session->messages->addMessage("Una de los columnas requeridas no se encuentran");
                        }
                        break;
                }
            }
        }

        history('subjects/' . $subject->url . '/group/' . $group->label . '/assign/import/');
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

                    $headers = array("Codigo", "Usuario", "Cargo");
                    $csv .= implode(', ', $headers) . '
';
                    $auxiliars = $group->findmodules_users_models_UsersViamodules_groups_models_Groups_Users($group->select()->where('type = ?', 'auxiliar'));
                    $students = $group->findmodules_users_models_UsersViamodules_groups_models_Groups_Users($group->select()->where('type = ?', 'student'));
                    $guests = $group->findmodules_users_models_UsersViamodules_groups_models_Groups_Users($group->select()->where('type = ?', 'guest'));

                    foreach ($auxiliars as $auxiliar) {
                        $row = array('"' . $auxiliar->code . '"', '"' . $auxiliar->label . '"', '"Auxiliar"');
                        $csv .= implode(', ', $row) . '
';
                    }
                    foreach ($students as $student) {
                        $row = array('"' . $student->code . '"', '"' . $student->label . '"', '"Estudiante"');
                        $csv .= implode(', ', $row) . '
';
                    }
                    foreach ($guests as $guest) {
                        $row = array('"' . $guest->code . '"', '"' . $guest->label . '"', '"Invitado"');
                        $csv .= implode(', ', $row) . '
';
                    }

                    header("HTTP/1.1 200 OK"); //mandamos código de OK
                    header("Status: 200 OK"); //sirve para corregir un bug de IE (fuente: php.net)
                    header('Content-Type: text/csv');
                    header('Content-Disposition: attachment; filename="miembros.csv"');
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
            $breadcrumb[$group->label] = $this->view->url(array('subject' => $subject->url, 'group' => $group->url), 'groups_group_view');
            $breadcrumb['Miembros'] = $this->view->url(array('subject' => $subject->url, 'group' => $group->url), 'groups_group_assign');
        }
        breadcrumb($breadcrumb);
    }
}
