<?php

class Notes_ManagerController extends Yeah_Action
{
    public $_ignoreContextDefault = true;

    public function newAction() {
        global $USER;

        $this->requirePermission('resources', array('new', 'view'));
        $request = $this->getRequest();

        $note = new Notes_Empty();

        $model_notes = new Notes();
        $model_resources = new Resources();
        $model_valorations = new Valorations();
        $model_tags = new Tags();
        $model_tags_resources = new Tags_Resources();

        if ($request->isPost()) {
            $session = new Zend_Session_Namespace();

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

            $context = new Yeah_Helpers_Context();
            $spaces_valids = $context->context(NULL, 'plain');

            if (in_array($publish, $spaces_valids)) {
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

                    $session->messages->addMessage('La nota ha sido creada');
                    $session->url = $note->resource;
                    $this->_redirect($request->getParam('return'));
                } else {
                    foreach ($note->getMessages() as $message) {
                        $session->messages->addMessage($message);
                    }
                }
            } else {
                $session->messages->addMessage("Usted no tiene privilegios para publicar en ese espacio");
            }
        }

        $this->view->note = $note;

        history('notes/new');
        $breadcrumb = array();
        $breadcrumb['Recursos'] = $this->view->url(array(), 'resources_list');
        $breadcrumb['Notas'] = $this->view->url(array('filter' => 'notes'), 'resources_filtered');
        breadcrumb($breadcrumb);
    }
}
