<?php

class Subjects_ManagerController extends Yeah_Action
{
    public function indexAction() {
        $this->requirePermission('subjects', 'list');
        $this->requirePermission('subjects', array('new', 'import', 'export', 'lock', 'delete'));

        $request = $this->getRequest();
        if ($request->isPost()) {
            if (Yeah_Acl::hasPermission('subjects', 'lock')) {
                $lock = $request->getParam('lock');
                $unlock = $request->getParam('unlock');
                if (!empty($lock)) {
                    $this->_forward('lock');
                } else if (!empty($unlock)) {
                    $this->_forward('unlock');
                }
            }
            if (Yeah_Acl::hasPermission('subjects', 'delete')) {
                $delete = $request->getParam('delete');
                if (!empty($delete)) {
                    $this->_forward('delete');
                }
            }
        }

        $subjects = Yeah_Adapter::getModel('subjects');
        $gestions = Yeah_Adapter::getModel('gestions');
        $gestion = $gestions->findByActive();

        $this->view->model = $subjects;
        $this->view->gestion = $gestion;

        if (!empty($gestion)) {
            $this->view->subjects = $subjects->selectAll($gestion->ident);
        } else {
            $this->view->subjects = array();
        }

        history('subjects/manager');
        breadcrumb();
    }

    public function newAction() {
        global $USER;

        $this->requirePermission('subjects', 'new');

        $areas = Yeah_Adapter::getModel('areas');
        $this->view->areas = $areas->selectAll();
        $this->view->checks = array();

        $this->view->subject = new modules_subjects_models_Subjects_Empty;

        $request = $this->getRequest();
        if ($request->isPost()) {
            $session = new Zend_Session_Namespace();

            $subjects = Yeah_Adapter::getModel('subjects');
            $subject = $subjects->createRow();
            $subject->label = $request->getParam('label');
            $subject->url = convert($subject->label);
            $subject->moderator = $request->getParam('moderator');
            $subject->code = $request->getParam('code');
            $subject->visibility = $request->getParam('visibility');
            $subject->description = $request->getParam('description');

            $checks = $request->getParam('areas');
            if (empty($checks)) {
                $checks = array();
            }

            $gestions = Yeah_Adapter::getModel('gestions');
            $gestion = $gestions->findByActive();
            $subject->gestion = $gestion->ident;

            if ($subject->isValid()) {
                $subject->author = $USER->ident;
                $subject->tsregister = time();
                $subject->save();

                $assignement = Yeah_Adapter::getModel('areas', 'Areas_Subjects');
                foreach ($checks as $area) {
                    $assign = $assignement->createRow();
                    $assign->area = $area;
                    $assign->subject = $subject->ident;
                    $assign->save();
                }

                $session->messages->addMessage("La materia {$subject->label} se ha creado correctamente");
                $session->url = $subject->url;
                $this->_redirect($request->getParam('return'));
            } else {
                foreach ($subject->getMessages() as $message) {
                    $session->messages->addMessage($message);
                }
            }

            $this->view->subject = $subject;
            $this->view->checks = $checks;
        }

        history('subjects/new');
        $breadcrumb = array();
        $breadcrumb['Materias'] = $this->view->url(array(), 'subjects_manager');
        breadcrumb($breadcrumb);
    }

    public function lockAction() {
        $this->requirePermission('subjects', 'lock');
        $request = $this->getRequest();

        if ($request->isPost()) {
            $subjects = Yeah_Adapter::getModel('subjects');
            $check = $request->getParam("check");

            foreach ($check as $value) {
                $subject = $subjects->findByIdent($value);
                $subject->status = 'inactive';
                $subject->save();
            }
            $count = count($check);

            $session = new Zend_Session_Namespace();
            $session->messages->addMessage("Se han bloqueado $count materias");
        }
        $this->_redirect($this->view->currentPage());
    }

    public function unlockAction() {
        $this->requirePermission('subjects', 'lock');
        $request = $this->getRequest();

        if ($request->isPost()) {
            $subjects = Yeah_Adapter::getModel('subjects');
            $check = $request->getParam("check");

            foreach ($check as $value) {
                $subject = $subjects->findByIdent($value);
                $subject->status = 'active';
                $subject->save();
            }
            $count = count($check);

            $session = new Zend_Session_Namespace();
            $session->messages->addMessage("Se han bloqueado $count materias");
        }
        $this->_redirect($this->view->currentPage());
    }

