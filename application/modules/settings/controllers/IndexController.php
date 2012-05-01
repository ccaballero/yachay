<?php

class Settings_IndexController extends Yachay_Action
{
    public function indexAction() {
        global $USER;

        $config = Zend_Registry::get('config');
        $request = $this->getRequest();

        $url = $request->getParam('user');
        if ($url != $USER->url) {
            $this->_redirect($this->view->url(array(), 'frontpage'));
        }

        $model_users = new Users();
        $user = $model_users->findByUrl($url);
        $this->requireExistence($user, 'user', 'profile_view', 'frontpage_user');

        $this->context('user', $user);

        if ($request->isPost()) {
            $session = new Zend_Session_Namespace('yachay');

            $password1 = $request->getParam('password1');
            $password2 = $request->getParam('password2');

            if (!empty($password1) && !empty($password2) && $password1 == $password2) {
                $user->password = md5($config->yachay->properties->key . $password1);
                $user->save();

                $this->_helper->flashMessenger->addMessage('Tu has cambiado tus preferencias correctamente');
                $session->url = $user->url;
                $this->_redirect($request->getParam('return'));
            } else {
                $this->_helper->flashMessenger->addMessage('Las entradas no son validas, recuerde que deben ser iguales y no estar vacias');
            }
        }

        $this->view->model_users = $model_users;
        $this->view->user = $user;

        $this->history('settings/' . $user->url);
        breadcrumb();
    }
}
