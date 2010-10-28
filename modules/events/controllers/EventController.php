<?php

class Events_EventController extends Yeah_Action
{
    public function viewAction() {
        $this->requirePermission('resources', 'view');
        $request = $this->getRequest();

        $event_url = $request->getParam('event');
        $events_model = Yeah_Adapter::getModel('events');
        $event = $events_model->findByResource($event_url);
        $this->requireExistence($event, 'event', 'events_event_view', 'frontpage_user');

        $resources_model = Yeah_Adapter::getModel('resources');
        $resource = $resources_model->findByIdent($event->resource);
        $this->requireContext($resource);

        $tags = $resource->findmodules_tags_models_TagsViamodules_tags_models_Tags_Resources();

        $this->view->resource = $resource;
        $this->view->event = $event;
        $this->view->tags = $tags;

        history('events/' . $resource->ident);
        $breadcrumb = array();
        if (Yeah_Acl::hasPermission('resources', 'new')) {
            $breadcrumb['Recursos'] = $this->view->url(array(), 'resources_list');
            $breadcrumb['Eventos'] = $this->view->url(array('filter' => 'events'), 'resources_filtered');
        }
        breadcrumb($breadcrumb);
    }

    public function editAction() {
        $this->requirePermission('resources', 'edit');
        $request = $this->getRequest();

        $event_ident = $request->getParam('event');

        $resources_model = Yeah_Adapter::getModel('resources');
        $events_model = Yeah_Adapter::getModel('events');
        $tags_model = Yeah_Adapter::getModel('tags');
        $tags_resources_model = Yeah_Adapter::getModel('tags', 'Tags_Resources');

        $resource = $resources_model->findByIdent($event_ident);
        $event = $events_model->findByResource($event_ident);

        $this->requireExistence($event, 'event', 'events_event_view', 'frontpage_user');
        $this->requireResourceAuthor($resource);

        $_tags = array();
        $tags = $resource->findmodules_tags_models_TagsViamodules_tags_models_Tags_Resources();
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

        $event_ident = $request->getParam('event');

        $resources_model = Yeah_Adapter::getModel('resources');
        $events_model = Yeah_Adapter::getModel('events');
        $valorations_model = Yeah_Adapter::getModel('valorations');
        $tags_resources_model = Yeah_Adapter::getModel('tags', 'Tags_Resources');

        $resource = $resources_model->findByIdent($event_ident);
        $event = $events_model->findByResource($event_ident);

        $this->requireExistence($event, 'event', 'events_event_view', 'frontpage_user');
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

        $event->delete();
        $resource->delete();
        $valorations_model->decreaseActivity(4);

        $session = new Zend_Session_Namespace();
        $session->messages->addMessage("El evento ha sido eliminado");
        $this->_redirect($this->view->currentPage());
    }

    // FIXME: Agregar mas infraestructura, evitar la eliminacion directa en lo posible, peligroso!
    public function dropAction() {
        $this->requirePermission('resources', 'drop');
        $request = $this->getRequest();

        $event_ident = $request->getParam('event');

        $resources_model = Yeah_Adapter::getModel('resources');
        $events_model = Yeah_Adapter::getModel('events');
        $valorations_model = Yeah_Adapter::getModel('valorations');
        $tags_resources_model = Yeah_Adapter::getModel('tags', 'Tags_Resources');

        $resource = $resources_model->findByIdent($event_ident);
        $event = $events_model->findByResource($event_ident);

        $this->requireExistence($event, 'event', 'events_event_view', 'frontpage_user');

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

        $event->delete();
        $resource->delete();
        $valorations_model->decreaseActivity(4, $resource->author);

        $session = new Zend_Session_Namespace();
        $session->messages->addMessage("El evento ha sido eliminado");
        $this->_redirect($this->view->currentPage());
    }
}