    public function deleteAction() {
        $this->requirePermission('subjects', 'delete');
        $request = $this->getRequest();
        if ($request->isPost()) {
            $subjects = Yeah_Adapter::getModel('subjects');
            $check = $request->getParam("check");

            $count = 0;
            foreach ($check as $value) {
                $subject = $subjects->findByIdent($value);
                if ($subject->isEmpty()) {
                    $subject->delete();
                    $count++;
                }
            }

            $session = new Zend_Session_Namespace();
            $session->messages->addMessage("Se han eliminado $count materias");
        }
        $this->_redirect($this->view->currentPage());
    }

    public function importAction() {
        global $CONFIG;
        global $USER;

        $this->requirePermission('subjects', 'import');
        $this->requirePermission('subjects', array('new', 'edit'));

        $options = array();
        if (Yeah_Acl::hasPermission('subjects', 'new')) {
            $options['CREATE_NOEDIT'] = 'Solo crear materias nuevas, e ignorar las restantes.';
        }
        if (Yeah_Acl::hasPermission('subjects', 'edit')) {
            $options['NOCREATE_EDIT'] = 'Solo actualizar la información de las existentes, no registrar nuevas.';
        }
        if (Yeah_Acl::hasPermission('subjects', 'new') && Yeah_Acl::hasPermission('subjects', 'edit')) {
            $options['CREATE_EDIT'] = 'Crear materias, y actualizar la información de las existentes.';
        }
        $this->view->options = $options;
        $this->view->step = 1;

        $request = $this->getRequest();
        if ($request->isPost()) {
            $session = new Zend_Session_Namespace();

            $subjects = Yeah_Adapter::getModel('subjects');
            $users = Yeah_Adapter::getModel('users');
            $me = $users->findByIdent($USER->ident);

            $gestions = Yeah_Adapter::getModel('gestions');
            $gestion = $gestions->findByActive();

            $selections = $request->getParam('subjects');
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

                            if ($csv->hasColumn($_headers['CODIGO']) && $csv->hasColumn($_headers['MATERIA'])) {
                                $results = array();

                                foreach ($rows as $row) {
                                    $result = array();

                                    $result['CODIGO'] = trim($row[$_headers['CODIGO']]);
                                    $subject = $subjects->findByCode($gestion->ident, $result['CODIGO']);
                                    if (empty($subject)) {
                                        $result['CODIGO_NUE'] = TRUE;
                                    } else {
                                        $result['CODIGO_NUE'] = FALSE;
                                        $result['MATERIA_OBJ'] = $subject;
                                    }

                                    $result['MATERIA'] = $row[$_headers['MATERIA']];
                                    $result['VISIBILIDAD'] = isset($_headers['VISIBILIDAD']) ? $row[$_headers['VISIBILIDAD']] : 'private';
                                    $result['DESCRIPCION'] = isset($_headers['DESCRIPCION']) ? $row[$_headers['DESCRIPCION']] : '';

                                    $result['MODERADOR'] = isset($_headers['MODERADOR']) ? $row[$_headers['MODERADOR']] : $USER->label;
                                    $moderator = $users->findByLabel($result['MODERADOR']);
                                    if (!empty($moderator)) {
                                        if ($moderator->hasPermission('subjects', 'moderate')) {
                                            $result['MODERADOR_OBJ'] = $moderator;
                                        } else {
                                            $result['MODERADOR_MES'] = 'El usuario no tiene permisos de moderador';
                                        }
                                    } else {
                                        $result['MODERADOR_MES'] = 'El usuario no existe';
                                    }

                                    $results[] = $result;
                                }

                                $this->view->headers = array('CODIGO', 'MATERIA', 'MODERADOR', 'VISIBILIDAD', 'DESCRIPCION');
                                $this->view->results = $results;
                                $this->view->type = $type;

                                $session->import_subjects = $results;
                            } else {
                                if (!$csv->hasColumn($_headers['CODIGO'])) {
                                    $session->messages->addMessage('La columna CODIGO no fue encontrada');
                                    $this->_redirect($this->view->currentPage());

                                }
                                if (!$csv->hasColumn($_headers['MATERIA'])) {
                                    $session->messages->addMessage('La columna MATERIA no fue encontrada');
                                    $this->_redirect($this->view->currentPage());
                                }
                            }
                        break;
                    }
                    unlink($filename);
                }
            } else {
                if (isset($session->import_subjects)) {
                    $count_new = 0;
                    $count_edit = 0;
                    foreach ($session->import_subjects as $result) {
                        if (in_array($result['CODIGO'], $selections)) {
                            if ($result['CODIGO_NUE'] && Yeah_Acl::hasPermission('subjects', 'new')) {
                                $subject = $subjects->createRow();
                                $subject->gestion = $gestion->ident;
                                $subject->code = $result['CODIGO'];
                                $subject->status = 'inactive';
                                $subject->author = $USER->ident;
                                $subject->tsregister = time();
                            }
                            if (!$result['CODIGO_NUE'] && Yeah_Acl::hasPermission('subjects', 'edit')) {
                                $subject = $subjects->findByCode($gestion->ident, $result['CODIGO']);
                            }
                            if (isset($subject)) {
                                $subject->label = $result['MATERIA'];
                                $subject->url = convert($subject->label);
                                if (isset($result['MODERADOR_OBJ'])) {
                                    $subject->moderator = $result['MODERADOR_OBJ']->ident;
                                }
                                $subject->visibility = $result['VISIBILIDAD'];
                                $subject->description = $result['DESCRIPCION'];

                                if ($subject->isValid()) {
                                    $subject->save();
                                    if ($result['CODIGO_NUE']) {
                                        $count_new++;
                                    } else {
                                        $count_edit++;
                                    }
                                }
                            }
                        }
                    }
                    $session->messages->addMessage("Se han creado $count_new materias nuevas y se han editado $count_edit materias");
                    $this->_redirect($this->view->lastPage());
                }
                unset($session->import_subjects);
            }
        }

        history('subjects/import');
        $breadcrumb = array();
        $breadcrumb['Materias'] = $this->view->url(array(), 'subjects_manager');
        breadcrumb($breadcrumb);
    }

    public function exportAction() {
        $this->requirePermission('subjects', 'export');
        $this->requirePermission('subjects', array('list'));
        $this->requirePermission('subjects', array('view'));

        $request = $this->getRequest();
        $gestions = Yeah_Adapter::getModel('gestions');
        $gestion = $gestions->findByActive();

        $model = Yeah_Adapter::getModel('subjects');
        $subjects = $model->selectAll($gestion->ident);
        $this->view->model = $model;

        if ($request->isPost()) {
            $columns = $request->getParam('columns');
            $extension = $request->getParam('extension');

            switch ($extension) {
                case 'csv':
                    $csv = '';

                    $headers = array();
                    foreach ($columns as $column) {
                        $headers[] = '"' . $model->_mapping[$column] . '"';
                    }
                    $csv .= implode(', ', $headers) . '
';
                    foreach ($subjects as $subject) {
                        $row = array();
                        foreach ($columns as $column) {
                            if ($column == 'moderator') {
                                $row[] = '"' . $subject->getModerator()->label . '"';
                            } else {
                                $row[] = '"' . $subject->$column . '"';
                            }
                        }
                        $csv .= implode(', ', $row) . '
';
                    }

                    header("HTTP/1.1 200 OK"); //mandamos código de OK
                    header("Status: 200 OK"); //sirve para corregir un bug de IE (fuente: php.net)
                    header('Content-Type: text/csv');
                    header('Content-Disposition: attachment; filename="materias.csv"');
                    header('Content-Length: '. strlen($csv));
                    echo $csv;
                    die();
                    break;
            }
        }

        history('subjects/export');
        $breadcrumb = array();
        $breadcrumb['Materias'] = $this->view->url(array(), 'subjects_manager');
        breadcrumb($breadcrumb);
    }
}
