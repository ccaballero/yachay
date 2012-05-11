<?php

class Links_ManagerController extends Yachay_Controller_Action
{
    public $_ignoreContextDefault = true;

    public function newAction() {
        $this->requirePermission('resources', array('new', 'view'));
        $request = $this->getRequest();

        $link = new Links_Empty();
        $tags = '';

        $model_links = new Links();
        $model_resources = new Resources();
        $model_valorations = new Valorations();
        $model_tags = new Tags();

        if ($request->isPost()) {
            $session = new Zend_Session_Namespace('yachay');

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

            $context = new Yachay_Helpers_Context();
            $spaces_valids = $context->context(NULL, 'plain');

            if (empty($publish)) {
                $this->_helper->flashMessenger->addMessage('Usted debe seleccionar un espacio de publicación');
            } else if (in_array($publish, $spaces_valids)) {
                if ($link->isValid()) {
                    $resource = $model_resources->createRow();
                    $resource->author = $this->user->ident;
                    $resource->recipient = $publish;
                    $resource->tsregister = time();
                    $resource->save();

                    $link->resource = $resource->ident;
                    $link->save();

                    $resource->saveContext($request);
                    $model_valorations->addActivity(1);

                    // tagging
                    $model_tags->tagging_resource(array(), $tags, $resource);

                    $session->url = $link->resource;

                    $this->_helper->flashMessenger->addMessage('El enlace ha sido registrado');
                    $this->_redirect($request->getParam('return'));
                } else {
                    foreach ($link->getMessages() as $message) {
                        $this->_helper->flashMessenger->addMessage($message);
                    }
                }
            } else {
                $this->_helper->flashMessenger->addMessage('Usted no tiene privilegios para publicar en ese espacio');
            }
        } else {
            $this->history('links/new');
        }

        $this->view->link = $link;
        $this->view->tags = $tags;

        $breadcrumb = array();
        $breadcrumb['Recursos'] = $this->view->url(array(), 'resources_list');
        $breadcrumb['Enlaces'] = $this->view->url(array('filter' => 'links'), 'resources_filtered');
        $this->breadcrumb($breadcrumb);
    }
}
