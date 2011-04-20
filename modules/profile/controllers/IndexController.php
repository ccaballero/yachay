<?php

class Profile_IndexController extends Yeah_Action
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
        $model_tags_users = new Tags_Users();

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
            $newTags = $request->getParam('tags');
            $user->hobbies = $request->getParam('hobbies');
            $user->sign = $request->getParam('sign');
            $user->description = $request->getParam('description');

            if ($user->isValid()) {
                // config of avatar
                $upload = new Zend_File_Transfer_Adapter_Http();
                $upload->setDestination($CONFIG->dirroot . 'media/upload');
                $upload->addValidator('Size', false, 2097152)
                       ->addValidator('Extension', false, array('jpg', 'png', 'gif'));
                if ($upload->receive()) {
                    $filename = $upload->getFileName('file');

                    $thumbnail = new Yeah_Helpers_Thumbnail();

                    $thumbnail->thumbnail($filename, $CONFIG->dirroot . 'media/users/thumbnail_large/' . $user->ident . '.jpg', 200, 200);
                    $thumbnail->thumbnail($filename, $CONFIG->dirroot . 'media/users/thumbnail_medium/' . $user->ident . '.jpg', 100, 100);
                    $thumbnail->thumbnail($filename, $CONFIG->dirroot . 'media/users/thumbnail_small/' . $user->ident . '.jpg', 50, 50);

                    unlink($filename);
                    $user->avatar = true;
                } else {
                    $session->messages->addMessage('Debe escoger un archivo valido para poder interpretarlo adecuadamente');
                }

                $user->save();
                $session->user = $user;

                // TAG REGISTER
                $newTags = explode(',', $newTags);
                $oldTags = $_tags;
                $saved_tags = array();

                // removing duplicates tags
                foreach ($newTags as $new_tag) {
                    $new_tag = trim(strtolower($new_tag));
                    if (!in_array($new_tag, $saved_tags)) {
                        $saved_tags[] = $new_tag;
                    }
                }

                for ($i = 0; $i < count($saved_tags); $i++) {
                    for ($j = 0; $j < count($oldTags); $j++) {
                        if (isset($saved_tags[$i]) && isset($oldTags[$j])) {
                            if ($saved_tags[$i] == $oldTags[$j]) {
                                $saved_tags[$i] = NULL;
                                $oldTags[$j] = NULL;
                            }
                        }
                    }
                }
                foreach ($saved_tags as $tagLabel) {
                    if ($tagLabel <> NULL) {
                        $tagLabel = trim(strtolower($tagLabel));
                        $tag = $model_tags->findByLabel($tagLabel);
                        if ($tag == NULL) {
                            $tag = $model_tags->createRow();
                            $tag->label = $tagLabel;
                            $tag->url = convert($tag->label);
                            $tag->weight = 1;
                            if ($tag->isValid()) {
                                $tag->tsregister = time();
                                $tag->save();
                            }
                        } else {
                            $tag->weight = $tag->weight + 1;
                            $tag->save();
                        }

                        if ($tag->ident <> 0) {
                            $assign = $model_tags_users->createRow();
                            $assign->tag = $tag->ident;
                            $assign->user = $user->ident;
                            $assign->save();
                        }
                    }
                }
                foreach ($oldTags as $tagLabel) {
                    if ($tagLabel <> NULL) {
                        $tag = $model_tags->findByLabel($tagLabel);
                        $tag->weight = $tag->weight - 1;
                        $tag->save();

                        $assign = $model_tags_users->findByTagAndUser($tag->ident, $user->ident);
                        $assign->delete();

                        if ($tag->weight == 0) {
                            $tag->delete();
                        }
                    }
                }

                $session->messages->addMessage('Tu has modificado tu perfil correctamente');
                $session->url = $user->url;
                $this->_redirect($request->getParam('return'));
            } else {
                foreach ($user->getMessages() as $message) {
                    $session->messages->addMessage($message);
                }
            }
        }

        $this->view->addHelperPath($CONFIG->dirroot . 'modules/users/views/helpers', 'Users_View_Helper_');
        $this->view->model_users = $model_users;
        $this->view->user = $user;
        $this->view->tags = implode(', ', $_tags);

        history('profile/edit');
        $breadcrumb = array();
        $breadcrumb['Perfil'] = $this->view->url(array(), 'profile_view');
        breadcrumb($breadcrumb);
    }
}
