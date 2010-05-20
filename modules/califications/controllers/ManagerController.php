<?php

class Califications_ManagerController extends Yeah_Action
{
    public function indexAction () {
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

        $users = Yeah_Adapter::getModel('users');
        $students = $group->findmodules_users_models_UsersViamodules_groups_models_Groups_Users($group->select()->where('type = ?', 'student'));

        $evaluations = Yeah_Adapter::getModel('evaluations');
        $evaluation = $group->getEvaluation();
        $evaluation_tests = $evaluation->findmodules_evaluations_models_Evaluations_Tests($evaluation->select()->order('order ASC'));

        $test_model = Yeah_Adapter::getModel('evaluations', 'Evaluations_Tests');

        $califications = Yeah_Adapter::getModel('califications');

        $this->view->model = $califications;
        $this->view->subject = $subject;
        $this->view->group = $group;
        $this->view->evaluation = $evaluation;
        $this->view->tests = $evaluation_tests;
        $this->view->students = $students;

        if ($request->isPost()) {
            $session = new Zend_Session_Namespace();

            $save = $request->getParam('save');
            $clean = $request->getParam('clean');
            $change = $request->getParam('change');
            if (!empty($save)) {
                $param_califications = $request->getParam('calification');
                foreach ($param_califications as $_group => $aux1) {
                    foreach ($aux1 as $_user => $aux2) {
                        foreach ($aux2 as $_evaluation => $aux3) {
                            foreach ($aux3 as $_test => $calification) {
                                $_calification = intval($calification);
                                if (is_int($_calification)) {
                                    // check for limits
                                    $test = $test_model->findByIdent($_test);
                                    if (!empty($test) && empty($test->formula)) {
                                        // prune action
                                        if ($_calification > $test->maximumnote) {
                                            $_calification = $test->maximumnote;
                                        } else if ($_calification < $test->minimumnote) {
                                            $_calification = $test->minimumnote;
                                        }
                                        if ($group->ident == $_group && $evaluation->ident == $_evaluation) {
                                            $note = $califications->findCalification($_group, $_user, $_evaluation, $_test);
                                            if (empty($note)) {
                                                $note = $califications->createRow();
                                            }
                                            $note->user = $_user;
                                            $note->group = $_group;
                                            $note->evaluation = $_evaluation;
                                            $note->test = $_test;
                                            $note->calification = $_calification;
                                            $note->save();
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                $session->messages->addMessage("Las calificaciones han sido almacenadas correctamente");
            } else if (!empty($clean)) {
                foreach ($students as $student) {
                    foreach ($evaluation_tests as $test) {
                        $note = $califications->findCalification($group->ident, $student->ident, $evaluation->ident, $test->ident);
                        if (!empty($note)) {
                            $note->delete();
                        }
                    }
                }
                $session->messages->addMessage("Las calificaciones han sido limpiadas");
            } else if (!empty($change)) {
                $evaluation_selected = $request->getParam('evaluation');
                $evaluation_selected = intval($evaluation_selected);
                if (!empty($evaluation_selected)) {
                    // clean
                    foreach ($students as $student) {
                        foreach ($evaluation_tests as $test) {
                            $note = $califications->findCalification($group->ident, $student->ident, $evaluation->ident, $test->ident);
                            if (!empty($note)) {
                                $note->delete();
                            }
                        }
                    }
                    // change
                    $group->evaluation = $evaluation_selected;
                    if ($group->isValid()) {
                        $group->save();
                        $session->messages->addMessage("El criterio de evaluation ha sido cambiado");
                        $this->_redirect($this->view->currentPage());
                    } else {
                        foreach ($group->getMessages() as $message) {
                            $session->messages->addMessage($message);
                        }
                    }
                }
            }
        }

        history('subjects/' . $subject->url . '/groups/' . $group->url . '/califications');
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

    public function importAction() {
        global $CONFIG;
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

        $users = Yeah_Adapter::getModel('users');
        $students = $group->findmodules_users_models_UsersViamodules_groups_models_Groups_Users($group->select()->where('type = ?', 'student'));

        $students_list = array();
        foreach ($students as $student) {
            $students_list[] = $student->ident;
        }

        $evaluations = Yeah_Adapter::getModel('evaluations');
        $evaluation = $group->getEvaluation();
        $evaluation_tests = $evaluation->findmodules_evaluations_models_Evaluations_Tests($evaluation->select()->order('order ASC'));

        $tests_list = array();
        foreach ($evaluation_tests as $evaluation_test) {
            $tests_list[] = $evaluation_test->key;
        }

        $test_model = Yeah_Adapter::getModel('evaluations', 'Evaluations_Tests');

        $califications = Yeah_Adapter::getModel('califications');

        $this->view->model = $califications;
        $this->view->subject = $subject;
        $this->view->group = $group;
        $this->view->evaluation = $evaluation;
        $this->view->tests = $evaluation_tests;
        $this->view->students = $students;

        $options = array();
        $options['REPLACE'] = 'Reemplazar las notas existentes.';
        $options['IGNORE'] = 'Ignorar las notas ya establecidas';

        $this->view->options = $options;

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
                $type = $request->getParam('type');

                switch ($extension) {
                    case 'csv':
                        $csv = new File_CSV_DataSource;
                        $csv->load($filename); //se carga el archivo
                        $rows = $csv->connect(); //te devuelve el contenido del archivo
                        // FIXME Cambiar por el mapping en ingles
                        if ($csv->hasColumn('Codigo') || $csv->hasColumn('Usuario') || $csv->hasColumn('Correo electronico')) {
                            if ($csv->hasColumn('Codigo')) {
                                $method = 'findByCode';
                                $key = 'Codigo';
                            } else if ($csv->hasColumn('Usuario')) {
                                $method = 'findByLabel';
                                $key = 'Usuario';
                            } else {
                                $method = 'findByEmail';
                                $key = 'Correo electronico';
                            }
                            foreach ($rows as $row) {
                                $user_info = $row[$key];
                                $user = $users->{$method}($user_info);
                                if (!empty($user)) {
                                    if (in_array($user->ident, $students_list)) {
                                        foreach ($tests_list as $test_key) {
                                            if ($csv->hasColumn($test_key)) {
                                                $test = $test_model->findByKey($evaluation->ident, $test_key);
                                                if (empty($test->formula)) {
                                                    $_calification = intval($row[$test_key]);
                                                    if (is_int($_calification)) {
                                                        // check for limits
                                                        // prune action
                                                        if ($_calification > $test->maximumnote) {
                                                            $_calification = $test->maximumnote;
                                                        } else if ($_calification < $test->minimumnote) {
                                                            $_calification = $test->minimumnote;
                                                        }
                                                        $note = $califications->findCalification($group->ident, $user->ident, $evaluation->ident, $test->ident);
                                                        if (empty($note)) {
                                                            $new = TRUE;
                                                            $note = $califications->createRow();
                                                        } else {
                                                            $new = FALSE;
                                                        }
                                                        if (!$new && $type == 'REPLACE') {
                                                            $note->user = $user->ident;
                                                            $note->group = $group->ident;
                                                            $note->evaluation = $evaluation->ident;
                                                            $note->test = $test->ident;
                                                            $note->calification = $_calification;
                                                            $note->save();
                                                            $count++;
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                            $session->messages->addMessage("Se han importado $count calificaciones");
                            unlink($filename);
                            $this->_redirect($this->view->lastPage());
                        } else {
                            $session->messages->addMessage("No se encuentra ningun identificador para los usuarios");
                        }
                    break;
                }
            }
        }
        
        history('subjects/' . $subject->url . '/groups/' . $group->url . '/califications/import');
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
            $breadcrumb['Calificaciones'] = $this->view->url(array('subject' => $subject->url, 'group' => $group->url), 'califications_manager');
        }
        breadcrumb($breadcrumb);
    }

    public function exportAction() {
        global $CONFIG;
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

        $users = Yeah_Adapter::getModel('users');
        $students = $group->findmodules_users_models_UsersViamodules_groups_models_Groups_Users($group->select()->where('type = ?', 'student'));

        $students_list = array();
        foreach ($students as $student) {
            $students_list[] = $student->ident;
        }

        $evaluations = Yeah_Adapter::getModel('evaluations');
        $evaluation = $group->getEvaluation();
        $evaluation_tests = $evaluation->findmodules_evaluations_models_Evaluations_Tests($evaluation->select()->order('order ASC'));

        $tests_list = array();
        foreach ($evaluation_tests as $evaluation_test) {
            $tests_list[] = $evaluation_test->key;
        }

        $test_model = Yeah_Adapter::getModel('evaluations', 'Evaluations_Tests');

        $califications = Yeah_Adapter::getModel('califications');

        $this->view->model = $califications;
        $this->view->subject = $subject;
        $this->view->group = $group;
        $this->view->evaluation = $evaluation;
        $this->view->tests = $evaluation_tests;
        $this->view->students = $students;

        if ($request->isPost()) {
            $columns = $request->getParam('columns');
            $extension = $request->getParam('extension');

            switch ($extension) {
                case 'csv':
                    $csv = '';

                    $headers = array();
                    foreach ($columns as $column) {
                        $headers[] = '"' . $this->view->utf2html($column) . '"';
                    }
                    $csv .= implode(', ', $headers) . '
';
                    foreach ($students as $student) {
                        $row = array();
                        $row[] = '"' . $student->code . '"';
                        foreach ($columns as $column) {
                            // FIXME Potencial lugar para SQL Inyection (Revisar)
                            $test = $test_model->findByKey($evaluation->ident, $column);
                            if (!empty($test)) {
                                $row[] = $califications->getCalification($group->ident, $student->ident, $evaluation->ident, $test);
                            } else {
                                $row[] = '"0"';
                            }
                        }
                        $csv .= implode(', ', $row) . '
';
                    }

                    header("HTTP/1.1 200 OK"); //mandamos código de OK
                    header("Status: 200 OK"); //sirve para corregir un bug de IE (fuente: php.net)
                    header('Content-Type: text/csv');
                    header('Content-Disposition: attachment; filename="calificaciones.csv"');
                    header('Content-Length: '. strlen($csv));
                    echo $csv;
                    die();
                    break;
            }
        }

        history('subjects/' . $subject->url . '/groups/' . $group->url . '/califications/export');
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
            $breadcrumb['Calificaciones'] = $this->view->url(array('subject' => $subject->url, 'group' => $group->url), 'califications_manager');
        }
        breadcrumb($breadcrumb);
    }
}
