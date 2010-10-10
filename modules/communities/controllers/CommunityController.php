<?php

class Communities_CommunityController extends Yeah_Action
{
    public function viewAction() {
        global $USER;

        $this->requirePermission('communities', 'view');

        $request = $this->getRequest();
        $model_communities = Yeah_Adapter::getModel('communities');
        $community = $model_communities->findByUrl($request->getParam('community'));
        $this->requireExistence($community, 'community', 'communities_community_view', 'communities_list');

        context('community', $community);

        $resources = $community->findmodules_resources_models_ResourcesViamodules_communities_models_Communities_Resources($community->select()->order('tsregister DESC'));

        // PAGINATOR
        $page = $request->getParam('page', 1);
        $paginator = Zend_Paginator::factory($resources);
        $paginator->setItemCountPerPage(10);
        $paginator->setCurrentPageNumber($page);
        $paginator->setPageRange(10);

        $this->view->resources = $paginator;
        $this->view->route = array (
            'key' => 'communities_community_view',
            'params' => array (
                'community' => $community->url,
            ),
        );

        $this->view->model = $model_communities;
        $this->view->community = $community;

        history('communities/' . $community->url);
        $breadcrumb = array();
        if (Yeah_Acl::hasPermission('communities', array('enter'))) {
            $breadcrumb['Comunidades'] = $this->view->url(array(), 'communities_manager');
        } else if (Yeah_Acl::hasPermission('communities', 'list')) {
            $breadcrumb['Comunidades'] = $this->view->url(array(), 'communities_list');
        }
        breadcrumb($breadcrumb);
    }

    public function editAction() {
        $this->requirePermission('communities', 'enter');

        $request = $this->getRequest();
        $model_communities = Yeah_Adapter::getModel('communities');
        $community = $model_communities->findByUrl($request->getParam('community'));
        $this->requireExistence($community, 'community', 'communities_community_view', 'community_list');

        context('community', $community);

        if ($request->isPost()) {
            $session = new Zend_Session_Namespace();

            $community->label = $request->getParam('label');
            $community->url = convert($community->label);
            $community->mode = $request->getParam('mode');
            $community->interests = $request->getParam('interests');
            $community->description = $request->getParam('description');

            if ($community->isValid()) {
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
                    $newwidth = $maxwidth + 1;
                    $newheight = $maxheight + 1;

                    while ($newwidth > $maxwidth && $newheight > $maxheight) {
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
                    }

                    $thumb = imagecreatetruecolor($newwidth, $newheight);
                    imagecopyresized($thumb, $uploaded, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
                    imagejpeg($thumb, $CONFIG->dirroot . 'media/communities/thumbnail_large/' . $community->ident . '.jpg', 100);

                    // creo y redimensiono la imagen mediana
                    $maxwidth = 100;
                    $maxheight = 100;
                    $newwidth = $maxwidth + 1;
                    $newheight = $maxheight + 1;

                    while ($newwidth > $maxwidth && $newheight > $maxheight) {
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
                    }

                    $thumb = imagecreatetruecolor($newwidth, $newheight);
                    imagecopyresized($thumb, $uploaded, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
                    imagejpeg($thumb, $CONFIG->dirroot . 'media/communities/thumbnail_medium/' . $community->ident . '.jpg', 100);

                    // creo y redimensiono la imagen pequeña
                    $maxwidth = 50;
                    $maxheight = 50;
                    $newwidth = $maxwidth + 1;
                    $newheight = $maxheight + 1;

                    while ($newwidth > $maxwidth && $newheight > $maxheight) {
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
                    }

                    $thumb = imagecreatetruecolor($newwidth, $newheight);
                    imagecopyresized($thumb, $uploaded, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
                    imagejpeg($thumb, $CONFIG->dirroot . 'media/communities/thumbnail_small/' . $community->ident . '.jpg', 100);

                    unlink($filename);
                    $community->avatar = true;
                }
                $community->save();

                $session->messages->addMessage("La comunidad {$community->label} se ha actualizado correctamente");
                $session->url = $community->url;
                $this->_redirect($request->getParam('return'));
            } else {
                foreach ($area->getMessages() as $message) {
                    $session->messages->addMessage($message);
                }
            }
        }

        $this->view->model = $model_communities;
        $this->view->community = $community;

        history('community/' . $community->url . '/edit');
        $breadcrumb = array();
        if (Yeah_Acl::hasPermission('communities', array('enter'))) {
            $breadcrumb['Comunidades'] = $this->view->url(array(), 'communities_manager');
        } else if (Yeah_Acl::hasPermission('communities', 'list')) {
            $breadcrumb['Comunidades'] = $this->view->url(array(), 'communities_list');
        }
        if (Yeah_Acl::hasPermission('communities', 'view')) {
            $breadcrumb[$community->label] = $this->view->url(array('community' => $community->url), 'communities_community_view');
        }
        breadcrumb($breadcrumb);
    }

    public function deleteAction() {
        $this->requirePermission('communities', 'enter');
        $request = $this->getRequest();

        $url = $request->getParam('community');
        $model_communities = Yeah_Adapter::getModel('communities');
        $community = $model_communities->findByUrl($url);

        $session = new Zend_Session_Namespace();
        if (!empty($community) && $community->amAuthor()) {
            $label = $community->label;
            $community->delete();
            $session->messages->addMessage("La comunidad $label ha sido eliminada");
        } else {
            $session->messages->addMessage("La comunidad no puede ser eliminada");
        }

        $this->_redirect($this->view->currentPage());
    }
}
