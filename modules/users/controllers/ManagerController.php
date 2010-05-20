<?php

class Users_ManagerController extends Yeah_Action
{
    public function indexAction() {
        $this->requirePermission('users', 'list');
        $this->requirePermission('users', array('new', 'import', 'export', 'lock', 'delete'));

        $request = $this->getRequest();
        if ($request->isPost()) {
            if (Yeah_Acl::hasPermission('users', 'lock')) {
                $lock = $request->getParam('lock');
                $unlock = $request->getParam('unlock');
                if (!empty($lock)) {
                    $this->_forward('lock');
                } else if (!empty($unlock)) {
                    $this->_forward('unlock');
                }
            }
            if (Yeah_Acl::hasPermission('users', 'delete')) {
                $delete = $request->getParam('delete');
                if (!empty($delete)) {
                    $this->_forward('delete');
                }
            }
        }

        $users = Yeah_Adapter::getModel('users');
        $page = $request->getParam('page', 1);

        $paginator = Zend_Paginator::factory($users->selectAll());
        $paginator->setItemCountPerPage(25);
        $paginator->setCurrentPageNumber($page);
        $paginator->setPageRange(25);

        $this->view->model = $users;
        $this->view->users = $paginator;

        history('users/manager');
        breadcrumb();
    }

    public function newAction() {
        $this->requirePermission('users', 'new');

        $this->view->user = new modules_users_models_Users_Empty;

        $request = $this->getRequest();
        if ($request->isPost()) {
            $session = new Zend_Session_Namespace();

            $users = Yeah_Adapter::getModel('users');

            $user = $users->createRow();
            $user->label = $request->getParam('label');
            $user->email = $request->getParam('email');
            $user->role = $request->getParam('role');
            $user->code = $request->getParam('code');
            $user->surname = $request->getParam('surname');
            $user->name = $request->getParam('name');
            $user->birthdate = $request->getParam('birthdate-year') . '-' . $request->getParam('birthdate-month') . '-' . $request->getParam('birthdate-day');
            $user->career = $request->getParam('career');
            $user->phone = $request->getParam('phone');
            $user->cellphone = $request->getParam('cellphone');

            if ($user->isValid()) {
                global $CONFIG;
                // role validation,, critical point
                global $USER;
                $model = Yeah_Adapter::getModel('roles');
                $roles = $model->selectByIncludes($USER->role);
                $valid_role = false;
                foreach ($roles as $role) {
                    if ($role->ident == $user->role) {
                        $valid_role |= true;
                    }
                }

                if ($valid_role) {
                    $password = generatecode();

                    $user->password = md5($password);
                    $user->tsregister = time();
                    $user->save();

                    // email notification
                    $view = new Zend_View();
                    $view->addHelperPath($CONFIG->dirroot . 'libs/Yeah/Helpers', 'Yeah_Helpers');
                    $view->setScriptPath($CONFIG->dirroot . 'modules/users/views/scripts/user/');

                    $view->user       = $user;
                    $view->servername = $CONFIG->wwwroot;
                    $view->author     = $USER->label;
                    $view->password   = $password;

                    $content = $view->render('mail.php');
                    $mail = new Zend_Mail();
                    $mail->setBodyHtml($content)
                         ->addTo($user->email, $user->getFullName())
                         ->setSubject(utf8_decode('Notificación de registro de usuario'))
                         ->send();

                    $session->messages->addMessage("El usuario {$user->label} se ha creado correctamente");
                    $session->url = $user->url;
                    $this->_redirect($request->getParam('return'));
                } else {
                    $session->messages->addMessage("No tiene permisos para establecer ese rol en ese usuario");
                }
            } else {
                foreach ($user->getMessages() as $message) {
                    $session->messages->addMessage($message);
                }
            }

            $this->view->user = $user;
        }

        history('users/new');
        $breadcrumb = array();
        $breadcrumb['Usuarios'] = $this->view->url(array(), 'users_manager');
        breadcrumb($breadcrumb);
    }

