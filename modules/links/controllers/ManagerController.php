<?php

class Links_ManagerController extends Yeah_Action
{
    public $_ignoreContextDefault = true;

    public function newAction() {
        global $USER;

        $this->requirePermission('resources', array('new', 'view'));
        $request = $this->getRequest();

        $link = new Links_Empty();
        $tags = '';

        $model_links = new Links();
        $model_resources = new Resources();
        $model_valorations = new Valorations();
        $model_tags = new Tags();
        $model_tags_resources = new Tags_Resources();

        if ($request->isPost()) {
            $session = new Zend_Session_Namespace();

            $link = $model_links->createRow();
            $link->link = $request->getParam('link');
            $link->description = $request->getParam('description');
            $publish = $request->getParam('publish');
            $tags = $request->getParam('tags');
            $priority = $request->getParam('priority');
            if (empty($priority)) {
                $link->priority = false;
            } else {
                $link->priority = true;
            }

            $context = new Yeah_Helpers_Context();
            $spaces_valids = $context->context(NULL, 'plain');

            if (empty($publish)) {
                $session->messages->addMessage('Usted debe seleccionar un espacio de publicación');
            } else if (in_array($publish, $spaces_valids)) {
                if ($link->isValid()) {
                    $resource = $model_resources->createRow();
                    $resource->author = $USER->ident;
                    $resource->recipient = $publish;
                    $resource->tsregister = time();
                    $resource->save();

                    $link->resource = $resource->ident;
                    $link->save();

                    $resource->saveContext($request);
                    $model_valorations->addActivity(1);

                    // TAG REGISTER
                    $tags = explode(',', $tags);
                    $saved_tags = array();

                    foreach ($tags as $tagLabel) {
                        $tagLabel = trim(strtolower($tagLabel));

                        if (!in_array($tagLabel, $saved_tags)) {
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

                            $saved_tags[] = $tagLabel;
                        }
                    }

                    $session->messages->addMessage('El enlace ha sido registrado');
                    $session->url = $link->resource;
                    $this->_redirect($request->getParam('return'));
                } else {
                    foreach ($link->getMessages() as $message) {
                        $session->messages->addMessage($message);
                    }
                }
            } else {
                $session->messages->addMessage('Usted no tiene privilegios para publicar en ese espacio');
            }
        }

        $this->view->link = $link;
        $this->view->tags = $tags;

        history('links/new');
        $breadcrumb = array();
        $breadcrumb['Recursos'] = $this->view->url(array(), 'resources_list');
        $breadcrumb['Enlaces'] = $this->view->url(array('filter' => 'links'), 'resources_filtered');
        breadcrumb($breadcrumb);
    }
}
