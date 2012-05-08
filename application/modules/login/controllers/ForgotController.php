<?php

class Login_ForgotController extends Yachay_Controller_Action
{
    public function indexAction() {
        if ($this->user->role != 1) {
            $this->_redirect($this->view->url(array(), 'frontpage'));
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
                        'El correo electrónico debe ser valido',
                    ),
                ),
            );
            $options = array(
                'notEmptyMessage' => 'El %rule% no puede estar vacio'
            );

            $input = new Zend_Filter_Input($filters, $validators, $_POST, $options);
            if ($input->isValid()) {
                $generateCode = new Yachay_Helpers_GenerateCode();
                $code = $generateCode->generateCode();

                $model_users = new Users();
                $user = $model_users->findByEmail($input->email);
                if (!empty($user)) {
                    if ($user->status != 'inactive') {
	                    // Register in database
	                    $model_login = new Login();
	                    $forgot = $model_login->selectByUser($user->ident);
	                    if (empty($forgot)) {
	                        $forgot = $model_login->createRow();
	                    }
	                    $forgot->user = $user->ident;
	                    $forgot->password = md5($this->config->yachay->properties->key . $code);
	                    $forgot->tsregister = time();
	                    $forgot->tstimeout = 86400; // 24 horas
	                    $forgot->save();
	
	                    // Sending to mail
	                    $view = new Zend_View();
	                    $view->addHelperPath(APPLICATION_PATH . '/../library/Yachay/Helpers', 'Yachay_Helpers');
	                    $view->setScriptPath(APPLICATION_PATH . '/modules/login/views/scripts/forgot/');
	
	                    $view->servername = $this->config->yachay->properties->servername;
	                    $view->code       = $code;
	                    $view->petition   = $forgot->tsregister;
	                    $view->expiration = $forgot->tsregister + $forgot->tstimeout;
	
	                    $content = $view->render('mail.php');
	
	                    $mail = new Zend_Mail('UTF-8');
	                    $mail->setBodyHtml($content)
                                 ->setFrom($this->config->yachay->properties->email_direction, $this->config->yachay->properties->email_name)
	                         ->addTo($user->email, $user->getFullName())
	                         ->setSubject('Petición de cambio de contraseña')
	                         ->send();
	
	                    $this->_helper->flashMessenger->addMessage('Se envió la confirmación de nueva contraseña al correo ' . $user->email);
	                    $this->_redirect($request->getParam('return'));
                    } else {
                        $this->_helper->flashMessenger->addMessage('Usted se encuentra en estado inactivo, no puede solicitar una nueva contraseña, primero solicite la re-activación de su cuenta');
                    }
                } else {
                    $this->_helper->flashMessenger->addMessage('El correo no aparece en el registro de usuarios');
                }
            } else {
                foreach($input->getMessages() as $messages) {
                    foreach($messages as $message) {
                        $this->_helper->flashMessenger->addMessage($message);
                    }
                }
            }
            
            $this->view->values = array('email' => $request->getParam('email'));
        }

        $this->history('forgot');
        $breadcrumb = array();
        $breadcrumb['Ingresar'] = $this->view->url(array(), 'login_in');
        $this->breadcrumb($breadcrumb);
    }
}
