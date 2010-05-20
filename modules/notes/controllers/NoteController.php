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

        $this->view->resource = $resource;
        $this->view->note = $note;

        history('notes/' . $resource->ident);
        $breadcrumb = array();
        $breadcrumb['Recursos'] = $this->view->url(array(), 'resources_list');
        $breadcrumb['Notas'] = $this->view->url(array('filter' => 'notes'), 'resources_filtered');
        breadcrumb($breadcrumb);
    }

    public function editAction() {
        $this->requirePermission('resources', 'view');
        $request = $this->getRequest();

        $note_url = $request->getParam('note');
        $notes_model = Yeah_Adapter::getModel('notes');
        $note = $notes_model->findByResource($note_url);

        $this->requireExistence($note, 'note', 'notes_note_view', 'frontpage_user');

        if ($request->isPost()) {
            $session = new Zend_Session_Namespace();
            $note->note = $request->getParam('message');
            $priority = $request->getParam('priority');
            if (empty($priority)) {
                $note->priority = false;
            } else {
                $note->priority = true;
            }

            if ($note->isValid()) {
                $note->save();
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

        history('notes/' . $note->resource . '/edit');
        $breadcrumb = array();
        $breadcrumb['Recursos'] = $this->view->url(array(), 'resources_list');
        $breadcrumb['Notas'] = $this->view->url(array('filter' => 'notes'), 'resources_filtered');
        $breadcrumb['Nota'] = $this->view->url(array('note' => $note->resource), 'notes_note_view');
        breadcrumb($breadcrumb);
    }

    public function deleteAction() {
        // TODO
    }
}
