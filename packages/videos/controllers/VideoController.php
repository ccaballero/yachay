<?php

class Videos_VideoController extends Yachay_Controller_Action
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

        $resource->viewers = $resource->viewers + 1;
        $resource->save();

        $tags = $resource->findTagsViaTags_Resources();

        $this->view->resource = $resource;
        $this->view->video = $video;
        $this->view->tags = $tags;

        $this->history('videos/' . $resource->ident);
        $breadcrumb = array();
        if ($this->acl('resources', 'new')) {
            $breadcrumb['Recursos'] = $this->view->url(array(), 'resources_list');
            $breadcrumb['Videos'] = $this->view->url(array('filter' => 'videos'), 'resources_filtered');
        }
        $this->breadcrumb($breadcrumb);
    }

    public function editAction() {
        $this->requirePermission('resources', 'edit');
        $request = $this->getRequest();

        $model_resources = new Resources();
        $model_videos = new Videos();
        $model_tags = new Tags();

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
            $session = new Zend_Session_Namespace('yachay');

            $video->proportion = $request->getParam('proportion');
            $video->description = $request->getParam('description');

            if ($video->isValid()) {
                // re-tagging
                $model_tags->tagging_resource($_tags, $request->getParam('tags'), $resource);

                $video->save();
                $session->url = $video->resource;

                $this->_helper->flashMessenger->addMessage('Las propiedades se modificaron correctamente');
                $this->_redirect($this->view->url(array('video' => $video->resource), 'videos_video_view'));
            } else {
                foreach ($video->getMessages() as $message) {
                    $this->_helper->flashMessenger->addMessage($message);
                }
            }
        } else {
            $this->history('videos/' . $video->resource . '/edit');
        }

        $this->view->video = $video;
        $this->view->tags = implode(', ', $_tags);

        $breadcrumb = array();
        $breadcrumb['Recursos'] = $this->view->url(array(), 'resources_list');
        $breadcrumb['Videos'] = $this->view->url(array('filter' => 'videos'), 'resources_filtered');
        $breadcrumb['Video'] = $this->view->url(array('video' => $video->resource), 'videos_video_view');
        $this->breadcrumb($breadcrumb);
    }

    public function deleteAction() {
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

        unlink(APPLICATION_PATH . '/public/media/videos/' . $video->resource);

        $video->delete();
        $resource->delete();
        $model_valorations->decreaseActivity(2);

        $this->_helper->flashMessenger->addMessage('El video ha sido eliminado');
        $this->_redirect($this->view->currentPage());
    }

    // FIXME: Agregar mas infraestructura, evitar la eliminacion directa en lo posible, peligroso!
    public function dropAction() {
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

        unlink(APPLICATION_PATH . '/public/media/videos/' . $video->resource);

        $video->delete();
        $resource->delete();
        $model_valorations->decreaseActivity(2, $resource->author);

        $this->_helper->flashMessenger->addMessage('El archivo ha sido eliminado');
        $this->_redirect($this->view->currentPage());
    }
}
