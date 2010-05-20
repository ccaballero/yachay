<?php

class Login_IndexController extends Yeah_Action
{
    public function inAction() {
        global $CONFIG;
        global $USER;

        if ($USER->role != 1) {
            $this->_redirect($CONFIG->wwwroot);
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $filters = array(
                'username' => array('StringTrim', 'StringToLower'),
            );
            $validators = array(
                'usuario' => array(
                    new Zend_Validate_StringLength(4, 15),
                    new Zend_Validate_Alnum(),
                    'allowEmpty' => false,
                    'presence'   => 'required',
                    'fields'     => 'username',
                    'messages'   => array(
                        'El campo usuario debe tener entre 4 y 15 caracteres',
                        'El campo usuario debe contener unicamente caracteres y numeros',
                    ),
                ),
                'contrase&ntilde;a' => array(
                    new Zend_Validate_StringLength(1, 25),
                    'allowEmpty' => false,
                    'presence'   => 'required',
                    'fields'     => 'password',
                    'messages'   => array(
                        'La contrase&ntilde;a debe tener entre 1 y 25 caracteres',
                    ),
                ),
            );
            $options = array(
                'notEmptyMessage' => 'El campo %rule% no puede estar vacio'
            );
            $input = new Zend_Filter_Input($filters, $validators, $_POST, $options);
            $session = new Zend_Session_Namespace();
            if ($input->isValid()) {
	            $user = Yeah_Adapter::getModel('users')->findByLogin($input->username, md5($input->password));
	            if (!empty($user)) {
	                $session->user = $user;
	                $this->_redirect($request->getParam('return'));
	            } else {
                    // validation for login forgot process
                    $login = Yeah_Adapter::getModel('login');
                    $users = Yeah_Adapter::getModel('users');
                    $user = $users->findByLabel($input->username);
                    if (!empty($user)) {
                        $forgot = $login->selectByUser($user->ident);
                        if (!empty($forgot)) {
                            if ($input->password == $forgot->password) {
                                $now = time();
                                $expiration = $forgot->tsregister + $forgot->tstimeout;
                                $forgot->delete();
                                if ($now < $expiration) {
                                    $session->messages->addMessage('Le recomiendamos que establezca su nueva contrase&ntilde;a');
                                    $session->user = $user;
                                    $this->_redirect($CONFIG->wwwroot);
                                }
                            }
                        }
                    }
	                $session->messages->addMessage('Datos de accesso incorrectos');
	            }
            } else {
                foreach($input->getMessages() as $messages) {
                    foreach($messages as $message) {
                        $session->messages->addMessage($message);
                    }
                }
            }
            
            $this->view->values = array('username' => $request->getParam('username'));
        }
        history('login');
        breadcrumb();
    }

    public function outAction() {
        global $CONFIG;

        $session = new Zend_Session_Namespace();
        $user = $session->user;
        if (!empty($user)) {
            $session->user = null;
        }

        $session = new Zend_Session_Namespace();
        $session->messages->addMessage('Usted salio del sistema');

        $this->_redirect($CONFIG->wwwroot);
    }
}
