<?php

class Notes_ManagerController extends Yachay_Action
{
    public $_ignoreContextDefault = true;

    public function newAction() {
        global $USER;

        $this->requirePermission('resources', array('new', 'view'));
        $request = $this->getRequest();

        $note = new Notes_Empty();
        $tags = '';

        $model_notes = new Notes();
        $model_resources = new Resources();
        $model_valorations = new Valorations();
        $model_tags = new Tags();

        if ($request->isPost()) {
            $session = new Zend_Session_Namespace('yachay');

            $note = $model_notes->createRow();
            $note->note = $request->getParam('message');
            $publish = $request->getParam('publish');
            $tags = $request->getParam('tags');
            $priority = $request->getParam('priority');
            if (empty($priority)) {
                $note->priority = false;
            } else {
                $note->priority = true;
            }

            $context = new Yachay_Helpers_Context();
            $spaces_valids = $context->context(NULL, 'plain');

            if (empty($publish)) {
                $this->_helper->flashMessenger->addMessage('Usted debe seleccionar un espacio de publicación');
            } else if (in_array($publish, $spaces_valids)) {
                if ($note->isValid()) {
                    $resource = $model_resources->createRow();
                    $resource->author = $USER->ident;
                    $resource->recipient = $publish;
                    $resource->tsregister = time();
                    $resource->save();

                    $note->resource = $resource->ident;
                    $note->save();

                    $resource->saveContext($request);
                    $model_valorations->addActivity(1);

                    // tagging
                    $model_tags->tagging_resource(array(), $tags, $resource);

                    $session->url = $note->resource;

                    $this->_helper->flashMessenger->addMessage('La nota ha sido creada');
                    $this->_redirect($request->getParam('return'));
                } else {
                    foreach ($note->getMessages() as $message) {
                        $this->_helper->flashMessenger->addMessage($message);
                    }
                }
            } else {
                $this->_helper->flashMessenger->addMessage('Usted no tiene privilegios para publicar en ese espacio');
            }
        }

        $this->view->note = $note;
        $this->view->tags = $tags;

        $this->history('notes/new');
        $breadcrumb = array();
        $breadcrumb['Recursos'] = $this->view->url(array(), 'resources_list');
        $breadcrumb['Notas'] = $this->view->url(array('filter' => 'notes'), 'resources_filtered');
        breadcrumb($breadcrumb);
    }
}
