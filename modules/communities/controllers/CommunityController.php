<?php

class Communities_CommunityController extends Yeah_Action
{
    public function viewAction() {
        global $USER;

        $this->requirePermission('communities', 'view');

        $request = $this->getRequest();
        $model_communities = new Communities();
        $community = $model_communities->findByUrl($request->getParam('community'));
        $this->requireExistence($community, 'community', 'communities_community_view', 'communities_list');

        context('community', $community);

        $resources = $community->findResourcesViaCommunities_Resources($community->select()->order('tsregister DESC'));

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
        if ($this->acl('communities', 'list')) {
            $breadcrumb['Comunidades'] = $this->view->url(array(), 'communities_list');
        }
        if ($this->acl('communities', 'enter')) {
            $breadcrumb['Administrador de comunidades'] = $this->view->url(array(), 'communities_manager');
        }
        breadcrumb($breadcrumb);
    }

    public function editAction() {
        $this->requirePermission('communities', 'enter');
        $request = $this->getRequest();

        $model_communities = new Communities();
        $model_tags = new Tags();
        $model_tags_communities = new Tags_Communities();

        $community = $model_communities->findByUrl($request->getParam('community'));
        $this->requireExistence($community, 'community', 'communities_community_view', 'community_list');

        context('community', $community);

        $_tags = array();
        $tags = $community->findTagsViaTags_Communities();
        foreach ($tags as $tag) {
            $_tags[] = $tag->label;
        }

        if ($request->isPost()) {
            $session = new Zend_Session_Namespace();

            $community->label = $request->getParam('label');
            $community->url = convert($community->label);
            $community->mode = $request->getParam('mode');
            $newTags = $request->getParam('tags');
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
                        case 'jpeg':
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
                } else {
                    $session->messages->addMessage('Debe escoger un archivo valido para poder interpretarlo adecuadamente');
                }
                $community->save();

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
                            $assign = $model_tags_communities->createRow();
                            $assign->tag = $tag->ident;
                            $assign->community = $community->ident;
                            $assign->save();
                        }
                    }
                }
                foreach ($oldTags as $tagLabel) {
                    if ($tagLabel <> NULL) {
                        $tag = $model_tags->findByLabel($tagLabel);
                        $tag->weight = $tag->weight - 1;
                        $tag->save();

                        $assign = $model_tags_communities->findByTagAndCommunity($tag->ident, $community->ident);
                        $assign->delete();

                        if ($tag->weight == 0) {
                            $tag->delete();
                        }
                    }
                }

                $session->messages->addMessage("La comunidad {$community->label} se ha actualizado correctamente");
                $session->url = $community->url;
                $this->_redirect($request->getParam('return'));
            } else {
                foreach ($area->getMessages() as $message) {
                    $session->messages->addMessage($message);
                }
            }
        }

        $this->view->model_communities = $model_communities;
        $this->view->community = $community;
        $this->view->tags = implode(', ', $_tags);

        history('community/' . $community->url . '/edit');
        $breadcrumb = array();
        if ($this->acl('communities', 'list')) {
            $breadcrumb['Comunidades'] = $this->view->url(array(), 'communities_list');
        }
        if ($this->acl('communities', array('enter'))) {
            $breadcrumb['Administrador de comunidades'] = $this->view->url(array(), 'communities_manager');
        }
        if ($this->acl('communities', 'view')) {
            $breadcrumb[$community->label] = $this->view->url(array('community' => $community->url), 'communities_community_view');
        }
        breadcrumb($breadcrumb);
    }

    public function deleteAction() {
        $this->requirePermission('communities', 'enter');
        $request = $this->getRequest();

        $model_communities = new Communities();
        $model_communities_users = new Communities_Users();
        $model_communities_petitions = new Communities_Petitions();
        $model_tags_communities = new Tags_Communities();

        $url = $request->getParam('community');
        $community = $model_communities->findByUrl($url);

        $session = new Zend_Session_Namespace();
        if (!empty($community) && $community->amAuthor()) {
            $label = $community->label;
            $model_communities_users->deleteUsersInCommunity($community->ident);
            if ($community->mode == 'close') {
                $model_communities_petitions->deleteAplicantsInCommunity($community->ident);
            }

            $tags = $community->findTagsViaTags_Communities();
            foreach ($tags as $tag) {
                $tag->weight = $tag->weight - 1;
                $tag->save();

                $assign = $model_tags_communities->findByTagAndCommunity($tag->ident, $community->ident);
                $assign->delete();

                if ($tag->weight == 0) {
                    $tag->delete();
                }
            }

            $community->delete();
            $session->messages->addMessage("La comunidad $label ha sido eliminada");
        } else {
            $session->messages->addMessage("La comunidad no puede ser eliminada");
        }

        $this->_redirect($this->view->currentPage());
    }
}
