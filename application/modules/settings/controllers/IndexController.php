<?php

class Settings_IndexController extends Yachay_Controller_Action
{
    public function indexAction() {
        $request = $this->getRequest();

        $this->requireExistence($this->user, 'user', 'profile_view', 'frontpage_user');

        $this->context('user', $this->user);

        if ($request->isPost()) {
            $session = new Zend_Session_Namespace('yachay');

            $password1 = $request->getParam('password1');
            $password2 = $request->getParam('password2');

            if (!empty($password1) && !empty($password2) && $password1 == $password2) {
                $this->user->password = md5($this->config->yachay->properties->key . $password1);
                $this->user->save();

                $this->_helper->flashMessenger->addMessage('Tu has cambiado tus preferencias correctamente');
                $session->url = $this->user->url;
                $this->_redirect($request->getParam('return'));
            } else {
                $this->_helper->flashMessenger->addMessage('Las entradas no son validas, recuerde que deben ser iguales y no estar vacias');
            }
        } else {
            $this->history('settings/' . $this->user->url);
        }

        $this->breadcrumb();
    }
}
