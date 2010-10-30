<?php

class Feedback_ManagerController extends Yeah_Action
{
    public function indexAction() {
        $this->requirePermission('feedback', array('resolv', 'mark', 'delete'));

        $request = $this->getRequest();
        if ($request->isPost()) {
            if (Yeah_Acl::hasPermission('feedback', 'resolv')) {
                $resolv = $request->getParam('resolv');
                $unresolv = $request->getParam('unresolv');
                if (!empty($resolv)) {
                    $this->_forward('resolv');
                } else if (!empty($unresolv)) {
                    $this->_forward('unresolv');
                }
            }
            if (Yeah_Acl::hasPermission('feedback', 'mark')) {
                $mark = $request->getParam('mark');
                $unmark = $request->getParam('unmark');
                if (!empty($mark)) {
                    $this->_forward('mark');
                } else if (!empty($unmark)) {
                    $this->_forward('unmark');
                }
            }
            if (Yeah_Acl::hasPermission('feedback', 'delete')) {
                $delete = $request->getParam('delete');
                if (!empty($delete)) {
                    $this->_forward('delete');
                }
            }
        }

        $model_feedback = Yeah_Adapter::getModel('feedback');

        $this->view->model = $model_feedback;
        $this->view->feedback = $model_feedback->selectAll();

        history('feedback/manager');
        breadcrumb();
    }

    public function newAction() {
        global $USER;

        $this->requirePermission('feedback', 'list');
        $this->requirePermission('resources', array('new', 'view'));

        $request = $this->getRequest();

        $entry = new modules_feedback_models_Feedback_Empty();

        $feedback_model = Yeah_Adapter::getModel('feedback');
        $resources_model = Yeah_Adapter::getModel('resources');
        $tags_model = Yeah_Adapter::getModel('tags');
        $tags_resources_model = Yeah_Adapter::getModel('tags', 'Tags_Resources');

        if ($request->isPost()) {
            $session = new Zend_Session_Namespace();

            $entry = $feedback_model->createRow();
            $entry->description = $request->getParam('description');
            $tags = $request->getParam('tags');

            if ($entry->isValid()) {
                $resource = $resources_model->createRow();
                $resource->author = $USER->ident;
                $resource->recipient = 'feedback';
                $resource->tsregister = time();
                $resource->save();

                $entry->resource = $resource->ident;
                $entry->save();

                // TAG REGISTER
                $tags = explode(',', $tags);
                foreach ($tags as $tagLabel) {
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

                $session->messages->addMessage('La sugerencia ha sido creada');
                $session->url = $entry->resource;
                $this->_redirect($request->getParam('return'));
            } else {
                foreach ($entry->getMessages() as $message) {
                    $session->messages->addMessage($message);
                }
            }
        }

        $this->view->entry = $entry;

        history('feedback/new');
        $breadcrumb = array();
        $breadcrumb['Recursos'] = $this->view->url(array(), 'resources_list');
        $breadcrumb['Sugerencias'] = $this->view->url(array('filter' => 'feedback'), 'resources_filtered');
        breadcrumb($breadcrumb);
    }

    public function markAction() {
        $this->requirePermission('feedback', 'mark');
        $request = $this->getRequest();
        if ($request->isPost()) {
            $model_feedback = Yeah_Adapter::getModel('feedback');

            $check = $request->getParam("check");

            foreach ($check as $value) {
                $entry = $model_feedback->findByResource($value);

                $entry->mark = true;
                $entry->save();
            }
            $count = count($check);

            $session = new Zend_Session_Namespace();
            $session->messages->addMessage("Se han marcado $count sugerencias");
        }

        $this->_redirect($this->view->currentPage());
    }

    public function unmarkAction() {
        $this->requirePermission('feedback', 'mark');
        $request = $this->getRequest();
        if ($request->isPost()) {
            $model_feedback = Yeah_Adapter::getModel('feedback');

            $check = $request->getParam("check");

            foreach ($check as $value) {
                $entry = $model_feedback->findByResource($value);

                $entry->mark = false;
                $entry->save();
            }
            $count = count($check);

            $session = new Zend_Session_Namespace();
            $session->messages->addMessage("Se han desmarcado $count sugerencias");
        }

        $this->_redirect($this->view->currentPage());
    }

    public function resolvAction() {
        $this->requirePermission('feedback', 'resolv');
        $request = $this->getRequest();
        if ($request->isPost()) {
            $model_feedback = Yeah_Adapter::getModel('feedback');

            $check = $request->getParam("check");

            foreach ($check as $value) {
                $entry = $model_feedback->findByResource($value);

                $entry->resolved = true;
                $entry->save();
            }
            $count = count($check);

            $session = new Zend_Session_Namespace();
            $session->messages->addMessage("Se han resuelto $count sugerencias");
        }

        $this->_redirect($this->view->currentPage());
    }

    public function unresolvAction() {
        $this->requirePermission('feedback', 'resolv');
        $request = $this->getRequest();
        if ($request->isPost()) {
            $model_feedback = Yeah_Adapter::getModel('feedback');

            $check = $request->getParam("check");

            foreach ($check as $value) {
                $entry = $model_feedback->findByResource($value);

                $entry->resolved = false;
                $entry->save();
            }
            $count = count($check);

            $session = new Zend_Session_Namespace();
            $session->messages->addMessage("Se han marcado como no resueltos $count sugerencias");
        }

        $this->_redirect($this->view->currentPage());
    }

    public function deleteAction() {
        $this->requirePermission('feedback', 'delete');
        $request = $this->getRequest();
        if ($request->isPost()) {
            $model_resources = Yeah_Adapter::getModel('resources');
            $model_feedback = Yeah_Adapter::getModel('feedback');
            $model_tags_resources = Yeah_Adapter::getModel('tags', 'Tags_Resources');

            $check = $request->getParam("check");

            foreach ($check as $value) {
                $resource = $model_resources->findByIdent($value);
                $entry = $model_feedback->findByResource($value);

                $tags = $resource->findmodules_tags_models_TagsViamodules_tags_models_Tags_Resources();
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
            }
            $count = count($check);

            $session = new Zend_Session_Namespace();
            $session->messages->addMessage("Se han eliminado $count sugerencias");
        }

        $this->_redirect($this->view->currentPage());
    }
}
