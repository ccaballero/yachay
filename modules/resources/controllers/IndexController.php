<?php

class Resources_IndexController extends Yeah_Action
{
    public function listAction() {
        global $USER;
        $this->requirePermission('resources', 'new');

        $resources_model = Yeah_Adapter::getModel('resources');
        $resources = $resources_model->selectByAuthor($USER->ident);

        $evaluations_model = Yeah_Adapter::getModel('evaluations');
        $evaluations = $evaluations_model->selectByAuthor($USER->ident);
        
        $list = array();

        foreach ($resources as $resource) {
            $list[$resource->tsregister] = $resource;
        }
        foreach ($evaluations as $evaluation) {
            $list[$evaluation->tsregister] = $evaluation;
        }

        ksort($list);
        $list = array_reverse($list);
        $this->view->resources = $list;

		history('resources');
        breadcrumb();
    }

    public function filteredAction() {
        global $USER;
        $this->requirePermission('resources', 'new');

        $request = $this->getRequest();
        $filter = $request->getParam('filter');

        $list = array();
        $resources_model = Yeah_Adapter::getModel('resources');
        $resources = $resources_model->selectByAuthor($USER->ident);

        switch ($filter) {
            case 'notes':
                foreach ($resources as $resource) {
                    $extended = $resource->getExtended();
                    if ($extended->__type == 'note') {
                        $list[$resource->tsregister] = $resource;
                    }
                }
                $this->view->newroute = 'notes_new';
                break;
            case 'files':
                foreach ($resources as $resource) {
                    $extended = $resource->getExtended();
                    if ($extended->__type == 'file') {
                        $list[$resource->tsregister] = $resource;
                    }
                }
                $this->view->newroute = 'files_new';
                break;
            case 'events':
                foreach ($resources as $resource) {
                    $extended = $resource->getExtended();
                    if ($extended->__type == 'event') {
                        $list[$resource->tsregister] = $resource;
                    }
                }
                $this->view->newroute = 'events_new';
                break;
            case 'evaluations':
                $evaluations_model = Yeah_Adapter::getModel('evaluations');
                $evaluations = $evaluations_model->selectByAuthor($USER->ident);
                foreach ($evaluations as $evaluation) {
                    $list[$evaluation->tsregister] = $evaluation;
                }
                $this->view->newroute = 'evaluations_new';
                break;
        }

        ksort($list);
        $list = array_reverse($list);
        $this->view->resources = $list;
        $this->render('list');

        history('resources');
        $breadcrumb = array();
        $breadcrumb['Recursos'] = $this->view->url(array(), 'resources_list');
        breadcrumb($breadcrumb);
    } 
}