    public function lockAction() {
        global $USER;

        $this->requirePermission('users', 'lock');
        $request = $this->getRequest();

        if ($request->isPost()) {
            $users = Yeah_Adapter::getModel('users');
            $check = $request->getParam("check");

            $model = Yeah_Adapter::getModel('roles');
            $roles = $model->selectByIncludes($USER->role);

            foreach ($check as $value) {
                $user = $users->findByIdent($value);

                $valid_role = false;
                foreach ($roles as $role) {
                    if ($role->ident == $user->role) {
                        $valid_role |= true;
                    }
                }

                if ($valid_role) {
                    $user->status = 'inactive';
                    $user->save();
                }
            }
            $count = count($check);

            $session = new Zend_Session_Namespace();
            $session->messages->addMessage("Se han bloqueado $count usuarios");
        }

        $this->_redirect($this->view->currentPage());
    }

    public function unlockAction() {
        global $USER;

        $this->requirePermission('users', 'lock');
        $request = $this->getRequest();

        if ($request->isPost()) {
            $users = Yeah_Adapter::getModel('users');
            $check = $request->getParam("check");

            $model = Yeah_Adapter::getModel('roles');
            $roles = $model->selectByIncludes($USER->role);

            foreach ($check as $value) {
                $user = $users->findByIdent($value);

                $valid_role = false;
                foreach ($roles as $role) {
                    if ($role->ident == $user->role) {
                        $valid_role |= true;
                    }
                }

                if ($valid_role) {
                    $user->status = 'active';
                    $user->save();
                }
            }
            $count = count($check);

            $session = new Zend_Session_Namespace();
            $session->messages->addMessage("Se han desbloqueado $count usuarios");
        }

        $this->_redirect($this->view->currentPage());
    }

    public function deleteAction() {
        global $USER;

        $this->requirePermission('users', 'delete');
        $request = $this->getRequest();
        if ($request->isPost()) {
            $users = Yeah_Adapter::getModel('users');
            $check = $request->getParam("check");

            $model = Yeah_Adapter::getModel('roles');
            $roles = $model->selectByIncludes($USER->role);

            foreach ($check as $value) {
                $user = $users->findByIdent($value);

                $valid_role = false;
                foreach ($roles as $role) {
                    if ($role->ident == $user->role) {
                        $valid_role |= true;
                    }
                }

                if ($valid_role) {
                    $user->delete();
                }
            }
            $count = count($check);

            $session = new Zend_Session_Namespace();
            $session->messages->addMessage("Se han eliminado $count usuarios");
        }

        $this->_redirect($this->view->currentPage());
    }

