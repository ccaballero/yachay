<?php

class Comments_CommentController extends Yeah_Action
{
    public function newAction() {
        global $USER;

        $this->requirePermission('resources', 'view');
        $this->requirePermission('comments', 'new');

        $request = $this->getRequest();

        $resource_url = $request->getParam('resource');
        $resource_type = $request->getParam('type');
        $resource_comment = $request->getParam('comment');

        $resources_model = Yeah_Adapter::getModel('resources');
        $valorations_model = Yeah_Adapter::getModel('valorations');
        $resource = $resources_model->findByIdent($resource_url);

        switch ($resource_type) {
            case 'note':
                $notes_model = Yeah_Adapter::getModel('notes');
                $note = $notes_model->findByResource($resource_url);
                $this->requireExistence($note, 'note', 'notes_note_view', 'frontpage_user');
                break;
            case 'file':
                $files_model = Yeah_Adapter::getModel('files');
                $file = $files_model->findByResource($resource_url);
                $this->requireExistence($file, 'file', 'files_file_view', 'frontpage_user');
                break;
            case 'event':
                $events_model = Yeah_Adapter::getModel('events');
                $event = $events_model->findByResource($resource_url);
                $this->requireExistence($event, 'event', 'events_event_view', 'frontpage_user');
                break;
        }

        $this->requireContext($resource);
        $session = new Zend_Session_Namespace();

        $comments_model = Yeah_Adapter::getModel('comments');
        $comment = $comments_model->createRow();
        $comment->resource = $resource->ident;
        $comment->author = $USER->ident;
        $comment->comment = $resource_comment;
        $comment->tsregister = time();

        if ($comment->isValid()) {
            $comment->save();

            $resource->comments = $resource->comments + 1;
            $resource->save();

            $valorations_model->addParticipation(2);
        }

        $session->messages->addMessage('Tu comentario ha sido publicado');
        $this->_redirect($this->view->currentPage());
    }

    public function deleteAction() {
        global $USER;

        $this->requirePermission('resources', 'view');
        $this->requirePermission('comments', 'delete');

        $request = $this->getRequest();

        $resource_url = $request->getParam('resource');
        $resource_type = $request->getParam('type');
        $comment_ident = $request->getParam('comment');

        $resources_model = Yeah_Adapter::getModel('resources');
        $valorations_model = Yeah_Adapter::getModel('valorations');
        $resource = $resources_model->findByIdent($resource_url);

        switch ($resource_type) {
            case 'note':
                $notes_model = Yeah_Adapter::getModel('notes');
                $note = $notes_model->findByResource($resource_url);
                $this->requireExistence($note, 'note', 'notes_note_view', 'frontpage_user');
                break;
            case 'file':
                $files_model = Yeah_Adapter::getModel('files');
                $file = $files_model->findByResource($resource_url);
                $this->requireExistence($file, 'file', 'files_file_view', 'frontpage_user');
                break;
            case 'event':
                $events_model = Yeah_Adapter::getModel('events');
                $event = $events_model->findByResource($resource_url);
                $this->requireExistence($event, 'event', 'events_event_view', 'frontpage_user');
                break;
        }

        $this->requireContext($resource);

        $comments_model = Yeah_Adapter::getModel('comments');
        $comment = $comments_model->findByIdent($comment_ident);

        $session = new Zend_Session_Namespace();
        if (!empty($comment) && $comment->author == $USER->ident) {
            $comment->delete();

            $resource->comments = $resource->comments - 1;
            $resource->save();

            $valorations_model->decreaseParticipation(2);
            $session->messages->addMessage('Tu comentario ha sido removido');
        }

        $this->_redirect($this->view->currentPage());
    }

    public function dropAction() {
        $this->requirePermission('comments', 'drop');
        $request = $this->getRequest();

        $comment_ident = $request->getParam('comment');
        $comments_model = Yeah_Adapter::getModel('comments');
        $comment = $comments_model->findByIdent($comment_ident);

        $valorations_model = Yeah_Adapter::getModel('valorations');

        $session = new Zend_Session_Namespace();
        if (!empty($comment)) {
            $resource = $comment->getResource();
            $comment->delete();

            $resource->comments = $resource->comments - 1;
            $resource->save();
            
            $valorations_model->decreaseParticipation(2, $comment->author);
            $session->messages->addMessage('El comentario ha sido removido');
        }

        $this->_redirect($this->view->currentPage());
    }
}
