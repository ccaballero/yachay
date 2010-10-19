<?php

class Notes_ManagerController extends Yeah_Action
{
    public $_ignoreContextDefault = true;

    public function newAction() {
        global $USER;

        $this->requirePermission('resources', array('new', 'view'));
        $request = $this->getRequest();

        $note = new modules_notes_models_Notes_Empty();
        
        $notes_model = Yeah_Adapter::getModel('notes');
        $resources_model = Yeah_Adapter::getModel('resources');
        $valorations_model = Yeah_Adapter::getModel('valorations');

        if ($request->isPost()) {
            $session = new Zend_Session_Namespace();

            $note = $notes_model->createRow();
            $note->note = $request->getParam('message');
            $publish = $request->getParam('publish');
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
                    $resource = $resources_model->createRow();
                    $resource->author = $USER->ident;
                    $resource->recipient = $publish;
                    $resource->tsregister = time();
                    $resource->save();

                    $note->resource = $resource->ident;
                    $note->save();

                    $resource->saveContext($request);
                    $valorations_model->addActivity(1);

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
