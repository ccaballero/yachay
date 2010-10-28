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

        $users = Yeah_Adapter::getModel('users');
        $user = $users->findByUrl($USER->url);
        $this->requireExistence($user, 'user', 'profile_view', 'frontpage_user');

        context('user', $user);

        $this->view->model = $users;
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

        $model_users = Yeah_Adapter::getModel('users');
        $model_tags = Yeah_Adapter::getModel('tags');
        $model_tags_users = Yeah_Adapter::getModel('tags', 'Tags_Users');

        $user = $model_users->findByUrl($USER->url);
        $this->requireExistence($user, 'user', 'profile_view', 'frontpage_user');

        context('user', $user);

        $_tags = array();
        $tags = $user->findmodules_tags_models_TagsViamodules_tags_models_Tags_Users();
        foreach ($tags as $tag) {
            $_tags[] = $tag->label;
        }

        if ($request->isPost()) {
            $session = new Zend_Session_Namespace();

            $user->label = $request->getParam('label');
            $this->url = convert($user->label);
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
                    $extension = strtolower(substr($filename, -3));
                    switch ($extension) {
                        case 'jpg':
                            $uploaded = imagecreatefromjpeg($filename);
                            break;
                        case 'png':
                            $uploaded = imagecreatefrompng($filename);
                            break;
                        case 'gif':
                            $uploaded = imagecreatefromgif($filename);
                            break;
                    }

                    $width = imagesx($uploaded);
                    $height = imagesy($uploaded);

                    // creo y redimensiono la imagen grande
                    $maxwidth = 200;
                    $maxheight = 200;
                    $newwidth = $maxwidth;
                    $newheight = $maxheight;

                    $ratio = $width / $height;
                    if ($ratio == 1) {
                        $newwidth = $maxwidth;
                        $newheigth = $maxwidth;
                    } else if ($ratio > 1) {
                        $newwidth = $maxwidth;
                        $newheight = $maxwidth / $ratio;
                    } else if ($ratio < 1) {
                        $newwidth = $maxheight * $ratio;
                        $newheight = $maxheight;
                    }

                    $thumb = imagecreatetruecolor($newwidth, $newheight);
                    imagecopyresized($thumb, $uploaded, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
                    imagejpeg($thumb, $CONFIG->dirroot . 'media/users/thumbnail_large/' . $user->ident . '.jpg', 100);

                    // creo y redimensiono la imagen mediana
                    $maxwidth = 100;
                    $maxheight = 100;
                    $newwidth = $maxwidth;
                    $newheight = $maxheight;

                    $ratio = $width / $height;
                    if ($ratio == 1) {
                        $newwidth = $maxwidth;
                        $newheigth = $maxwidth;
                    } else if ($ratio > 1) {
                        $newwidth = $maxwidth;
                        $newheight = $maxwidth / $ratio;
                    } else if ($ratio < 1) {
                        $newwidth = $maxheight * $ratio;
                        $newheight = $maxheight;
                    }

                    $thumb = imagecreatetruecolor($newwidth, $newheight);
                    imagecopyresized($thumb, $uploaded, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
                    imagejpeg($thumb, $CONFIG->dirroot . 'media/users/thumbnail_medium/' . $user->ident . '.jpg', 100);

                    // creo y redimensiono la imagen pequeña
                    $maxwidth = 50;
                    $maxheight = 50;
                    $newwidth = $maxwidth;
                    $newheight = $maxheight;

                    $ratio = $width / $height;
                    if ($ratio == 1) {
                        $newwidth = $maxwidth;
                        $newheigth = $maxwidth;
                    } else if ($ratio > 1) {
                        $newwidth = $maxwidth;
                        $newheight = $maxwidth / $ratio;
                    } else if ($ratio < 1) {
                        $newwidth = $maxheight * $ratio;
                        $newheight = $maxheight;
                    }

                    $thumb = imagecreatetruecolor($newwidth, $newheight);
                    imagecopyresized($thumb, $uploaded, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
                    imagejpeg($thumb, $CONFIG->dirroot . 'media/users/thumbnail_small/' . $user->ident . '.jpg', 100);

                    unlink($filename);
                    $user->avatar = true;
                }

                $user->save();
                $session->user = $user;

                $newTags = explode(',', $newTags);
                $oldTags = $_tags;

                for ($i = 0; $i < count($newTags); $i++) {
                    for ($j = 0; $j < count($oldTags); $j++) {
                        if (isset($newTags[$i]) && isset($oldTags[$j])) {
                            if (trim(strtolower($newTags[$i])) == $oldTags[$j]) {
                                $newTags[$i] = NULL;
                                $oldTags[$j] = NULL;
                            }
                        }
                    }
                }
                foreach ($newTags as $tagLabel) {
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

                $session->messages->addMessage("Tu has modificado tu perfil correctamente");
                $session->url = $user->url;
                $this->_redirect($request->getParam('return'));
            } else {
                foreach ($user->getMessages() as $message) {
                    $session->messages->addMessage($message);
                }
            }
        }

        $this->view->addHelperPath($CONFIG->dirroot . 'modules/users/views/helpers', 'Users_View_Helper_');
        $this->view->model = $model_users;
        $this->view->user = $user;
        $this->view->tags = implode(', ', $_tags);

        history('profile/edit');
        $breadcrumb = array();
        $breadcrumb[$user->label] = $this->view->url(array(), 'profile_view');
        breadcrumb($breadcrumb);
    }
}