    public function importAction() {
        global $CONFIG;
        global $USER;

        $this->requirePermission('users', 'import');
        $this->requirePermission('users', array('new', 'edit'));

        $options = array();
        if (Yeah_Acl::hasPermission('users', 'new') && Yeah_Acl::hasPermission('users', 'edit')) {
            $options['CREATE_NOEDIT'] = 'Solo crear usuarios nuevos, e ignorar los restantes.';
            $options['NOCREATE_EDIT'] = 'Solo actualizar la informacion de los existentes, no registrar nuevos.';
            $options['CREATE_EDIT'] = 'Crear usuarios, y actualizar la informacion de los existentes.';
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
                $model = Yeah_Adapter::getModel('users');
                $roles = Yeah_Adapter::getModel('roles');
                $type = $request->getParam('type');

                switch ($extension) {
                    case 'csv':
                        $csv = new File_CSV_DataSource;
                        $csv->load($filename); //se carga el archivo
                        $rows = $csv->connect(); //te devuelve el contenido del archivo
                        // FIXME
                        if ($csv->hasColumn('Codigo') && $csv->hasColumn('Rol') && $csv->hasColumn('Correo electronico')) {
                            foreach ($rows as $row) {
                                $code = $row['Codigo'];
                                $mode = 'EDIT';
                                $user = $model->findByCode($code);
                                if (empty($user)) {
                                    $mode = 'CREATE';
                                    $user = $model->createRow();
                                }
                                if (($type == 'CREATE_NOEDIT' && $mode == 'EDIT') || ($type == 'NOCREATE_EDIT' && $mode == 'CREATE')) {
                                    
                                } else {
                                    $user->code = $code;
                                    $obj_role = $roles->findByLabel(strtolower($row['Rol']));
                                    if (!empty($obj_role)) {
                                        $availables = $roles->selectByIncludes($USER->role);
                                        $valid_role = false;
                                        foreach ($availables as $available) {
                                            if ($available->ident == $obj_role->ident) {
                                                $valid_role |= true;
                                            }
                                        }
                                        if ($valid_role) {
                                            $user->role = $obj_role->ident;
                                        }
                                    }
                                    $user->email = $row['Correo electronico'];
                                    if (!empty($row['Usuario'])) {
                                        $user->label = $row['Usuario'];
                                    } else {
                                        if ($mode == 'CREATE') {
                                            $user->label = $code;
                                        }
                                    }
                                    if (!empty($row['Apellidos'])) {
                                        $user->surname = $row['Apellidos'];
                                    }
                                    if (!empty($row['Nombres'])) {
                                        $user->name = $row['Nombres'];
                                    }
                                    if (!empty($row['Carrera'])) {
                                        $user->career = $row['Carrera'];
                                    }
                                    if (!empty($row['Telefono'])) {
                                        $user->phone = $row['Telefono'];
                                    }
                                    if (!empty($row['Celular'])) {
                                        $user->cellphone = $row['Celular'];
                                    }

                                    if ($user->isValid()) {
                                        if ($mode == 'EDIT') {
                                            if (Yeah_Acl::hasPermission('users', 'edit')) {
                                                $user->save();
                                                $count++;
                                            }
                                        } else if ($mode == 'CREATE') {
                                            if (Yeah_Acl::hasPermission('users', 'new')) {
                                                $password = generatecode();
                                                $user->password = md5($password);
                                                $user->tsregister = time();
                                                $user->save();
                                                $count++;
                                                // email notification
                                                $view = new Zend_View();
                                                $view->addHelperPath($CONFIG->dirroot . 'libs/Yeah/Helpers', 'Yeah_Helpers');
                                                $view->setScriptPath($CONFIG->dirroot . 'modules/users/views/scripts/user/');
                                                $view->user       = $user;
                                                $view->servername = $CONFIG->wwwroot;
                                                $view->author     = $USER->label;
                                                $view->password   = $password;
                                                $content = $view->render('mail.php');
                                                $mail = new Zend_Mail();
                                                $mail->setBodyHtml($content)
                                                     ->addTo($user->email, $user->getFullName())
                                                     ->setSubject(utf8_decode('Notificación de registro de usuario'))
                                                     ->send(); // FIXME agregar opcion smtp al gestor de correos
                                            }
                                        }
                                    } else {
                                        $session->messages->addMessage("Error los datos no son validos!" . $user->label);
                                    }
                                }
                            }
                            $session->messages->addMessage("Se han insertado $count usuarios");
                            unlink($filename);
                        } else {
                            $session->messages->addMessage("Una de los columnas requeridas no se encuentran");
                        }
                        break;
                }
            }
        }

        history('users/import');
        $breadcrumb = array();
        $breadcrumb['Usuarios'] = $this->view->url(array(), 'users_manager');
        breadcrumb($breadcrumb);
    }

    public function exportAction() {
        global $CONFIG;
        global $USER;

        $this->requirePermission('users', 'export');
        $this->requirePermission('users', array('list'));
        $this->requirePermission('users', array('view'));

        $request = $this->getRequest();

        $model = Yeah_Adapter::getModel('users');
        $users = $model->selectAll();
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
                    foreach ($users as $user) {
                        $row = array();
                        foreach ($columns as $column) {
                            if ($column == 'role') {
                                $row[] = '"' . $this->view->utf2html($user->getRole()->label) . '"';
                            } else {
                                $row[] = '"' . $this->view->utf2html($user->$column) . '"';
                            }
                        }
                        $csv .= implode(', ', $row) . '
';
                    }

                    header("HTTP/1.1 200 OK"); //mandamos código de OK
                    header("Status: 200 OK"); //sirve para corregir un bug de IE (fuente: php.net)
                    header('Content-Type: text/csv');
                    header('Content-Disposition: attachment; filename="usuarios.csv"');
                    header('Content-Length: '. strlen($csv));
                    echo $csv;
                    die();
                    break;
            }
        }

        history('users/export');
        $breadcrumb = array();
        $breadcrumb['Usuarios'] = $this->view->url(array(), 'users_manager');
        breadcrumb($breadcrumb);
    }
}
