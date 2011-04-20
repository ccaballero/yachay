<?php

class Users_ManagerController extends Yeah_Action
{
    public function indexAction() {
        $this->requirePermission('users', 'list');
        $this->requirePermission('users', array('new', 'import', 'export', 'lock', 'delete'));

        $request = $this->getRequest();
        if ($request->isPost()) {
            if ($this->acl('users', 'lock')) {
                $lock = $request->getParam('lock');
                $unlock = $request->getParam('unlock');
                if (!empty($lock)) {
                    $this->_forward('lock');
                } else if (!empty($unlock)) {
                    $this->_forward('unlock');
                }
            }
            if ($this->acl('users', 'delete')) {
                $delete = $request->getParam('delete');
                if (!empty($delete)) {
                    $this->_forward('delete');
                }
            }
        }

        $model_users = new Users();

        $this->view->model = $model_users;
        $this->view->users = $model_users->selectAll();

        history('users/manager');
        $breadcrumb = array();
        if ($this->acl('users', 'list')) {
            $breadcrumb['Usuarios'] = $this->view->url(array(), 'users_list');
        }
        breadcrumb($breadcrumb);
    }

    public function newAction() {
        $this->requirePermission('users', 'new');

        $this->view->user = new Users_Empty();

        $request = $this->getRequest();
        if ($request->isPost()) {
            $session = new Zend_Session_Namespace();

            $model_users = new Users();
            $user = $model_users->createRow();

            $user->label = $request->getParam('label');
            $user->url = convert($user->label);
            $user->password = $request->getParam('password');
            $user->code = $request->getParam('code');
            $user->formalname = $request->getParam('formal');
            $user->email = $request->getParam('email');
            $user->surname = $request->getParam('surname');
            $user->name = $request->getParam('name');
            $user->birthdate = $request->getParam('birthdate-year') . '-' . $request->getParam('birthdate-month') . '-' . $request->getParam('birthdate-day');
            $user->career = $request->getParam('career');
            $user->phone = $request->getParam('phone');
            $user->cellphone = $request->getParam('cellphone');

            $user->role = $request->getParam('role');

            if ($user->isValid()) {
                global $CONFIG;
                // role validation,, critical point
                global $USER;
                $model_roles = new Roles();
                $roles = $model_roles->selectByIncludes($USER->role);
                $valid_role = false;
                foreach ($roles as $role) {
                    if ($role->ident == $user->role) {
                        $valid_role |= true;
                    }
                }

                if ($valid_role) {
                    // Password generation
                    $password = generatecode($user->password, $user->code);
                    $user->password = md5($CONFIG->key . $password);

                    $user->tsregister = time();
                    $user->save();

                    if (!empty($user->email)) {
                        // email notification
                        $view = new Zend_View();
                        $view->addHelperPath($CONFIG->dirroot . 'libs/Yeah/Helpers', 'Yeah_Helpers');
                        $view->setScriptPath($CONFIG->dirroot . 'modules/users/views/scripts/user/');

                        $view->user       = $user;
                        $view->servername = $CONFIG->wwwroot;
                        $view->author     = $USER->label;
                        $view->password   = $password;

                        $content = $view->render('mail.php');
                        $mail = new Zend_Mail('UTF-8');
                        $mail->setBodyHtml($content)
                             ->setFrom($CONFIG->email_direction, $CONFIG->email_name)
                             ->addTo($user->email, $user->getFullName())
                             ->setSubject('Notificacion de registro de usuario')
                             ->send();
                    }

                    $session->messages->addMessage("El usuario {$user->label} se ha creado correctamente");
                    $session->url = $user->url;
                    $this->_redirect($request->getParam('return'));
                } else {
                    $session->messages->addMessage('No tiene permisos para establecer ese rol en ese usuario');
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
        if ($this->acl('users', 'list')) {
            $breadcrumb['Usuarios'] = $this->view->url(array(), 'users_list');
        }
        if ($this->acl('users', array('new', 'import', 'export', 'lock', 'delete'))) {
            $breadcrumb['Administrador de usuarios'] = $this->view->url(array(), 'users_manager');
        }
        breadcrumb($breadcrumb);
    }

    public function lockAction() {
        global $USER;

        $this->requirePermission('users', 'lock');
        $request = $this->getRequest();

        if ($request->isPost()) {
            $check = $request->getParam("check");

            $model_roles = new Roles();
            $roles = $model_roles->selectByIncludes($USER->role);

            foreach ($check as $value) {
                $model_users = new Users();
                $user = $model_users->findByIdent($value);

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
            $check = $request->getParam("check");

            $model_roles = new Roles();
            $roles = $model_roles->selectByIncludes($USER->role);

            foreach ($check as $value) {
                $model_users = new Users();
                $user = $model_users->findByIdent($value);

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
            $check = $request->getParam("check");

            $model_roles = new Roles();
            $roles = $model_roles->selectByIncludes($USER->role);

            foreach ($check as $value) {
                $model_users = new Users();
                $user = $model_users->findByIdent($value);

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
        if ($this->acl('users', 'new')) {
            $options['CREATE_NOEDIT'] = 'Solo crear usuarios nuevos, e ignorar los restantes.';
        }
        if ($this->acl('users', 'edit')) {
            $options['NOCREATE_EDIT'] = 'Solo actualizar la información de los existentes, no registrar nuevos.';
        }
        if ($this->acl('users', 'new') && $this->acl('users', 'edit')) {
            $options['CREATE_EDIT'] = 'Crear usuarios, y actualizar la información de los existentes.';
        }
        $this->view->options = $options;
        $this->view->step = 1;

        $request = $this->getRequest();
        if ($request->isPost()) {
            $session = new Zend_Session_Namespace();

            $model_users = new Users();
            $model_roles = new Roles();
            $model_careers = new Careers();

            $selections = $request->getParam('users');
            if (empty($selections)) {
                $password = $request->getParam('password');
                if ($password == '') {
                    $session->messages->addMessage('Debe establecer un generador de contraseña');
                    $this->_redirect($this->view->currentPage());
                }

                $upload = new Zend_File_Transfer_Adapter_Http();
                $upload->setDestination($CONFIG->dirroot . 'media/upload');
                $upload->addValidator('Size', false, 2097152)
                       ->addValidator('Extension', false, array('csv'));

                if ($upload->receive()) {
                    $filename = $upload->getFileName('file');
                    $extension = strtolower(substr($filename, -3));

                    $type = $request->getParam('type');
                    $role_default = $request->getParam('role');

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

                            if ($csv->hasColumn($_headers['CODIGO']) && $csv->hasColumn($_headers['NOMBRE COMPLETO'])) {
                                $results = array();

                                foreach ($rows as $row) {
                                    $result = array();

                                    $result['CODIGO'] = trim($row[$_headers['CODIGO']]);
                                    $user = $model_users->findByCode($result['CODIGO']);
                                    if (empty($user)) {
                                        $result['CODIGO_NUE'] = TRUE;
                                    } else {
                                        $result['CODIGO_NUE'] = FALSE;
                                        $result['USUARIO_OBJ'] = $user;
                                    }

                                    $result['NOMBRE COMPLETO'] = $row[$_headers['NOMBRE COMPLETO']];
                                    $result['USUARIO'] = isset($_headers['USUARIO']) ? $row[$_headers['USUARIO']] : $result['CODIGO'];
                                    $result['CORREO ELECTRONICO'] = isset($_headers['CORREO ELECTRONICO']) ? $row[$_headers['CORREO ELECTRONICO']] : '';
                                    $result['APELLIDOS'] = isset($_headers['APELLIDOS']) ? $row[$_headers['APELLIDOS']] : '';
                                    $result['NOMBRES'] = isset($_headers['NOMBRES']) ? $row[$_headers['NOMBRES']] : '';
                                    $result['CARRERA'] = isset($_headers['CARRERA']) ? $model_careers->findByLabel($row[$_headers['CARRERA']]) : NULL;
                                    $result['PASSWORD'] = $password;

                                    $role = $model_roles->findByIdent($role_default);
                                    if (empty($role)) {
                                        $label = 'No definido';
                                    } else {
                                        $label = $role->label;
                                    }

                                    $result['ROL'] = isset($_headers['ROL']) ? $row[$_headers['ROL']] : $label;
                                    $roles_allowed = $model_roles->selectByIncludes($USER->role);
                                    $valid_role = false;
                                    foreach ($roles_allowed as $role_allowed) {
                                        if (strtolower($role_allowed->label) == strtolower($result['ROL'])) {
                                            $valid_role |= true;
                                            $role = $role_allowed;
                                        }
                                    }
                                    if (!empty($role) && $valid_role) {
                                        $result['ROL_OBJ'] = $role;
                                    }

                                    $result['CHECKED'] = ($type == 'CREATE_NOEDIT') && $result['CODIGO_NUE'];
                                    $result['CHECKED'] |= ($type == 'NOCREATE_EDIT') && (!$result['CODIGO_NUE']);
                                    $result['CHECKED'] |= ($type == 'CREATE_EDIT');

                                    $results[] = $result;
                                }

                                $this->view->headers = array('CODIGO', 'NOMBRE COMPLETO', 'CORREO ELECTRONICO', 'ROL', 'USUARIO', 'APELLIDOS', 'NOMBRES', 'CARRERA');
                                $this->view->results = $results;
                                $this->view->type = $type;
                                $this->view->password = $password;

                                $session->import_users = $results;
                            } else {
                                if (!$csv->hasColumn($_headers['CODIGO'])) {
                                    $session->messages->addMessage('La columna CODIGO no fue encontrada');
                                    $this->_redirect($this->view->currentPage());
                                }
                                if (!$csv->hasColumn($_headers['NOMBRE COMPLETO'])) {
                                    $session->messages->addMessage('La columna NOMBRE COMPLETO no fue encontrada');
                                    $this->_redirect($this->view->currentPage());
                                }
                            }
                        break;
                    }
                    unlink($filename);
                } else {
                    $session->messages->addMessage('Debe escoger un archivo valido para poder interpretarlo adecuadamente');
                }
            } else {
                if (isset($session->import_users)) {
                    $count_new = 0;
                    $count_edit = 0;
                    foreach ($session->import_users as $result) {
                        if (in_array($result['CODIGO'], $selections)) {
                            if ($result['CODIGO_NUE'] && Yeah_Acl::hasPermission('users', 'new')) {
                                $user = $model_users->createRow();
                                $user->code = $result['CODIGO'];
                                $user->status = 'active';
                                $user->tsregister = time();
                                // Password generation
                                $password = generatecode($result['PASSWORD'], $result['CODIGO']);
                                $user->password = md5($CONFIG->key . $password);
                            }
                            if (!$result['CODIGO_NUE'] && Yeah_Acl::hasPermission('users', 'edit')) {
                                $user = $model_users->findByCode($result['CODIGO']);
                            }
                            if (isset($user)) {
                                if (isset($result['ROL_OBJ'])) {
                                    $user->role = $result['ROL_OBJ']->ident;
                                }
                                $user->formalname = $result['NOMBRE COMPLETO'];
                                $user->label = $result['USUARIO'];
                                $user->url = convert($user->label);
                                $user->email = $result['CORREO ELECTRONICO'];
                                $user->surname = $result['APELLIDOS'];
                                $user->name = $result['NOMBRES'];
                                $user->career = empty($result['CARRERA']) ? 0 : $result['CARRERA']->ident;

                                if ($user->isValid()) {
                                    $user->save();
                                    if ($result['CODIGO_NUE'] && !empty($user->email)) {
                                        // email notification
                                        $view = new Zend_View();
                                        $view->addHelperPath($CONFIG->dirroot . 'libs/Yeah/Helpers', 'Yeah_Helpers');
                                        $view->setScriptPath($CONFIG->dirroot . 'modules/users/views/scripts/user/');
                                        $view->user       = $user;
                                        $view->servername = $CONFIG->wwwroot;
                                        $view->author     = $USER->label;
                                        $view->password   = $password;
                                        $content = $view->render('mail.php');
                                        $mail = new Zend_Mail('UTF-8');
                                        $mail->setBodyHtml($content)
                                             ->setFrom($CONFIG->email_direction, $CONFIG->email_name)
                                             ->addTo($user->email, $user->getFullName())
                                             ->setSubject('Notificacion de registro de usuario')
                                             ->send(); // FIXME agregar opcion smtp al gestor de correos
                                    }
                                    if ($result['CODIGO_NUE']) {
                                        $count_new++;
                                    } else {
                                        $count_edit++;
                                    }
                                }
                            }
                        }
                    }
                    $session->messages->addMessage("Se han creado $count_new usuarios nuevos y se han editado $count_edit usuarios");
                    $this->_redirect($this->view->lastPage());
                }
                unset($session->import_users);
            }
        }

        history('users/import');
        $breadcrumb = array();
        if ($this->acl('users', 'list')) {
            $breadcrumb['Usuarios'] = $this->view->url(array(), 'users_list');
        }
        if ($this->acl('users', array('new', 'import', 'export', 'lock', 'delete'))) {
            $breadcrumb['Administrador de usuarios'] = $this->view->url(array(), 'users_manager');
        }
        breadcrumb($breadcrumb);
    }

    public function exportAction() {
        global $CONFIG;
        global $USER;

        $this->requirePermission('users', 'export');
        $this->requirePermission('users', array('list'));
        $this->requirePermission('users', array('view'));

        $request = $this->getRequest();

        $model_users = new Users();
        $users = $model_users->selectAll();
        $this->view->model_users = $model_users;

        if ($request->isPost()) {
            $columns = $request->getParam('columns');
            $extension = $request->getParam('extension');

            switch ($extension) {
                case 'csv':
                    $csv = '';

                    $headers = array();
                    foreach ($columns as $column) {
                        $headers[] = '"' . $model_users->_mapping[$column] . '"';
                    }
                    $csv .= implode(',', $headers) . '
';
                    foreach ($users as $user) {
                        $row = array();
                        foreach ($columns as $column) {
                            if ($column == 'role') {
                                $row[] = '"' . $user->getRole()->label . '"';
                            } else if ($column == 'career') {
                                $row[] = '"' . $user->getCareer()->label . '"';
                            } else {
                                $row[] = '"' . $user->$column . '"';
                            }
                        }
                        $csv .= implode(',', $row) . '
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
        if ($this->acl('users', 'list')) {
            $breadcrumb['Usuarios'] = $this->view->url(array(), 'users_list');
        }
        if ($this->acl('users', array('new', 'import', 'export', 'lock', 'delete'))) {
            $breadcrumb['Administrador de usuarios'] = $this->view->url(array(), 'users_manager');
        }
        breadcrumb($breadcrumb);
    }
}
