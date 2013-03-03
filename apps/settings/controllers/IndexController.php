<?php

class Settings_IndexController extends Yachay_Controller_Action
{
    public function indexAction() {
        $request = $this->getRequest();

        $this->requireExistence($this->user, 'user', 'profile_view', 'base_user');

        $this->context('user', $this->user);

        if ($request->isPost()) {
            $session = new Zend_Session_Namespace('yachay');

            $passwd = $request->getParam('passwd');
            $newsletter = $request->getParam('newsletter');

            if (isset($passwd)) {
                $password1 = $request->getParam('password1');
                $password2 = $request->getParam('password2');

                if (!empty($password1) && !empty($password2) && $password1 == $password2) {
                    $this->user->password = md5($this->config->system->key . $password1);
                    $this->user->save();

                    $this->_helper->flashMessenger->addMessage('Tu has cambiado tus preferencias correctamente');
                    $session->url = $this->user->url;
                    $this->_redirect($request->getParam('return'));
                } else {
                    $this->_helper->flashMessenger->addMessage('Las entradas no son validas, recuerde que deben ser iguales y no estar vacias');
                }
            } else if (isset($newsletter)) {
                $spaces = $request->getParam('spaces');

                $session = new Zend_Session_Namespace('yachay');

                $context = new Yachay_Helpers_Context();
                $list_spaces = $context->context(NULL, 'plain');
                $valid_spaces = array();

                foreach ($list_spaces as $key => $space) {
                    if (in_array($space, $spaces)) {
                        $valid_spaces[] = $space;
                    }
                }

                $this->user->newsletter = implode(',', $valid_spaces);
                $this->user->save();
                $session->user = $this->user;

                $this->_helper->flashMessenger->addMessage('Tu has cambiado tus preferencias correctamente');
                $this->_redirect($this->view->url(array(), 'settings'));
            }
        } else {
            $this->history('settings/' . $this->user->url);
        }

        $this->breadcrumb();
    }
}
