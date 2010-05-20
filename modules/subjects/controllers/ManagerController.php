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
        $this->view->subjects = $subjects->selectAll($gestion->ident);

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
        if (Yeah_Acl::hasPermission('users', 'new') && Yeah_Acl::hasPermission('users', 'edit')) {
            $options['CREATE_NOEDIT'] = 'Solo crear materias nuevas, e ignorar las restantes.';
            $options['NOCREATE_EDIT'] = 'Solo actualizar la informacion de las existentes, no registrar nuevas.';
            $options['CREATE_EDIT'] = 'Crear materias, y actualizar la informacion de las existentes.';
        }
        $this->view->options = $options;

        $request = $this->getRequest();
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
                $model = Yeah_Adapter::getModel('subjects');
                $type = $request->getParam('type');

                $users = Yeah_Adapter::getModel('users');

                $gestions = Yeah_Adapter::getModel('gestions');
                $gestion = $gestions->findByActive();

                switch ($extension) {
                    case 'csv':
                        $csv = new File_CSV_DataSource;
                        $csv->load($filename); //se carga el archivo
                        $rows = $csv->connect(); //te devuelve el contenido del archivo
                        // FIXME
                        if ($csv->hasColumn('Codigo') && $csv->hasColumn('Materia')) {
                            foreach ($rows as $row) {
                                $code = $row['Codigo'];
                                $mode = 'EDIT';
                                $subject = $model->findByCode($gestion->ident, $code);
                                if (empty($subject)) {
                                    $mode = 'CREATE';
                                    $subject = $model->createRow();
                                    $subject->gestion = $gestion->ident;
                                    $subject->visibility = 'public';
                                }
                                if (($type == 'CREATE_NOEDIT' && $mode == 'EDIT') || ($type == 'NOCREATE_EDIT' && $mode == 'CREATE')) {
                                    
                                } else {
                                    $subject->code = $code;
                                    if (!empty($row['Moderador'])) {
                                        $obj_moderator = $users->findByLabel($row['Moderador']);
                                        if (!empty($obj_moderator)) {
                                            if ($obj_moderator->hasPermission('subjects', 'moderate')) {
                                                $subject->moderator = $obj_moderator->ident;
                                            }
                                        }
                                    } else {
                                        $me = $users->findByIdent($USER->ident);
                                        if ($me->hasPermission('subjects', 'moderate')) {
                                            $subject->moderator = $me->ident;
                                        }
                                    }
                                    if (!empty($row['Materia'])) {
                                        $subject->label = utf8_decode($row['Materia']);
                                    }
                                    if (!empty($row['Visibilidad'])) {
                                        $subject->visibility = $row['Visibilidad'];
                                    }
                                    if (!empty($row['Descripcion'])) {
                                        $subject->description = $row['Descripcion'];
                                    }

                                    if ($subject->isValid()) {
                                        if ($mode == 'EDIT') {
                                            if (Yeah_Acl::hasPermission('subjects', 'edit')) {
                                                $subject->author = $USER->ident;
                                                $subject->save();
                                                $count++;
                                            }
                                        } else if ($mode == 'CREATE') {
                                            if (Yeah_Acl::hasPermission('subjects', 'new')) {
                                                $subject->author = $USER->ident;
                                                $subject->tsregister = time();
                                                $subject->save();
                                                $count++;
                                            }
                                        }
                                    }
                                }
                            }
                            $session->messages->addMessage("Se han insertado $count materias");
                            unlink($filename);
                        } else {
                            $session->messages->addMessage("Una de los columnas requeridas no se encuentran");
                        }
                        break;
                }
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
                        $headers[] = '"' . $this->view->utf2html($model->_mapping[$column]) . '"';
                    }
                    $csv .= implode(', ', $headers) . '
';
                    foreach ($subjects as $subject) {
                        $row = array();
                        foreach ($columns as $column) {
                            if ($column == 'moderator') {
                                $row[] = '"' . $this->view->utf2html($subject->getModerator()->label) . '"';
                            } else {
                                $row[] = '"' . $this->view->utf2html($subject->$column) . '"';
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
