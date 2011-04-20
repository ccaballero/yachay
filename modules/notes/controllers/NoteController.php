<?php

class Notes_NoteController extends Yeah_Action
{
    public function viewAction() {
        $this->requirePermission('resources', 'view');
        $request = $this->getRequest();

        $url_note = $request->getParam('note');
        $model_notes = new Notes();
        $note = $model_notes->findByResource($url_note);
        $this->requireExistence($note, 'note', 'notes_note_view', 'frontpage_user');

        $model_resources = new Resources();
        $resource = $model_resources->findByIdent($note->resource);
        $this->requireContext($resource);

        $resource->viewers = $resource->viewers + 1;
        $resource->save();

        $tags = $resource->findTagsViaTags_Resources();

        $this->view->resource = $resource;
        $this->view->note = $note;
        $this->view->tags = $tags;

        history('notes/' . $resource->ident);
        $breadcrumb = array();
        if ($this->acl('resources', 'new')) {
            $breadcrumb['Recursos'] = $this->view->url(array(), 'resources_list');
            $breadcrumb['Notas'] = $this->view->url(array('filter' => 'notes'), 'resources_filtered');
        }
        breadcrumb($breadcrumb);
    }

    public function editAction() {
        $this->requirePermission('resources', 'edit');
        $request = $this->getRequest();

        $model_resources = new Resources();
        $model_notes = new Notes();
        $model_tags = new Tags();
        $model_tags_resources = new Tags_Resources();

        $url_note = $request->getParam('note');
        $resource = $model_resources->findByIdent($url_note);
        $note = $model_notes->findByResource($url_note);

        $this->requireExistence($note, 'note', 'notes_note_view', 'frontpage_user');
        $this->requireResourceAuthor($resource);

        $_tags = array();
        $tags = $resource->findTagsViaTags_Resources();
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

        $model_resources = new Resources();
        $model_notes = new Notes();
        $model_valorations = new Valorations();
        $model_tags_resources = new Tags_Resources();

        $url_note = $request->getParam('note');
        $resource = $model_resources->findByIdent($url_note);
        $note = $model_notes->findByResource($url_note);

        $this->requireExistence($note, 'note', 'notes_note_view', 'frontpage_user');
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

        $note->delete();
        $resource->delete();
        $model_valorations->decreaseActivity(1);

        $session = new Zend_Session_Namespace();
        $session->messages->addMessage("La nota ha sido eliminada");
        $this->_redirect($this->view->currentPage());
    }

    // FIXME: Agregar mas infraestructura, evitar la eliminacion directa en lo posible, peligroso!
    public function dropAction() {
        $this->requirePermission('resources', 'drop');
        $request = $this->getRequest();

        $model_resources = new Resources();
        $model_notes = new Notes();
        $model_valorations = new Valorations();
        $model_tags_resources = new Tags_Resources();

        $url_note = $request->getParam('note');
        $resource = $model_resources->findByIdent($url_note);
        $note = $model_notes->findByResource($url_note);

        $this->requireExistence($note, 'note', 'notes_note_view', 'frontpage_user');

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

        $note->delete();
        $resource->delete();
        $model_valorations->decreaseActivity(1, $resource->author);

        $session = new Zend_Session_Namespace();
        $session->messages->addMessage("La nota ha sido eliminada");
        $this->_redirect($this->view->currentPage());
    }
}
