<?php

class Login_ForgotController extends Yeah_Action
{
    public function indexAction() {
        global $CONFIG;
        global $USER;

        if ($USER->role != 1) {
            $this->_redirect($CONFIG->wwwroot);
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $filters = array(
                'email' => array('StringTrim', 'StringToLower'),
            );
            $validators = array(
                'correo electronico' => array(
                    new Zend_Validate_EmailAddress(),
                    'allowEmpty' => false,
                    'presence'   => 'required',
                    'fields'     => 'email',
                    'messages'   => array(
                        'El correo electronio debe ser valido',
                    ),
                ),
            );
            $options = array(
                'notEmptyMessage' => 'El %rule% no puede estar vacio'
            );
            $input = new Zend_Filter_Input($filters, $validators, $_POST, $options);
            $session = new Zend_Session_Namespace();
            if ($input->isValid()) {
                $user = Yeah_Adapter::getModel('users')->findByEmail($input->email);
                if (!empty($user)) {
                    if ($user->status != 'inactive') {
	                    // Register in database
	                    $login = Yeah_Adapter::getModel('login');
	                    $forgot = $login->selectByUser($user->ident);
	                    if (empty($forgot)) {
	                        $forgot = $login->createRow();
	                    }
	                    $forgot->user = $user->ident;
	                    $forgot->password = generatecode();
	                    $forgot->tsregister = time();
	                    $forgot->tstimeout = 86400; // 24 horas
	                    $forgot->save();
	
	                    // Sending to mail
	                    $view = new Zend_View();
	                    $view->addHelperPath($CONFIG->dirroot . 'libs/Yeah/Helpers', 'Yeah_Helpers');
	                    $view->setScriptPath($CONFIG->dirroot . 'modules/login/views/scripts/forgot/');
	
	                    $view->servername = $CONFIG->wwwroot;
	                    $view->code       = $forgot->password;
	                    $view->petition   = $forgot->tsregister;
	                    $view->expiration = $forgot->tsregister + $forgot->tstimeout;
	
	                    $content = $view->render('mail.php');
	
	                    $mail = new Zend_Mail();
	                    $mail->setBodyHtml($content)
	                         ->addTo($user->email, $user->getFullName())
	                         ->setSubject('Petición de cambio de contraseña')
	                         ->send();
	
	                    $session->messages->addMessage('Se envi&oacute; la confirmaci&oacute;n de nueva contrase&ntilde;a al correo ' . $user->email);
	                    $this->_redirect($request->getParam('return'));
                    } else {
                        $session->messages->addMessage('Usted se encuentra en estado inactivo, no puede solicitar una nueva contrase&ntildea, primero solicite la re-activacion de su cuenta');
                    }
                } else {
                    $session->messages->addMessage('El correo no aparece en el registro de usuarios');
                }
            } else {
                foreach($input->getMessages() as $messages) {
                    foreach($messages as $message) {
                        $session->messages->addMessage($message);
                    }
                }
            }
            
            $this->view->values = array('email' => $request->getParam('email'));
        }

        history('forgot');
        $breadcrumb = array();
        $breadcrumb['Ingresar'] = $this->view->url(array(), 'login_in');
        breadcrumb($breadcrumb);
    }
}
