<?php

class Notes_NoteController extends Yachay_Controller_Action
{
    public function viewAction() {
        $this->requirePermission('resources', 'view');
        $request = $this->getRequest();

        $url_note = $request->getParam('note');
        $model_notes = new Notes();
        $note = $model_notes->findByResource($url_note);
        $this->requireExistence($note, 'note', 'notes_note_view', 'base_user');

        $model_resources = new Resources();
        $resource = $model_resources->findByIdent($note->resource);
//        $this->requireContext($resource);

        $resource->viewers = $resource->viewers + 1;
        $resource->save();

        $tags = $resource->findTagsViaTags_Resources();

        $this->view->resource = $resource;
        $this->view->note = $note;
        $this->view->tags = $tags;

        $this->history('notes/' . $resource->ident);
        $breadcrumb = array();
        if ($this->acl('resources', 'new')) {
            $breadcrumb['Recursos'] = $this->view->url(array(), 'resources_list');
            $breadcrumb['Notas'] = $this->view->url(array('filter' => 'notes'), 'resources_filtered');
        }
        $this->breadcrumb($breadcrumb);
    }

    public function editAction() {
        $this->requirePermission('resources', 'edit');
        $request = $this->getRequest();

        $model_resources = new Resources();
        $model_notes = new Notes();
        $model_tags = new Tags();

        $url_note = $request->getParam('note');
        $resource = $model_resources->findByIdent($url_note);
        $note = $model_notes->findByResource($url_note);

        $this->requireExistence($note, 'note', 'notes_note_view', 'base_user');
        $this->requireResourceAuthor($resource);

        $_tags = array();
        $tags = $resource->findTagsViaTags_Resources();
        foreach ($tags as $tag) {
            $_tags[] = $tag->label;
        }

        if ($request->isPost()) {
            $session = new Zend_Session_Namespace('yachay');
            $note->note = $request->getParam('message');
            $priority = $request->getParam('priority');
            if (empty($priority)) {
                $note->priority = false;
            } else {
                $note->priority = true;
            }

            if ($note->isValid()) {
                // re-tagging
                $model_tags->tagging_resource($_tags, $request->getParam('tags'), $resource);

                $note->save();
                $session->url = $note->resource;

                $this->_helper->flashMessenger->addMessage('La nota se modifico correctamente');
                $this->_redirect($this->view->url(array('note' => $note->resource), 'notes_note_view'));
            } else {
                foreach ($note->getMessages() as $message) {
                    $this->_helper->flashMessenger->addMessage($message);
                }
            }
        } else {
            $this->history('notes/' . $note->resource . '/edit');
        }

        $this->view->note = $note;
        $this->view->tags = implode(', ', $_tags);

        $breadcrumb = array();
        $breadcrumb['Recursos'] = $this->view->url(array(), 'resources_list');
        $breadcrumb['Notas'] = $this->view->url(array('filter' => 'notes'), 'resources_filtered');
        $breadcrumb['Nota'] = $this->view->url(array('note' => $note->resource), 'notes_note_view');
        $this->breadcrumb($breadcrumb);
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

        $this->requireExistence($note, 'note', 'notes_note_view', 'base_user');
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

        $this->_helper->flashMessenger->addMessage('La nota ha sido eliminada');
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

        $this->requireExistence($note, 'note', 'notes_note_view', 'base_user');

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

        $this->_helper->flashMessenger->addMessage('La nota ha sido eliminada');
        $this->_redirect($this->view->currentPage());
    }
}
