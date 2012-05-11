<?php

class Profile_IndexController extends Yachay_Controller_Action
{
    public function viewAction() {
        if ($this->user->role == 1) {
            $this->_redirect($this->view->url(array(), 'frontpage'));
        }

        $this->requireExistence($this->user, 'user', 'profile_view', 'frontpage_user');

        $this->context('user', $this->user);
        $this->history('profile');
        $this->breadcrumb();
    }

    public function editAction() {
        if ($this->user->role == 1) {
            $this->_redirect($this->view->url(array(), 'frontpage'));
        }

        $request = $this->getRequest();

        $model_tags = new Tags();

        $this->requireExistence($this->user, 'user', 'profile_view', 'frontpage_user');

        $this->context('user', $this->user);

        $_tags = array();
        $tags = $this->user->getTags();
        foreach ($tags as $tag) {
            $_tags[] = $tag->label;
        }

        if ($request->isPost()) {
            $convert = new Yachay_Helpers_Convert();
            $session = new Zend_Session_Namespace('yachay');

            $this->user->label = $request->getParam('label');
            $this->user->url = $convert->convert($this->user->label);
            $this->user->email = $request->getParam('email');
            $this->user->surname = $request->getParam('surname');
            $this->user->name = $request->getParam('name');
            $this->user->birthdate = $request->getParam('birthdate-year') . '-' . $request->getParam('birthdate-month') . '-' . $request->getParam('birthdate-day');
            $this->user->career = $request->getParam('career');
            $this->user->phone = $request->getParam('phone');
            $this->user->cellphone = $request->getParam('cellphone');
            $this->user->hobbies = $request->getParam('hobbies');
            $this->user->sign = $request->getParam('sign');
            $this->user->description = $request->getParam('description');

            if ($this->user->isValid()) {
                // config of avatar
                $upload = new Zend_File_Transfer_Adapter_Http();
                $upload->setDestination(APPLICATION_PATH . '/../data/upload/');
                $upload->addValidator('Size', false, 2097152)
                       ->addValidator('Extension', false, array('jpg', 'png', 'gif'));
                if ($upload->receive()) {
                    $filename = $upload->getFileName('file');

                    $thumbnail = new Yachay_Helpers_Thumbnail();
                    $thumbnail->thumbnail($filename, APPLICATION_PATH . '/../public/media/users/thumbnail_large/' . $this->user->ident . '.jpg', 200, 200);
                    $thumbnail->thumbnail($filename, APPLICATION_PATH . '/../public/media/users/thumbnail_medium/' . $this->user->ident . '.jpg', 100, 100);
                    $thumbnail->thumbnail($filename, APPLICATION_PATH . '/../public/media/users/thumbnail_small/' . $this->user->ident . '.jpg', 50, 50);

                    unlink($filename);
                }

                // re-tagging
                $model_tags->tagging_user($_tags, $request->getParam('tags'), $this->user);

                $this->user->save();
                $session->user = $this->user;

                $this->_helper->flashMessenger->addMessage('Tu has modificado tu perfil correctamente');
                $session->url = $this->user->url;
                $this->_redirect($request->getParam('return'));
            } else {
                foreach ($this->user->getMessages() as $message) {
                    $this->_helper->flashMessenger->addMessage($message);
                }
            }
        } else {
            $this->history('profile/edit');
        }

        $this->view->addHelperPath(APPLICATION_PATH . '/modules/users/views/helpers', 'Users_View_Helper_');
        $this->view->tags = implode(', ', $_tags);

        $breadcrumb = array();
        $breadcrumb['Perfil'] = $this->view->url(array(), 'profile_view');
        $this->breadcrumb($breadcrumb);
    }
}
