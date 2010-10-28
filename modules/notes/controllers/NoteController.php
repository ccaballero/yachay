<?php

class Notes_NoteController extends Yeah_Action
{
    public function viewAction() {
        $this->requirePermission('resources', 'view');
        $request = $this->getRequest();

        $note_url = $request->getParam('note');
        $notes_model = Yeah_Adapter::getModel('notes');
        $note = $notes_model->findByResource($note_url);
        $this->requireExistence($note, 'note', 'notes_note_view', 'frontpage_user');

        $resources_model = Yeah_Adapter::getModel('resources');
        $resource = $resources_model->findByIdent($note->resource);
        $this->requireContext($resource);

        $tags = $resource->findmodules_tags_models_TagsViamodules_tags_models_Tags_Resources();

        $this->view->resource = $resource;
        $this->view->note = $note;
        $this->view->tags = $tags;

        history('notes/' . $resource->ident);
        $breadcrumb = array();
        if (Yeah_Acl::hasPermission('resources', 'new')) {
            $breadcrumb['Recursos'] = $this->view->url(array(), 'resources_list');
            $breadcrumb['Notas'] = $this->view->url(array('filter' => 'notes'), 'resources_filtered');
        }
        breadcrumb($breadcrumb);
    }

    public function editAction() {
        $this->requirePermission('resources', 'edit');
        $request = $this->getRequest();

        $note_ident = $request->getParam('note');

        $resources_model = Yeah_Adapter::getModel('resources');
        $notes_model = Yeah_Adapter::getModel('notes');
        $tags_model = Yeah_Adapter::getModel('tags');
        $tags_resources_model = Yeah_Adapter::getModel('tags', 'Tags_Resources');

        $resource = $resources_model->findByIdent($note_ident);
        $note = $notes_model->findByResource($note_ident);

        $this->requireExistence($note, 'note', 'notes_note_view', 'frontpage_user');
        $this->requireResourceAuthor($resource);

        $_tags = array();
        $tags = $resource->findmodules_tags_models_TagsViamodules_tags_models_Tags_Resources();
        foreach ($tags as $tag) {
            $_tags[] = $tag->label;
        }

        if ($request->isPost()) {
            $session = new Zend_Session_Namespace();
            $note->note = $request->getParam('message');
            $newTags = $request->getParam('tags');
            $priority = $request->getParam('priority');
            if (empty($priority)) {
                $note->priority = false;
            } else {
                $note->priority = true;
            }

            if ($note->isValid()) {
                $note->save();

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
                        $tag = $tags_model->findByLabel($tagLabel);
                        if ($tag == NULL) {
                            $tag = $tags_model->createRow();
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
                            $assign = $tags_resources_model->createRow();
                            $assign->tag = $tag->ident;
                            $assign->resource = $resource->ident;
                            $assign->save();
                        }
                    }
                }
                foreach ($oldTags as $tagLabel) {
                    if ($tagLabel <> NULL) {
                        $tag = $tags_model->findByLabel($tagLabel);
                        $tag->weight = $tag->weight - 1;
                        $tag->save();

                        $assign = $tags_resources_model->findByTagAndResource($tag->ident, $resource->ident);
                        $assign->delete();

                        if ($tag->weight == 0) {
                            $tag->delete();
                        }
                    }
                }

                $session->messages->addMessage('La nota se modifico correctamente');
                $session->url = $note->resource;
                $this->_redirect($request->getParam('return'));
            } else {
                foreach ($note->getMessages() as $message) {
                    $session->messages->addMessage($message);
                }
            }
        }

        $this->view->note = $note;
        $this->view->tags = implode(', ', $_tags);

        history('notes/' . $note->resource . '/edit');
        $breadcrumb = array();
        $breadcrumb['Recursos'] = $this->view->url(array(), 'resources_list');
        $breadcrumb['Notas'] = $this->view->url(array('filter' => 'notes'), 'resources_filtered');
        $breadcrumb['Nota'] = $this->view->url(array('note' => $note->resource), 'notes_note_view');
        breadcrumb($breadcrumb);
    }

    public function deleteAction() {
        $this->requirePermission('resources', 'delete');
        $request = $this->getRequest();

        $note_ident = $request->getParam('note');

        $resources_model = Yeah_Adapter::getModel('resources');
        $notes_model = Yeah_Adapter::getModel('notes');
        $valorations_model = Yeah_Adapter::getModel('valorations');
        $tags_resources_model = Yeah_Adapter::getModel('tags', 'Tags_Resources');

        $resource = $resources_model->findByIdent($note_ident);
        $note = $notes_model->findByResource($note_ident);

        $this->requireExistence($note, 'note', 'notes_note_view', 'frontpage_user');
        $this->requireResourceAuthor($resource);

        $tags = $resource->findmodules_tags_models_TagsViamodules_tags_models_Tags_Resources();
        foreach ($tags as $tag) {
            $tag->weight = $tag->weight - 1;
            $tag->save();

            $assign = $tags_resources_model->findByTagAndResource($tag->ident, $resource->ident);
            $assign->delete();

            if ($tag->weight == 0) {
                $tag->delete();
            }
        }

        $note->delete();
        $resource->delete();
        $valorations_model->decreaseActivity(1);

        $session = new Zend_Session_Namespace();
        $session->messages->addMessage("La nota ha sido eliminada");
        $this->_redirect($this->view->currentPage());
    }

    // FIXME: Agregar mas infraestructura, evitar la eliminacion directa en lo posible, peligroso!
    public function dropAction() {
        $this->requirePermission('resources', 'drop');
        $request = $this->getRequest();

        $note_ident = $request->getParam('note');

        $resources_model = Yeah_Adapter::getModel('resources');
        $notes_model = Yeah_Adapter::getModel('notes');
        $valorations_model = Yeah_Adapter::getModel('valorations');
        $tags_resources_model = Yeah_Adapter::getModel('tags', 'Tags_Resources');

        $resource = $resources_model->findByIdent($note_ident);
        $note = $notes_model->findByResource($note_ident);

        $this->requireExistence($note, 'note', 'notes_note_view', 'frontpage_user');

        $tags = $resource->findmodules_tags_models_TagsViamodules_tags_models_Tags_Resources();
        foreach ($tags as $tag) {
            $tag->weight = $tag->weight - 1;
            $tag->save();

            $assign = $tags_resources_model->findByTagAndResource($tag->ident, $resource->ident);
            $assign->delete();

            if ($tag->weight == 0) {
                $tag->delete();
            }
        }

        $note->delete();
        $resource->delete();
        $valorations_model->decreaseActivity(1, $resource->author);

        $session = new Zend_Session_Namespace();
        $session->messages->addMessage("La nota ha sido eliminada");
        $this->_redirect($this->view->currentPage());
    }
}
