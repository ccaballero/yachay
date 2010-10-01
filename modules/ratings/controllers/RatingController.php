<?php

class Ratings_RatingController extends Yeah_Action
{
    public function upAction() {
        global $USER;

        $this->requirePermission('resources', 'view');
        $this->requirePermission('ratings', 'new');

        $request = $this->getRequest();

        $resource_url = $request->getParam('resource');
        $resource_type = $request->getParam('type');

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

        $ratings_model = Yeah_Adapter::getModel('ratings');
        $rating_exists = $ratings_model->findByResourceAndAuthor($resource->ident, $USER->ident);

        if (empty($rating_exists)) {
            $rating = $ratings_model->createRow();
            $rating->resource = $resource->ident;
            $rating->author = $USER->ident;
            $rating->rating = true;
            $rating->save();

            $resource->ratings = $resource->ratings + 1;
            $resource->raters = $resource->raters + 1;
            $resource->save();

            $valorations_model->addPopularity($resource->author);
            $session->messages->addMessage('Tu has valorado el recurso positivamente');
        } else {
            if ($rating_exists->rating) {
                $session->messages->addMessage('Tu ya has valorado este recurso');
            } else {
                $rating_exists->delete();

                $resource->ratings = $resource->ratings + 1;
                $resource->raters = $resource->raters - 1;
                $resource->save();

                $valorations_model->decreasePopularity($resource->author);
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

        $resource_url = $request->getParam('resource');
        $resource_type = $request->getParam('type');

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

        $ratings_model = Yeah_Adapter::getModel('ratings');
        $rating_exists = $ratings_model->findByResourceAndAuthor($resource->ident, $USER->ident);

        if (empty($rating_exists)) {
            $rating = $ratings_model->createRow();
            $rating->resource = $resource->ident;
            $rating->author = $USER->ident;
            $rating->rating = false;
            $rating->save();

            $resource->ratings = $resource->ratings - 1;
            $resource->raters = $resource->raters + 1;
            $resource->save();

            $valorations_model->addPopularity($resource->author);
            $session->messages->addMessage('Tu has valorado el recurso negativamente');
        } else {
            if (!$rating_exists->rating) {
                $session->messages->addMessage('Tu ya has valorado este recurso');
            } else {
                $rating_exists->delete();

                $resource->ratings = $resource->ratings - 1;
                $resource->raters = $resource->raters - 1;
                $resource->save();

                $valorations_model->decreasePopularity($resource->author);
                $session->messages->addMessage('Tu has cancelado tu valoración del recurso');
            }
        }

        $this->_redirect($this->view->currentPage());
    }
}
