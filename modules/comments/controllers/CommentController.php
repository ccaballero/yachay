<?php

class Comments_CommentController extends Yeah_Action
{
    public function newAction() {
        global $USER;

        $this->requirePermission('resources', 'view');
        $this->requirePermission('comments', 'new');

        $request = $this->getRequest();

        $url_resource = $request->getParam('resource');
        $type_resource = $request->getParam('type');
        $comment_resource = $request->getParam('comment');

        $model_resources = new Resources();
        $model_valorations = new Valorations();
        $resource = $model_resources->findByIdent($url_resource);

        switch ($type_resource) {
            case 'note':
                $model_notes = new Notes();
                $note = $model_notes->findByResource($url_resource);
                $this->requireExistence($note, 'note', 'notes_note_view', 'frontpage_user');
                break;
            case 'file':
                $model_files = new Files();
                $file = $model_files->findByResource($url_resource);
                $this->requireExistence($file, 'file', 'files_file_view', 'frontpage_user');
                break;
            case 'event':
                $model_events = new Events();
                $event = $model_events->findByResource($url_resource);
                $this->requireExistence($event, 'event', 'events_event_view', 'frontpage_user');
                break;
            case 'feedback':
                $model_feedback = new Feedback();
                $entry = $model_feedback->findByResource($url_resource);
                $this->requireExistence($entry, 'entry', 'feedback_entry_view', 'frontpage_user');
        }

        $this->requireContext($resource);
        $session = new Zend_Session_Namespace();

        $comments_model = new Comments();
        $comment = $comments_model->createRow();
        $comment->resource = $resource->ident;
        $comment->author = $USER->ident;
        $comment->comment = $comment_resource;
        $comment->tsregister = time();

        if ($comment->isValid()) {
            $comment->save();

            $resource->comments = $resource->comments + 1;
            $resource->save();

            $model_valorations->addParticipation(2);
        }

        $session->messages->addMessage('Tu comentario ha sido publicado');
        $this->_redirect($this->view->currentPage());
    }

    public function deleteAction() {
        global $USER;

        $this->requirePermission('resources', 'view');
        $this->requirePermission('comments', 'delete');

        $request = $this->getRequest();

        $url_resource = $request->getParam('resource');
        $type_resource = $request->getParam('type');
        $comment_resource = $request->getParam('comment');

        $model_resources = new Resources();
        $model_valorations = new Valorations();
        $resource = $model_resources->findByIdent($url_resource);

        switch ($type_resource) {
            case 'note':
                $model_notes = new Notes();
                $note = $model_notes->findByResource($url_resource);
                $this->requireExistence($note, 'note', 'notes_note_view', 'frontpage_user');
                break;
            case 'file':
                $model_files = new Files();
                $file = $model_files->findByResource($url_resource);
                $this->requireExistence($file, 'file', 'files_file_view', 'frontpage_user');
                break;
            case 'event':
                $model_events = new Events();
                $event = $model_events->findByResource($url_resource);
                $this->requireExistence($event, 'event', 'events_event_view', 'frontpage_user');
                break;
            case 'feedback':
                $model_feedback = new Feedback();
                $entry = $model_feedback->findByResource($url_resource);
                $this->requireExistence($entry, 'entry', 'feedback_entry_view', 'frontpage_user');
        }

        $this->requireContext($resource);

        $comments_model = new Comments();
        $comment = $comments_model->findByIdent($comment_resource);

        $session = new Zend_Session_Namespace();
        if (!empty($comment) && $comment->author == $USER->ident) {
            $comment->delete();

            $resource->comments = $resource->comments - 1;
            $resource->save();

            $model_valorations->decreaseParticipation(2);
            $session->messages->addMessage('Tu comentario ha sido removido');
        }

        $this->_redirect($this->view->currentPage());
    }

    public function dropAction() {
        $this->requirePermission('comments', 'drop');
        $request = $this->getRequest();

        $comment_resource = $request->getParam('comment');
        $comments_model = new Comments();
        $comment = $comments_model->findByIdent($comment_resource);

        $model_valorations = new Valorations();

        $session = new Zend_Session_Namespace();
        if (!empty($comment)) {
            $resource = $comment->getResource();
            $comment->delete();

            $resource->comments = $resource->comments - 1;
            $resource->save();
            
            $model_valorations->decreaseParticipation(2, $comment->author);
            $session->messages->addMessage('El comentario ha sido removido');
        }

        $this->_redirect($this->view->currentPage());
    }
}
