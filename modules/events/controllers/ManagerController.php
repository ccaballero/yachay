<?php

class Events_ManagerController extends Yeah_Action
{
    public $_ignoreContextDefault = true;

    public function newAction() {
        global $USER;

        $this->requirePermission('resources', array('new', 'view'));
        $request = $this->getRequest();

        $event = new modules_events_models_Events_Empty();
        
        $events_model = Yeah_Adapter::getModel('events');
        $resources_model = Yeah_Adapter::getModel('resources');
        $valorations_model = Yeah_Adapter::getModel('valorations');

        if ($request->isPost()) {
            $session = new Zend_Session_Namespace();
            $publish = $request->getParam('publish');
        
            $event = $events_model->createRow();
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

            $context = new Yeah_Helpers_Context();
            $spaces_valids = $context->context(NULL, 'plain');

            if (in_array($publish, $spaces_valids)) {
                if ($event->isValid()) {
                    $resource = $resources_model->createRow();
                    $resource->author = $USER->ident;
                    $resource->recipient = $request->getParam('publish');
                    $resource->tsregister = time();
                    $resource->save();

                    $event->resource = $resource->ident;
                    $event->save();

                    $resource->saveContext($request);
                    $valorations_model->addActivity(4);

                    $session->messages->addMessage('El evento ha sido creado');
                    $session->url = $note->resource;
                    $this->_redirect($request->getParam('return'));
                } else {
                    foreach ($event->getMessages() as $message) {
                        $session->messages->addMessage($message);
                    }
                }
            } else {
                $session->messages->addMessage("Usted no tiene privilegios para publicar en ese espacio");
            }
        }

        $this->view->event = $event;

        history('events/new');
        $breadcrumb = array();
        $breadcrumb['Recursos'] = $this->view->url(array(), 'resources_list');
        $breadcrumb['Eventos'] = $this->view->url(array('filter' => 'events'), 'resources_filtered');
        breadcrumb($breadcrumb);
    }
}
