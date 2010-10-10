<?php

class Communities_ManagerController extends Yeah_Action
{
    public function indexAction() {
        global $USER;

        $this->requirePermission('communities', 'list');
        $this->requirePermission('communities', 'enter');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $delete = $request->getParam('delete');
            if (!empty($delete)) {
                $this->_forward('delete');
            }
        }

        $model_communities = Yeah_Adapter::getModel('communities');
        $communities = $model_communities->selectByAuthor($USER->ident);

        $this->view->model = $model_communities;
        $this->view->communities = $communities;

        history('communities/manager');
        breadcrumb();
    }

    public function newAction() {
        global $USER;

        $this->requirePermission('communities', 'enter');

        $this->view->community = new modules_communities_models_Communities_Empty;

        $request = $this->getRequest();
        if ($request->isPost()) {
            $session = new Zend_Session_Namespace();

            $model_communities = Yeah_Adapter::getModel('communities');
            $model_communities_users = Yeah_Adapter::getModel('communities', 'Communities_Users');

            $community = $model_communities->createRow();

            $community->label = $request->getParam('label');
            $community->url = convert($community->label);
            $community->mode = $request->getParam('mode');
            $community->interests = $request->getParam('interests');
            $community->description = $request->getParam('description');

            if ($community->isValid()) {
                $community->author = $USER->ident;
                $community->tsregister = time();
                $community->save();

                // add author to community's users
                $assignement = $model_communities_users->createRow();
                $assignement->community = $community->ident;
                $assignement->user = $USER->ident;
                $assignement->type = 'moderator';
                $assignement->status = 'active';
                $assignement->tsregister = time();
                $assignement->save();

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
                    imagejpeg($thumb, $CONFIG->dirroot . 'media/communities/thumbnail_large/' . $community->ident . '.jpg', 100);

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
                    imagejpeg($thumb, $CONFIG->dirroot . 'media/communities/thumbnail_medium/' . $community->ident . '.jpg', 100);

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
                    imagejpeg($thumb, $CONFIG->dirroot . 'media/communities/thumbnail_small/' . $community->ident . '.jpg', 100);

                    unlink($filename);
                    $community->avatar = true;
                    $community->save();
                }

                $session->messages->addMessage("La comunidad {$community->label} se ha creado correctamente");
                $session->url = $community->url;
                $this->_redirect($request->getParam('return'));
            } else {
                foreach ($community->getMessages() as $message) {
                    $session->messages->addMessage($message);
                }
            }

            $this->view->community = $community;
        }

        history('communities/new');
        $breadcrumb = array();
        $breadcrumb['Comunidades'] = $this->view->url(array(), 'communities_manager');
        breadcrumb($breadcrumb);
    }

    public function deleteAction() {
        $this->requirePermission('communities', 'enter');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $model_communities = Yeah_Adapter::getModel('communities');
            $check = $request->getParam("check");

            $count = 0;
            foreach ($check as $value) {
                $community = $model_communities->findByIdent($value);
                if (!empty($community) && $community->amAuthor()) {
                    $community->delete();
                    $count++;
                }
            }

            $session = new Zend_Session_Namespace();
            $session->messages->addMessage("Se han eliminado $count comunidades");
        }
        $this->_redirect($this->view->currentPage());
    }
}
