<?php

class Profile_IndexController extends Yachay_Action
{
    public function viewAction() {
        global $USER;
        global $CONFIG;

        if ($USER->role == 1) {
            $this->_redirect($CONFIG->wwwroot);
        }

        $request = $this->getRequest();

        $model_users = new Users();
        $user = $model_users->findByUrl($USER->url);
        $this->requireExistence($user, 'user', 'profile_view', 'frontpage_user');

        context('user', $user);

        $this->view->model_users = $model_users;
        $this->view->user = $user;

        history('profile');
        breadcrumb();
    }

    public function editAction() {
        global $USER;
        global $CONFIG;

        if ($USER->role == 1) {
            $this->_redirect($CONFIG->wwwroot);
        }

        $request = $this->getRequest();

        $model_users = new Users();
        $model_tags = new Tags();

        $user = $model_users->findByUrl($USER->url);
        $this->requireExistence($user, 'user', 'profile_view', 'frontpage_user');

        context('user', $user);

        $_tags = array();
        $tags = $user->getTags();
        foreach ($tags as $tag) {
            $_tags[] = $tag->label;
        }

        if ($request->isPost()) {
            $session = new Zend_Session_Namespace();

            $user->label = $request->getParam('label');
            $user->url = convert($user->label);
            $user->email = $request->getParam('email');
            $user->surname = $request->getParam('surname');
            $user->name = $request->getParam('name');
            $user->birthdate = $request->getParam('birthdate-year') . '-' . $request->getParam('birthdate-month') . '-' . $request->getParam('birthdate-day');
            $user->career = $request->getParam('career');
            $user->phone = $request->getParam('phone');
            $user->cellphone = $request->getParam('cellphone');
            $user->hobbies = $request->getParam('hobbies');
            $user->sign = $request->getParam('sign');
            $user->description = $request->getParam('description');

            if ($user->isValid()) {
                // config of avatar
                $upload = new Zend_File_Transfer_Adapter_Http();
                $upload->setDestination(APPLICATION_PATH . '/../public/media/upload');
                $upload->addValidator('Size', false, 2097152)
                       ->addValidator('Extension', false, array('jpg', 'png', 'gif'));
                if ($upload->receive()) {
                    $filename = $upload->getFileName('file');

                    $thumbnail = new Yachay_Helpers_Thumbnail();

                    $thumbnail->thumbnail($filename, APPLICATION_PATH . '/../public/media/users/thumbnail_large/' . $user->ident . '.jpg', 200, 200);
                    $thumbnail->thumbnail($filename, APPLICATION_PATH . '/../public/media/users/thumbnail_medium/' . $user->ident . '.jpg', 100, 100);
                    $thumbnail->thumbnail($filename, APPLICATION_PATH . '/../public/media/users/thumbnail_small/' . $user->ident . '.jpg', 50, 50);

                    unlink($filename);
                    $user->avatar = true;
                }

                // re-tagging
                $model_tags->tagging_user($_tags, $request->getParam('tags'), $user);

                $user->save();
                $session->user = $user;

                $session->messages->addMessage('Tu has modificado tu perfil correctamente');
                $session->url = $user->url;
                $this->_redirect($request->getParam('return'));
            } else {
                foreach ($user->getMessages() as $message) {
                    $session->messages->addMessage($message);
                }
            }
        }

        $this->view->addHelperPath(APPLICATION_PATH . '/modules/users/views/helpers', 'Users_View_Helper_');
        $this->view->model_users = $model_users;
        $this->view->user = $user;
        $this->view->tags = implode(', ', $_tags);

        history('profile/edit');
        $breadcrumb = array();
        $breadcrumb['Perfil'] = $this->view->url(array(), 'profile_view');
        breadcrumb($breadcrumb);
    }
}
