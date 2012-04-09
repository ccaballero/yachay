<?php

class Ratings_RatingController extends Yachay_Action
{
    public function upAction() {
        global $USER;

        $this->requirePermission('resources', 'view');
        $this->requirePermission('ratings', 'new');

        $request = $this->getRequest();

        $url_resource = $request->getParam('resource');
        $type_resource = $request->getParam('type');

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
            case 'entry':
                $model_feedback = new Feedback();
                $entry = $model_feedback->findByResource($url_resource);
                $this->requireExistence($entry, 'entry', 'feedback_entry_view', 'frontpage_user');
                break;
        }

        $this->requireContext($resource);
        $session = new Zend_Session_Namespace();

        $model_ratings = new Ratings();
        $exists_rating = $model_ratings->findByResourceAndAuthor($resource->ident, $USER->ident);

        if (empty($exists_rating)) {
            $rating = $model_ratings->createRow();
            $rating->resource = $resource->ident;
            $rating->author = $USER->ident;
            $rating->rating = true;
            $rating->save();

            $resource->ratings = $resource->ratings + 1;
            $resource->raters = $resource->raters + 1;
            $resource->save();

            $model_valorations->addPopularity($resource->author);
            $session->messages->addMessage('Tu has valorado el recurso positivamente');
        } else {
            if ($exists_rating->rating) {
                $session->messages->addMessage('Tu ya has valorado este recurso');
            } else {
                $exists_rating->delete();

                $resource->ratings = $resource->ratings + 1;
                $resource->raters = $resource->raters - 1;
                $resource->save();

                $model_valorations->decreasePopularity($resource->author);
                $session->messages->addMessage('Tu has cancelado tu valoración del recurso');
            }
        }

        $this->_redirect($this->view->currentPage());
    }

    public function downAction() {
        global $USER;

        $this->requirePermission('resources', 'view');
        $this->requirePermission('ratings', 'new');

        $request = $this->getRequest();

        $url_resource = $request->getParam('resource');
        $type_resource = $request->getParam('type');

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
            case 'entry':
                $model_feedback = new Feedback();
                $entry = $model_feedback->findByResource($url_resource);
                $this->requireExistence($entry, 'entry', 'feedback_entry_view', 'frontpage_user');
                break;
        }

        $this->requireContext($resource);
        $session = new Zend_Session_Namespace();

        $model_ratings = new Ratings();
        $exists_rating = $model_ratings->findByResourceAndAuthor($resource->ident, $USER->ident);

        if (empty($exists_rating)) {
            $rating = $model_ratings->createRow();
            $rating->resource = $resource->ident;
            $rating->author = $USER->ident;
            $rating->rating = false;
            $rating->save();

            $resource->ratings = $resource->ratings - 1;
            $resource->raters = $resource->raters + 1;
            $resource->save();

            $model_valorations->addPopularity($resource->author);
            $session->messages->addMessage('Tu has valorado el recurso negativamente');
        } else {
            if (!$exists_rating->rating) {
                $session->messages->addMessage('Tu ya has valorado este recurso');
            } else {
                $exists_rating->delete();

                $resource->ratings = $resource->ratings - 1;
                $resource->raters = $resource->raters - 1;
                $resource->save();

                $model_valorations->decreasePopularity($resource->author);
                $session->messages->addMessage('Tu has cancelado tu valoración del recurso');
            }
        }

        $this->_redirect($this->view->currentPage());
    }
}
