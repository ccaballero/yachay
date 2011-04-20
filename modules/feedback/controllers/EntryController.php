<?php

class Feedback_EntryController extends Yeah_Action
{
    public function viewAction() {
        $this->requirePermission('resources', 'view');
        $this->requirePermission('feedback', 'list');
        $request = $this->getRequest();

        $url_entry = $request->getParam('entry');
        $model_feedback = new Feedback();
        $entry = $model_feedback->findByResource($url_entry);
        $this->requireExistence($entry, 'entry', 'feedback_entry_view', 'frontpage_user');

        $model_resources = new Resources();
        $resource = $model_resources->findByIdent($entry->resource);
        $this->requireContext($resource);

        $resource->viewers = $resource->viewers + 1;
        $resource->save();

        $tags = $resource->findTagsViaTags_Resources();

        $this->view->resource = $resource;
        $this->view->entry = $entry;
        $this->view->tags = $tags;

        history('feedback/' . $resource->ident);
        $breadcrumb = array();
        if ($this->acl('resources', 'new')) {
            $breadcrumb['Recursos'] = $this->view->url(array(), 'resources_list');
            $breadcrumb['Sugerencias'] = $this->view->url(array('filter' => 'feedback'), 'resources_filtered');
        }
        breadcrumb($breadcrumb);
    }

    public function editAction() {
        $this->requirePermission('resources', 'edit');
        $this->requirePermission('feedback', 'list');
        $request = $this->getRequest();

        $model_resources = new Resources();
        $model_feedback = new Feedback();
        $model_tags = new Tags();
        $model_tags_resources = new Tags_Resources();

        $url_entry = $request->getParam('entry');
        $resource = $model_resources->findByIdent($url_entry);
        $entry = $model_feedback->findByResource($url_entry);

        $this->requireExistence($entry, 'entry', 'feedback_entry_view', 'frontpage_user');
        $this->requireResourceAuthor($resource);

        $_tags = array();
        $tags = $resource->findTagsViaTags_Resources();
        foreach ($tags as $tag) {
            $_tags[] = $tag->label;
        }

        if ($request->isPost()) {
            $session = new Zend_Session_Namespace();
            $entry->description = $request->getParam('description');
            $newTags = $request->getParam('tags');

            if ($entry->isValid()) {
                $entry->save();

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

                $session->messages->addMessage('La sugerencia se modifico correctamente');
                $session->url = $entry->resource;
                $this->_redirect($request->getParam('return'));
            } else {
                foreach ($entry->getMessages() as $message) {
                    $session->messages->addMessage($message);
                }
            }
        }

        $this->view->entry = $entry;
        $this->view->tags = implode(', ', $_tags);

        history('feedback/' . $entry->resource . '/edit');
        $breadcrumb = array();
        $breadcrumb['Recursos'] = $this->view->url(array(), 'resources_list');
        $breadcrumb['Sugerencias'] = $this->view->url(array('filter' => 'feedback'), 'resources_filtered');
        $breadcrumb['Entrada'] = $this->view->url(array('entry' => $entry->resource), 'feedback_entry_view');
        breadcrumb($breadcrumb);
    }

    public function markAction() {
        $this->requirePermission('feedback', 'mark');
        $request = $this->getRequest();

        $url_entry = $request->getParam('entry');
        $model_feedback = new Feedback();
        $entry = $model_feedback->findByResource($url_entry);

        $this->requireExistence($entry, 'entry', 'feedback_entry_view', 'frontpage_user');

        $entry->mark = true;
        $entry->save();

        $session = new Zend_Session_Namespace();
        $session->messages->addMessage("La sugerencia ha sido marcada como favorita");
        $this->_redirect($this->view->currentPage());
    }

    public function unmarkAction() {
        $this->requirePermission('feedback', 'mark');
        $request = $this->getRequest();

        $url_entry = $request->getParam('entry');
        $model_feedback = new Feedback();
        $entry = $model_feedback->findByResource($url_entry);

        $this->requireExistence($entry, 'entry', 'feedback_entry_view', 'frontpage_user');

        $entry->mark = false;
        $entry->save();

        $session = new Zend_Session_Namespace();
        $session->messages->addMessage("La sugerencia ha sido desmarcada como favorita");
        $this->_redirect($this->view->currentPage());
    }

    public function resolvAction() {
        $this->requirePermission('feedback', 'mark');
        $request = $this->getRequest();

        $url_entry = $request->getParam('entry');
        $model_feedback = new Feedback();
        $entry = $model_feedback->findByResource($url_entry);

        $this->requireExistence($entry, 'entry', 'feedback_entry_view', 'frontpage_user');

        $entry->resolved = true;
        $entry->save();

        $session = new Zend_Session_Namespace();
        $session->messages->addMessage("La sugerencia ha sido marcada como resuelta");
        $this->_redirect($this->view->currentPage());
    }

    public function unresolvAction() {
        $this->requirePermission('feedback', 'mark');
        $request = $this->getRequest();

        $url_entry = $request->getParam('entry');
        $model_feedback = new Feedback();
        $entry = $model_feedback->findByResource($url_entry);

        $this->requireExistence($entry, 'entry', 'feedback_entry_view', 'frontpage_user');

        $entry->resolved = false;
        $entry->save();

        $session = new Zend_Session_Namespace();
        $session->messages->addMessage("La sugerencia ha sido desmarcada como resuelta");
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

        $this->requireExistence($entry, 'entry', 'feedback_entry_view', 'frontpage_user');
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

        $session = new Zend_Session_Namespace();
        $session->messages->addMessage("La sugerencia ha sido eliminada");
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

        $this->requireExistence($entry, 'entry', 'feedback_entry_view', 'frontpage_user');

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

        $session = new Zend_Session_Namespace();
        $session->messages->addMessage('La sugerencia ha sido eliminada');
        $this->_redirect($this->view->currentPage());
    }
}
