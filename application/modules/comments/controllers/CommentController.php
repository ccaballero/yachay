<?php

class Comments_CommentController extends Yachay_Controller_Action
{
    public function newAction() {
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
            case 'link':
                $model_links = new Links();
                $link = $model_links->findByResource($url_resource);
                $this->requireExistence($link, 'link', 'links_link_view', 'frontpage_user');
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
            case 'photo':
                $model_photos = new Photos();
                $photo = $model_photos->findByResource($url_resource);
                $this->requireExistence($photo, 'photo', 'photos_photo_view', 'frontpage_user');
                break;
            case 'video':
                $model_videos = new Videos();
                $video = $model_videos->findByResource($url_resource);
                $this->requireExistence($video, 'video', 'videos_video_view', 'frontpage_user');
                break;
            case 'feedback':
                $model_feedback = new Feedback();
                $entry = $model_feedback->findByResource($url_resource);
                $this->requireExistence($entry, 'entry', 'feedback_entry_view', 'frontpage_user');
        }

        $this->requireContext($resource);

        $comments_model = new Comments();
        $comment = $comments_model->createRow();
        $comment->resource = $resource->ident;
        $comment->author = $this->user->ident;
        $comment->comment = $comment_resource;
        $comment->tsregister = time();

        if ($comment->isValid()) {
            $comment->save();

            $resource->comments = $resource->comments + 1;
            $resource->save();

            $model_valorations->addParticipation(2);
            $this->_helper->flashMessenger->addMessage('Tu comentario ha sido publicado');
        } else {
            foreach ($comment->getMessages() as $message) {
                $this->_helper->flashMessenger->addMessage($message);
            }
        }

        $this->_redirect($this->view->currentPage());
    }

    public function deleteAction() {
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
            case 'link':
                $model_links = new Links();
                $link = $model_links->findByResource($url_resource);
                $this->requireExistence($link, 'link', 'links_link_view', 'frontpage_user');
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
            case 'photo':
                $model_photos = new Photos();
                $photo = $model_photos->findByResource($url_resource);
                $this->requireExistence($photo, 'photo', 'photos_photo_view', 'frontpage_user');
                break;
            case 'video':
                $model_videos = new Videos();
                $video = $model_videos->findByResource($url_resource);
                $this->requireExistence($video, 'video', 'videos_video_view', 'frontpage_user');
                break;
            case 'feedback':
                $model_feedback = new Feedback();
                $entry = $model_feedback->findByResource($url_resource);
                $this->requireExistence($entry, 'entry', 'feedback_entry_view', 'frontpage_user');
        }

        $this->requireContext($resource);

        $comments_model = new Comments();
        $comment = $comments_model->findByIdent($comment_resource);

        if (!empty($comment) && $comment->author == $this->user->ident) {
            $comment->delete();

            $resource->comments = $resource->comments - 1;
            $resource->save();

            $model_valorations->decreaseParticipation(2);
            $this->_helper->flashMessenger->addMessage('Tu comentario ha sido removido');
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

        if (!empty($comment)) {
            $resource = $comment->getResource();
            $comment->delete();

            $resource->comments = $resource->comments - 1;
            $resource->save();
            
            $model_valorations->decreaseParticipation(2, $comment->author);
            $this->_helper->flashMessenger->addMessage('El comentario ha sido removido');
        }

        $this->_redirect($this->view->currentPage());
    }
}
