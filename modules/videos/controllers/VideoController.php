<?php

class Videos_VideoController extends Yeah_Action
{
    public function viewAction() {
        $this->requirePermission('resources', 'view');
        $request = $this->getRequest();

        $url_video = $request->getParam('video');
        $model_videos = new Videos();
        $video = $model_videos->findByResource($url_video);
        $this->requireExistence($video, 'video', 'videos_video_view', 'frontpage_user');

        $model_resources = new Resources();
        $resource = $model_resources->findByIdent($video->resource);
        $this->requireContext($resource);

        $tags = $resource->findTagsViaTags_Resources();

        $this->view->resource = $resource;
        $this->view->video = $video;
        $this->view->tags = $tags;

        history('videos/' . $resource->ident);
        $breadcrumb = array();
        if ($this->acl('resources', 'new')) {
            $breadcrumb['Recursos'] = $this->view->url(array(), 'resources_list');
            $breadcrumb['Videos'] = $this->view->url(array('filter' => 'videos'), 'resources_filtered');
        }
        breadcrumb($breadcrumb);
    }

    public function editAction() {
        $this->requirePermission('resources', 'edit');
        $request = $this->getRequest();

        $model_resources = new Resources();
        $model_videos = new Videos();
        $model_tags = new Tags();
        $model_tags_resources = new Tags_Resources();

        $url_video = $request->getParam('video');
        $resource = $model_resources->findByIdent($url_video);
        $video = $model_videos->findByResource($url_video);

        $this->requireExistence($video, 'video', 'videos_video_view', 'frontpage_user');
        $this->requireResourceAuthor($resource);

        $_tags = array();
        $tags = $resource->findTagsViaTags_Resources();
        foreach ($tags as $tag) {
            $_tags[] = $tag->label;
        }

        if ($request->isPost()) {
            $session = new Zend_Session_Namespace();

            $video->proportion = $request->getParam('proportion');
            $video->description = $request->getParam('description');
            $newTags = $request->getParam('tags');

            if ($video->isValid()) {
                $video->save();

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
                            $assign = $model_tags_resources->createRow();
                            $assign->tag = $tag->ident;
                            $assign->resource = $resource->ident;
                            $assign->save();
                        }
                    }
                }
                foreach ($oldTags as $tagLabel) {
                    if ($tagLabel <> NULL) {
                        $tag = $model_tags->findByLabel($tagLabel);
                        $tag->weight = $tag->weight - 1;
                        $tag->save();

                        $assign = $model_tags_resources->findByTagAndResource($tag->ident, $resource->ident);
                        $assign->delete();

                        if ($tag->weight == 0) {
                            $tag->delete();
                        }
                    }
                }

                $session->messages->addMessage('La descripción y la proporción se modificaron correctamente');
                $session->url = $video->resource;
                $this->_redirect($this->view->url(array('video' => $video->resource), 'videos_video_view'));
            } else {
                foreach ($video->getMessages() as $message) {
                    $session->messages->addMessage($message);
                }
            }
        }

        $this->view->video = $video;
        $this->view->tags = implode(', ', $_tags);

        history('videos/' . $video->resource . '/edit');
        $breadcrumb = array();
        $breadcrumb['Recursos'] = $this->view->url(array(), 'resources_list');
        $breadcrumb['Videos'] = $this->view->url(array('filter' => 'videos'), 'resources_filtered');
        $breadcrumb['Video'] = $this->view->url(array('video' => $video->resource), 'videos_video_view');
        breadcrumb($breadcrumb);
    }

    public function deleteAction() {
        global $CONFIG;

        $this->requirePermission('resources', 'delete');
        $request = $this->getRequest();

        $model_resources = new Resources();
        $model_videos = new Videos();
        $model_valorations = new Valorations();
        $model_tags_resources = new Tags_Resources();

        $url_video = $request->getParam('video');
        $resource = $model_resources->findByIdent($url_video);
        $video = $model_videos->findByResource($url_video);

        $this->requireExistence($video, 'video', 'videos_video_view', 'frontpage_user');
        $this->requireResourceAuthor($resource);

        $tags = $resource->findTagsViaTags_Resources();
        foreach ($tags as $tag) {
            $tag->weight = $tag->weight - 1;
            $tag->save();

            $assign = $model_tags_resources->findByTagAndResource($tag->ident, $resource->ident);
            $assign->delete();

            if ($tag->weight == 0) {
                $tag->delete();
            }
        }

        unlink($CONFIG->dirroot . '/media/videos/' . $video->resource);

        $video->delete();
        $resource->delete();
        $model_valorations->decreaseActivity(2);

        $session = new Zend_Session_Namespace();
        $session->messages->addMessage('El video ha sido eliminado');
        $this->_redirect($this->view->currentPage());
    }

    // FIXME: Agregar mas infraestructura, evitar la eliminacion directa en lo posible, peligroso!
    public function dropAction() {
        global $CONFIG;

        $this->requirePermission('resources', 'drop');
        $request = $this->getRequest();

        $model_resources = new Resources();
        $model_videos = new Videos();
        $model_valorations = new Valorations();
        $model_tags_resources = new Tags_Resources();

        $url_video = $request->getParam('video');
        $resource = $model_resources->findByIdent($url_video);
        $video = $model_videos->findByResource($url_video);

        $this->requireExistence($video, 'video', 'videos_video_view', 'frontpage_user');

        $tags = $resource->findTagsViaTags_Resources();
        foreach ($tags as $tag) {
            $tag->weight = $tag->weight - 1;
            $tag->save();

            $assign = $model_tags_resources->findByTagAndResource($tag->ident, $resource->ident);
            $assign->delete();

            if ($tag->weight == 0) {
                $tag->delete();
            }
        }

        unlink($CONFIG->dirroot . '/media/videos/' . $video->resource);

        $video->delete();
        $resource->delete();
        $model_valorations->decreaseActivity(2, $resource->author);

        $session = new Zend_Session_Namespace();
        $session->messages->addMessage('El archivo ha sido eliminado');
        $this->_redirect($this->view->currentPage());
    }
}
