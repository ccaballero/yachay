<?php

class Feedback_EntryController extends Yeah_Action
{
    public function viewAction() {
        $this->requirePermission('resources', 'view');
        $this->requirePermission('feedback', 'list');
        $request = $this->getRequest();

        $entry_url = $request->getParam('entry');
        $feedback_model = Yeah_Adapter::getModel('feedback');
        $entry = $feedback_model->findByResource($entry_url);
        $this->requireExistence($entry, 'entry', 'feedback_entry_view', 'frontpage_user');

        $resources_model = Yeah_Adapter::getModel('resources');
        $resource = $resources_model->findByIdent($entry->resource);
        $this->requireContext($resource);

        $tags = $resource->findmodules_tags_models_TagsViamodules_tags_models_Tags_Resources();

        $this->view->resource = $resource;
        $this->view->entry = $entry;
        $this->view->tags = $tags;

        history('feedback/' . $resource->ident);
        $breadcrumb = array();
        if (Yeah_Acl::hasPermission('resources', 'new')) {
            $breadcrumb['Recursos'] = $this->view->url(array(), 'resources_list');
            $breadcrumb['Sugerencias'] = $this->view->url(array('filter' => 'feedback'), 'resources_filtered');
        }
        breadcrumb($breadcrumb);
    }

    public function editAction() {
        $this->requirePermission('resources', 'edit');
        $this->requirePermission('feedback', 'list');
        $request = $this->getRequest();

        $entry_ident = $request->getParam('entry');

        $resources_model = Yeah_Adapter::getModel('resources');
        $feedback_model = Yeah_Adapter::getModel('feedback');
        $tags_model = Yeah_Adapter::getModel('tags');
        $tags_resources_model = Yeah_Adapter::getModel('tags', 'Tags_Resources');

        $resource = $resources_model->findByIdent($entry_ident);
        $entry = $feedback_model->findByResource($entry_ident);

        $this->requireExistence($entry, 'entry', 'feedback_entry_view', 'frontpage_user');
        $this->requireResourceAuthor($resource);

        $_tags = array();
        $tags = $resource->findmodules_tags_models_TagsViamodules_tags_models_Tags_Resources();
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

        $entry_ident = $request->getParam('entry');

        $feedback_model = Yeah_Adapter::getModel('feedback');
        $entry = $feedback_model->findByResource($entry_ident);

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

        $entry_ident = $request->getParam('entry');

        $feedback_model = Yeah_Adapter::getModel('feedback');
        $entry = $feedback_model->findByResource($entry_ident);

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

        $entry_ident = $request->getParam('entry');

        $feedback_model = Yeah_Adapter::getModel('feedback');
        $entry = $feedback_model->findByResource($entry_ident);

        $this->requireExistence($entry, 'entry', 'feedback_entry_view', 'frontpage_user');

        $entry->resolved = true;
        $entry->save();

        $session = new Zend_Session_Namespace();
        $session->messages->addMessage("La sugerencia ha sido desmarcada como favorita");
        $this->_redirect($this->view->currentPage());
    }

    public function unresolvAction() {
        $this->requirePermission('feedback', 'mark');
        $request = $this->getRequest();

        $entry_ident = $request->getParam('entry');

        $feedback_model = Yeah_Adapter::getModel('feedback');
        $entry = $feedback_model->findByResource($entry_ident);

        $this->requireExistence($entry, 'entry', 'feedback_entry_view', 'frontpage_user');

        $entry->resolved = false;
        $entry->save();

        $session = new Zend_Session_Namespace();
        $session->messages->addMessage("La sugerencia ha sido desmarcada como favorita");
        $this->_redirect($this->view->currentPage());
    }

    public function deleteAction() {
        $this->requirePermission('resources', 'delete');
        $this->requirePermission('feedback', 'list');
        $request = $this->getRequest();

        $entry_ident = $request->getParam('entry');

        $resources_model = Yeah_Adapter::getModel('resources');
        $feedback_model = Yeah_Adapter::getModel('feedback');
        $tags_resources_model = Yeah_Adapter::getModel('tags', 'Tags_Resources');

        $resource = $resources_model->findByIdent($entry_ident);
        $entry = $feedback_model->findByResource($entry_ident);

        $this->requireExistence($entry, 'entry', 'feedback_entry_view', 'frontpage_user');
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

        $entry_ident = $request->getParam('entry');

        $resources_model = Yeah_Adapter::getModel('resources');
        $feedback_model = Yeah_Adapter::getModel('feedback');
        $tags_resources_model = Yeah_Adapter::getModel('tags', 'Tags_Resources');

        $resource = $resources_model->findByIdent($entry_ident);
        $entry = $feedback_model->findByResource($entry_ident);

        $this->requireExistence($entry, 'entry', 'feedback_entry_view', 'frontpage_user');

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

        $entry->delete();
        $resource->delete();

        $session = new Zend_Session_Namespace();
        $session->messages->addMessage("La sugerencia ha sido eliminada");
        $this->_redirect($this->view->currentPage());
    }
}
