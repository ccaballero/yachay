<?php

class Feedback_EntryController extends Yachay_Controller_Action
{
    public function viewAction() {
        $this->requirePermission('resources', 'view');
        $this->requirePermission('feedback', 'list');
        $request = $this->getRequest();

        $url_entry = $request->getParam('entry');
        $model_feedback = new Feedback();
        $entry = $model_feedback->findByResource($url_entry);
        $this->requireExistence($entry, 'entry', 'feedback_entry_view', 'base_user');

        $model_resources = new Resources();
        $resource = $model_resources->findByIdent($entry->resource);
        $this->requireContext($resource);

        $resource->viewers = $resource->viewers + 1;
        $resource->save();

        $tags = $resource->findTagsViaTags_Resources();

        $this->view->resource = $resource;
        $this->view->entry = $entry;
        $this->view->tags = $tags;

        $this->history('feedback/' . $resource->ident);
        $breadcrumb = array();
        if ($this->acl('resources', 'new')) {
            $breadcrumb['Recursos'] = $this->view->url(array(), 'resources_list');
            $breadcrumb['Sugerencias'] = $this->view->url(array('filter' => 'feedback'), 'resources_filtered');
        }
        $this->breadcrumb($breadcrumb);
    }

    public function editAction() {
        $this->requirePermission('resources', 'edit');
        $this->requirePermission('feedback', 'list');
        $request = $this->getRequest();

        $model_resources = new Resources();
        $model_feedback = new Feedback();
        $model_tags = new Tags();

        $url_entry = $request->getParam('entry');
        $resource = $model_resources->findByIdent($url_entry);
        $entry = $model_feedback->findByResource($url_entry);

        $this->requireExistence($entry, 'entry', 'feedback_entry_view', 'base_user');
        $this->requireResourceAuthor($resource);

        $_tags = array();
        $tags = $resource->findTagsViaTags_Resources();
        foreach ($tags as $tag) {
            $_tags[] = $tag->label;
        }

        if ($request->isPost()) {
            $session = new Zend_Session_Namespace('yachay');
            $entry->description = $request->getParam('description');

            if ($entry->isValid()) {
                // re-tagging
                $model_tags->tagging_resource($_tags, $request->getParam('tags'), $resource);

                $entry->save();
                $session->url = $entry->resource;

                $this->_helper->flashMessenger->addMessage('La sugerencia se modifico correctamente');
                $this->_redirect($this->view->url(array('entry' => $entry->resource), 'feedback_entry_view'));
            } else {
                foreach ($entry->getMessages() as $message) {
                    $this->_helper->flashMessenger->addMessage($message);
                }
            }
        } else {
            $this->history('feedback/' . $entry->resource . '/edit');
        }

        $this->view->entry = $entry;
        $this->view->tags = implode(', ', $_tags);

        $breadcrumb = array();
        $breadcrumb['Recursos'] = $this->view->url(array(), 'resources_list');
        $breadcrumb['Sugerencias'] = $this->view->url(array('filter' => 'feedback'), 'resources_filtered');
        $breadcrumb['Entrada'] = $this->view->url(array('entry' => $entry->resource), 'feedback_entry_view');
        $this->breadcrumb($breadcrumb);
    }

    public function markAction() {
        $this->requirePermission('feedback', 'mark');
        $request = $this->getRequest();

        $url_entry = $request->getParam('entry');
        $model_feedback = new Feedback();
        $entry = $model_feedback->findByResource($url_entry);

        $this->requireExistence($entry, 'entry', 'feedback_entry_view', 'base_user');

        $entry->mark = true;
        $entry->save();

        $this->_helper->flashMessenger->addMessage('La sugerencia ha sido marcada como favorita');
        $this->_redirect($this->view->currentPage());
    }

    public function unmarkAction() {
        $this->requirePermission('feedback', 'mark');
        $request = $this->getRequest();

        $url_entry = $request->getParam('entry');
        $model_feedback = new Feedback();
        $entry = $model_feedback->findByResource($url_entry);

        $this->requireExistence($entry, 'entry', 'feedback_entry_view', 'base_user');

        $entry->mark = false;
        $entry->save();

        $this->_helper->flashMessenger->addMessage('La sugerencia ha sido desmarcada como favorita');
        $this->_redirect($this->view->currentPage());
    }

    public function resolvAction() {
        $this->requirePermission('feedback', 'mark');
        $request = $this->getRequest();

        $url_entry = $request->getParam('entry');
        $model_feedback = new Feedback();
        $entry = $model_feedback->findByResource($url_entry);

        $this->requireExistence($entry, 'entry', 'feedback_entry_view', 'base_user');

        $entry->resolved = true;
        $entry->save();

        $this->_helper->flashMessenger->addMessage('La sugerencia ha sido marcada como resuelta');
        $this->_redirect($this->view->currentPage());
    }

    public function unresolvAction() {
        $this->requirePermission('feedback', 'mark');
        $request = $this->getRequest();

        $url_entry = $request->getParam('entry');
        $model_feedback = new Feedback();
        $entry = $model_feedback->findByResource($url_entry);

        $this->requireExistence($entry, 'entry', 'feedback_entry_view', 'base_user');

        $entry->resolved = false;
        $entry->save();

        $this->_helper->flashMessenger->addMessage('La sugerencia ha sido desmarcada como resuelta');
        $this->_redirect($this->view->currentPage());
    }

    public function deleteAction() {
        $this->requirePermission('resources', 'delete');
        $this->requirePermission('feedback', 'list');
        $request = $this->getRequest();

        $url_entry = $request->getParam('entry');

        $model_resources = new Resources();
        $model_feedback = new Feedback();
        $model_tags_resources = new Tags_Resources();

        $resource = $model_resources->findByIdent($url_entry);
        $entry = $model_feedback->findByResource($url_entry);

        $this->requireExistence($entry, 'entry', 'feedback_entry_view', 'base_user');
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

        $entry->delete();
        $resource->delete();

        $this->_helper->flashMessenger->addMessage('La sugerencia ha sido eliminada');
        $this->_redirect($this->view->currentPage());
    }

    // FIXME: Agregar mas infraestructura, evitar la eliminacion directa en lo posible, peligroso!
    public function dropAction() {
        $this->requirePermission('feedback', 'delete');
        $request = $this->getRequest();

        $url_entry = $request->getParam('entry');

        $model_resources = new Resources();
        $model_feedback = new Feedback();
        $model_tags_resources = new Tags_Resources();

        $resource = $model_resources->findByIdent($url_entry);
        $entry = $model_feedback->findByResource($url_entry);

        $this->requireExistence($entry, 'entry', 'feedback_entry_view', 'base_user');

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

        $entry->delete();
        $resource->delete();

        $this->_helper->flashMessenger->addMessage('La sugerencia ha sido eliminada');
        $this->_redirect($this->view->currentPage());
    }
}
