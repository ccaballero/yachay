<?php

class Events_EventController extends Yeah_Action
{
    public function viewAction() {
        $this->requirePermission('resources', 'view');
        $request = $this->getRequest();

        $url_event = $request->getParam('event');
        $model_events = new Events();
        $event = $model_events->findByResource($url_event);
        $this->requireExistence($event, 'event', 'events_event_view', 'frontpage_user');

        $model_resources = new Resources();
        $resource = $model_resources->findByIdent($event->resource);
        $this->requireContext($resource);

        $resource->viewers = $resource->viewers + 1;
        $resource->save();

        $tags = $resource->findTagsViaTags_Resources();

        $this->view->resource = $resource;
        $this->view->event = $event;
        $this->view->tags = $tags;

        history('events/' . $resource->ident);
        $breadcrumb = array();
        if ($this->acl('resources', 'new')) {
            $breadcrumb['Recursos'] = $this->view->url(array(), 'resources_list');
            $breadcrumb['Eventos'] = $this->view->url(array('filter' => 'events'), 'resources_filtered');
        }
        breadcrumb($breadcrumb);
    }

    public function editAction() {
        $this->requirePermission('resources', 'edit');
        $request = $this->getRequest();

        $model_resources = new Resources();
        $model_events = new Events();
        $model_tags = new Tags();
        $model_tags_resources = new Tags_Resources();

        $url_event = $request->getParam('event');
        $resource = $model_resources->findByIdent($url_event);
        $event = $model_events->findByResource($url_event);

        $this->requireExistence($event, 'event', 'events_event_view', 'frontpage_user');
        $this->requireResourceAuthor($resource);

        $_tags = array();
        $tags = $resource->findTagsViaTags_Resources();
        foreach ($tags as $tag) {
            $_tags[] = $tag->label;
        }

        if ($request->isPost()) {
            $session = new Zend_Session_Namespace();

            $event->label = $request->getParam('name');
            $event->place = $request->getParam('place');
            $event->event = strtotime($request->getParam('event-year') . '-' . $request->getParam('event-month') . '-' . $request->getParam('event-day') . ' ' . $request->getParam('event-hour') . ':' . $request->getParam('event-minute'));
            $interval = $request->getParam('interval');
            $ts_interval = 86400;
            switch ($interval) {
                case 'minute': $ts_interval =      60; break;
                case 'hour':   $ts_interval =    3600; break;
                case 'day':    $ts_interval =   86400; break;
                case 'week':   $ts_interval =  604800; break;
                case 'month':  $ts_interval = 2592000; break;
                default: $ts_interval =   86400;
            }
            $duration = intval($request->getParam('duration'));
            $event->duration = $duration * $ts_interval;
            $event->message = $request->getParam('message');
            $newTags = $request->getParam('tags');

            if ($event->isValid()) {
                $event->save();

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

                $session->messages->addMessage("El evento {$event->label} se ha actualizado correctamente");
                $this->_redirect($request->getParam('return'));
            } else {
                foreach ($event->getMessages() as $message) {
                    $session->messages->addMessage($message);
                }
            }
        }
        
        $this->view->event = $event;
        $this->view->tags = implode(', ', $_tags);

        history('events/' . $event->resource . '/edit');
        $breadcrumb = array();
        $breadcrumb['Recursos'] = $this->view->url(array(), 'resources_list');
        $breadcrumb['Eventos'] = $this->view->url(array('filter' => 'events'), 'resources_filtered');
        $breadcrumb['Evento'] = $this->view->url(array('event' => $event->resource), 'events_event_view');
        breadcrumb($breadcrumb);
    }

    public function deleteAction() {
        $this->requirePermission('resources', 'delete');
        $request = $this->getRequest();

        $model_resources = new Resources();
        $model_events = new Events();
        $model_valorations = new Valorations();
        $model_tags_resources = new Tags_Resources();

        $url_event = $request->getParam('event');
        $resource = $model_resources->findByIdent($url_event);
        $event = $model_events->findByResource($url_event);

        $this->requireExistence($event, 'event', 'events_event_view', 'frontpage_user');
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

        $event->delete();
        $resource->delete();
        $model_valorations->decreaseActivity(4);

        $session = new Zend_Session_Namespace();
        $session->messages->addMessage("El evento ha sido eliminado");
        $this->_redirect($this->view->currentPage());
    }

    // FIXME: Agregar mas infraestructura, evitar la eliminacion directa en lo posible, peligroso!
    public function dropAction() {
        $this->requirePermission('resources', 'drop');
        $request = $this->getRequest();

        $model_resources = new Resources();
        $model_events = new Events();
        $model_valorations = new Valorations();
        $model_tags_resources = new Tags_Resources();

        $url_event = $request->getParam('event');
        $resource = $model_resources->findByIdent($url_event);
        $event = $model_events->findByResource($url_event);

        $this->requireExistence($event, 'event', 'events_event_view', 'frontpage_user');

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

        $event->delete();
        $resource->delete();
        $model_valorations->decreaseActivity(4, $resource->author);

        $session = new Zend_Session_Namespace();
        $session->messages->addMessage("El evento ha sido eliminado");
        $this->_redirect($this->view->currentPage());
    }
}
