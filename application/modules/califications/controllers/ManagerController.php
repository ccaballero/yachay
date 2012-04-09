<?php

class Califications_ManagerController extends Yachay_Action
{
    public function indexAction () {
        global $USER;

        $this->requirePermission('subjects', 'view');
        $request = $this->getRequest();

        $model_gestions = new Gestions();
        $gestion = $model_gestions->findByActive();

        $model_subjects = new Subjects();
        $url_subject = $request->getParam('subject');
        $subject = $model_subjects->findByUrl($gestion->ident, $url_subject);
        $this->requireExistence($subject, 'subject', 'subjects_subject_view', 'subjects_list');

        $model_groups = new Groups();
        $url_group = $request->getParam('group');
        $group = $model_groups->findByUrl($subject->ident, $url_group);
        $this->requireExistenceGroup($group, $subject);
        $this->requireTeacher($group);

        context('group', $group);

        $model_users = new Users();
        $students = $group->findUsersViaGroups_Users($group->select()->where('type = ?', 'student')->order('formalname ASC'));

        $model_evaluations = new Evaluations();
        $evaluation = $group->getEvaluation();
        $tests_evaluations = $evaluation->findEvaluations_Tests($evaluation->select()->order('order ASC'));

        $model_evaluation_tests = new Evaluations_Tests();

        $model_califications = new Califications();

        $this->view->model = $model_califications;
        $this->view->subject = $subject;
        $this->view->group = $group;
        $this->view->evaluation = $evaluation;
        $this->view->tests = $tests_evaluations;
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
                                if ($calification <> '') {
                                    $_calification = intval($calification);
                                    if (is_int($_calification)) {
                                        // check for limits
                                        $test = $model_evaluation_tests->findByIdent($_test);
                                        if (!empty($test) && empty($test->formula)) {
                                            // prune action
                                            if ($_calification > $test->maximumnote) {
                                                $_calification = $test->maximumnote;
                                            } else if ($_calification < $test->minimumnote) {
                                                $_calification = $test->minimumnote;
                                            }
                                            if ($group->ident == $_group && $evaluation->ident == $_evaluation) {
                                                $note = $model_califications->findCalification($_group, $_user, $_evaluation, $_test);
                                                if (empty($note)) {
                                                    $note = $model_califications->createRow();
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
                                } else {
                                    $note = $model_califications->findCalification($_group, $_user, $_evaluation, $_test);
                                    if (!empty($note)) {
                                        $note->delete();
                                    }
                                }
                            }
                        }
                    }
                }
                $session->messages->addMessage('Las calificaciones han sido almacenadas correctamente');
            } else if (!empty($clean)) {
                foreach ($students as $student) {
                    foreach ($tests_evaluations as $test) {
                        $note = $model_califications->findCalification($group->ident, $student->ident, $evaluation->ident, $test->ident);
                        if (!empty($note)) {
                            $note->delete();
                        }
                    }
                }
                $session->messages->addMessage('Las calificaciones han sido limpiadas');
            } else if (!empty($change)) {
                $evaluation_selected = $request->getParam('evaluation');
                $evaluation_selected = intval($evaluation_selected);
                if (!empty($evaluation_selected)) {
                    // clean
                    foreach ($students as $student) {
                        foreach ($tests_evaluations as $test) {
                            $note = $model_califications->findCalification($group->ident, $student->ident, $evaluation->ident, $test->ident);
                            if (!empty($note)) {
                                $note->delete();
                            }
                        }
                    }
                    // change
                    $group->evaluation = $evaluation_selected;
                    if ($group->isValid()) {
                        $group->save();
                        $session->messages->addMessage('El criterio de evaluation ha sido cambiado');
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
        if ($this->acl('subjects', array('new', 'import', 'export', 'lock', 'delete'))) {
            $breadcrumb['Materias'] = $this->view->url(array(), 'subjects_manager');
        } else if ($this->acl('subjects', 'list')) {
            $breadcrumb['Materias'] = $this->view->url(array(), 'subjects_list');
        }
        if ($this->acl('subjects', 'view')) {
            $breadcrumb[$subject->label] = $this->view->url(array('subject' => $subject->url), 'subjects_subject_view');
            if ($subject->amModerator()) {
                $breadcrumb['Grupos'] = $this->view->url(array('subject' => $subject->url), 'groups_manager');
            }
            $breadcrumb['Grupo ' . $group->label] = $this->view->url(array('subject' => $subject->url, 'group' => $group->url), 'groups_group_view');
        }
        breadcrumb($breadcrumb);
    }

    public function importAction() {
        $this->requirePermission('subjects', 'view');
        $request = $this->getRequest();

        $model_gestions = new Gestions();
        $gestion = $model_gestions->findByActive();

        $model_subjects = new Subjects();
        $url_subject = $request->getParam('subject');
        $subject = $model_subjects->findByUrl($gestion->ident, $url_subject);
        $this->requireExistence($subject, 'subject', 'subjects_subject_view', 'subjects_list');

        $model_groups = new Groups();
        $url_group = $request->getParam('group');
        $group = $model_groups->findByUrl($subject->ident, $url_group);
        $this->requireExistenceGroup($group, $subject);
        $this->requireTeacher($group);

        context('group', $group);

        $model_users = new Users();
        $students = $group->findUsersViaGroups_Users($group->select()->where('type = ?', 'student'));

        $students_list = array();
        foreach ($students as $student) {
            $students_list[] = $student->ident;
        }

        $model_evaluations = new Evaluations();
        $evaluation = $group->getEvaluation();
        $tests_evaluations = $evaluation->findEvaluations_Tests($evaluation->select()->order('order ASC'));

        $tests_list = array();
        foreach ($tests_evaluations as $evaluation_test) {
            $tests_list[] = $evaluation_test->key;
        }

        $model_evaluation_tests = new Evaluations_Tests();
        $model_califications = new Califications();

        $options = array();
        $options['REPLACE'] = 'Reemplazar las notas existentes.';
        $options['IGNORE'] = 'Ignorar las notas ya establecidas';

        $this->view->step = 1;
        $this->view->options = $options;
        $this->view->model = $model_califications;
        $this->view->subject = $subject;
        $this->view->group = $group;
        $this->view->evaluation = $evaluation;
        $this->view->tests = $tests_evaluations;
        $this->view->students = $students;

        if ($request->isPost()) {
            $session = new Zend_Session_Namespace();

            $selections = $request->getParam('student');
            if (empty($selections)) {
                $upload = new Zend_File_Transfer_Adapter_Http();
                $upload->setDestination(APPLICATION_PATH . '/../public/media/upload');
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

                            if ($csv->hasColumn($_headers['CODIGO'])) {
                                $results = array();

                                foreach ($rows as $row) {
                                    $result = array();

                                    $result['CODIGO'] = trim($row[$_headers['CODIGO']]);
                                    $user = $model_users->findByCode($result['CODIGO']);

                                    $result['TYPE'] = $type;

                                    $result['MESS'] = '';
                                    $result['RES'] = '[OK]';

                                    if (!empty($user)) {
                                        $result['USER_OBJ'] = $user;
                                        if (!in_array($user->ident, $students_list)) {
                                            $result['MESS'] = 'El usuario no se encuentra asignado en el grupo';
                                            $result['RES'] = '[FALLO]';
                                        } else {
                                            foreach ($tests_list as $test_key) {
                                                if ($csv->hasColumn($test_key)) {
                                                    $test = $model_evaluation_tests->findByKey($evaluation->ident, $test_key);
                                                    if (empty($test->formula)) {
                                                        $_calification = intval($row[$test_key]);
                                                        if (is_int($_calification)) {
                                                            if ($_calification > $test->maximumnote) {
                                                                $_calification = $test->maximumnote;
                                                            } else if ($_calification < $test->minimumnote) {
                                                                $_calification = $test->minimumnote;
                                                            }
                                                            $note = $model_califications->findCalification($group->ident, $user->ident, $evaluation->ident, $test->ident);

                                                            $result['CALIF'][$test_key] = $_calification;
                                                            $result['EXIST'][$test_key] = ($note <> NULL);
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    } else {
                                        $result['MESS'] = 'El usuario no existe';
                                        $result['RES'] = '[FALLO]';
                                    }

                                    $results[] = $result;
                                }

                                $this->view->results = $results;
                                $this->view->type = $type;

                                $session->import_califications = $results;
                            } else {
                                $session->messages->addMessage('La columna CODIGO no fue encontrada');
                                $this->_redirect($this->view->currentPage());
                            }
                        break;
                    }
                    unlink($filename);
                } else {
                    $session->messages->addMessage('Debe escoger un archivo valido para poder interpretarlo adecuadamente');
                }
            } else {
                if (isset($session->import_califications)) {
                    $count_new = 0;
                    $count_edit = 0;
                    foreach ($session->import_califications as $result) {
                        if (in_array($result['CODIGO'], $selections)) {
                            if (isset($result['USER_OBJ'])) {
                                foreach ($tests_list as $test_key) {
                                    $test = $model_evaluation_tests->findByKey($evaluation->ident, $test_key);

                                    if (isset($result['CALIF'][$test_key])) {
                                        $note = $model_califications->findCalification($group->ident, $result['USER_OBJ']->ident, $evaluation->ident, $test->ident);

                                        if ($note == NULL) {
                                            $new = TRUE;
                                            $note = $model_califications->createRow();
                                        } else {
                                            $new = FALSE;
                                        }

                                        if ($note <> NULL) {
                                            if ($result['TYPE'] == 'REPLACE') {
                                                $replace = TRUE;
                                            } else {
                                                $replace = FALSE;
                                            }
                                        } else {
                                            $replace = FALSE;
                                        }

                                        if ($new || $replace) {
                                            $note->user = $result['USER_OBJ']->ident;
                                            $note->group = $group->ident;
                                            $note->evaluation = $evaluation->ident;
                                            $note->test = $test->ident;
                                            $note->calification = $result['CALIF'][$test_key];
                                            $note->save();

                                            if ($new) {
                                                $count_new++;
                                            }
                                            if ($replace) {
                                                $count_edit++;
                                            }
                                        }
                                    }
                                }

                            }
                        }
                    }
                    $session->messages->addMessage("Se han creado importado $count_new calificaciones nuevas y se han editado $count_edit calificaciones");
                    $this->_redirect($this->view->lastPage());
                }
                unset($session->import_califications);
            }
        }

        history('subjects/' . $subject->url . '/groups/' . $group->url . '/califications/import');
        $breadcrumb = array();
        if ($this->acl('subjects', array('new', 'import', 'export', 'lock', 'delete'))) {
            $breadcrumb['Materias'] = $this->view->url(array(), 'subjects_manager');
        } else if ($this->acl('subjects', 'list')) {
            $breadcrumb['Materias'] = $this->view->url(array(), 'subjects_list');
        }
        if ($this->acl('subjects', 'view')) {
            $breadcrumb[$subject->label] = $this->view->url(array('subject' => $subject->url), 'subjects_subject_view');
            if ($subject->amModerator()) {
                $breadcrumb['Grupos'] = $this->view->url(array('subject' => $subject->url), 'groups_manager');
            }
            $breadcrumb['Grupo ' . $group->label] = $this->view->url(array('subject' => $subject->url, 'group' => $group->url), 'groups_group_view');
            $breadcrumb['Calificaciones'] = $this->view->url(array('subject' => $subject->url, 'group' => $group->url), 'califications_manager');
        }
        breadcrumb($breadcrumb);
    }

    public function exportAction() {
        global $USER;

        $this->requirePermission('subjects', 'view');
        $request = $this->getRequest();

        $model_gestions = new Gestions();
        $gestion = $model_gestions->findByActive();

        $model_subjects = new Subjects();
        $url_subject = $request->getParam('subject');
        $subject = $model_subjects->findByUrl($gestion->ident, $url_subject);
        $this->requireExistence($subject, 'subject', 'subjects_subject_view', 'subjects_list');

        $model_groups = new Groups();
        $url_group = $request->getParam('group');
        $group = $model_groups->findByUrl($subject->ident, $url_group);
        $this->requireExistenceGroup($group, $subject);
        $this->requireTeacher($group);

        context('group', $group);

        $model_users = new Users();
        $students = $group->findUsersViaGroups_Users($group->select()->where('type = ?', 'student'));

        $students_list = array();
        foreach ($students as $student) {
            $students_list[] = $student->ident;
        }

        $model_evaluations = new Evaluations();
        $evaluation = $group->getEvaluation();
        $tests_evaluations = $evaluation->findEvaluations_Tests($evaluation->select()->order('order ASC'));

        $tests_list = array();
        foreach ($tests_evaluations as $evaluation_test) {
            $tests_list[] = $evaluation_test->key;
        }

        $model_evaluation_tests = new Evaluations_Tests();
        $model_califications = new Califications();

        $this->view->model = $model_califications;
        $this->view->subject = $subject;
        $this->view->group = $group;
        $this->view->evaluation = $evaluation;
        $this->view->tests = $tests_evaluations;
        $this->view->students = $students;

        if ($request->isPost()) {
            $columns = $request->getParam('columns');
            $extension = $request->getParam('extension');

            switch ($extension) {
                case 'csv':
                    $csv = '';

                    $headers = array('"Codigo"', '"Nombre Completo"');
                    foreach ($columns as $column) {
                        $headers[] = '"' . $column . '"';
                    }
                    $csv .= implode(',', $headers) . '
';
                    foreach ($students as $student) {
                        $row = array();
                        $row[] = '"' . $student->code . '"';
                        $row[] = '"' . $student->formalname . '"';
                        foreach ($columns as $column) {
                            $test = $model_evaluation_tests->findByKey($evaluation->ident, $column);
                            if (!empty($test)) {
                                $calification = $model_califications->getCalification($group->ident, $student->ident, $evaluation->ident, $test);
                                if ($test->hasValues()) {
                                    $test_values = $test->findEvaluations_Tests_Values();
                                    $label = '';
                                    foreach ($test_values as $test_value) {
                                        if ($test_value->value === $calification) {
                                            $label = $test_value->label;
                                        }
                                    }
                                    $row[] = '"' . $label . '"';
                                } else {
                                    $row[] = '"' . $calification . '"';
                                }
                            } else {
                                $row[] = '""';
                            }
                        }
                        $csv .= implode(',', $row) . '
';
                    }

                    header("HTTP/1.1 200 OK"); //mandamos código de OK
                    header("Status: 200 OK"); //sirve para corregir un bug de IE (fuente: php.net)
                    header('Content-Type: text/csv');
                    header('Content-Disposition: attachment; filename="Calificaciones ('. $subject->label . ' - Grupo ' . $group->label . ').csv"');
                    header('Content-Length: '. strlen($csv));
                    echo $csv;
                    die();
                    break;
            }
        }

        history('subjects/' . $subject->url . '/groups/' . $group->url . '/califications/export');
        $breadcrumb = array();
        if ($this->acl('subjects', array('new', 'import', 'export', 'lock', 'delete'))) {
            $breadcrumb['Materias'] = $this->view->url(array(), 'subjects_manager');
        } else if ($this->acl('subjects', 'list')) {
            $breadcrumb['Materias'] = $this->view->url(array(), 'subjects_list');
        }
        if ($this->acl('subjects', 'view')) {
            $breadcrumb[$subject->label] = $this->view->url(array('subject' => $subject->url), 'subjects_subject_view');
            if ($subject->amModerator()) {
                $breadcrumb['Grupos'] = $this->view->url(array('subject' => $subject->url), 'groups_manager');
            }
            $breadcrumb['Grupo ' . $group->label] = $this->view->url(array('subject' => $subject->url, 'group' => $group->url), 'groups_group_view');
            $breadcrumb['Calificaciones'] = $this->view->url(array('subject' => $subject->url, 'group' => $group->url), 'califications_manager');
        }
        breadcrumb($breadcrumb);
    }
}
