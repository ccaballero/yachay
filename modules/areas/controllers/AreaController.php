<?php

class Areas_AreaController extends Yeah_Action
{
    public function viewAction() {
        global $USER;

        $this->requirePermission('areas', 'view');

        $request = $this->getRequest();
        $areas = Yeah_Adapter::getModel('areas');
        $area = $areas->findByUrl($request->getParam('area'));
        $this->requireExistence($area, 'area', 'areas_area_view', 'areas_list');

        context('area', $area);

        $gestions = Yeah_Adapter::getModel('gestions');
        $gestion = $gestions->findByActive();

        $assignement = Yeah_Adapter::getModel('subjects', 'Subjects_Users');
        $subjects1 = $area->findmodules_subjects_models_SubjectsViamodules_areas_models_Areas_Subjects();
        $subjects2 = array();
        foreach ($subjects1 as $subject) {
            if ($subject->gestion == $gestion->ident) {
                if ($subject->status == 'active' || Yeah_Acl::hasPermission('subjects', 'lock')) {
                    switch ($subject->visibility) {
                        case 'public':
                            $subjects2[] = $subject;
                            break;
                        case 'register':
                            if ($USER->role != 1) {
                                $subjects2[] = $subject;
                            }
                            break;
                        case 'private':
                            if ($USER->role != 1) {
                                if (Yeah_Acl::hasPermission('subjects', 'edit')) {
                                    $subjects2[] = $subject;
                                } else {
                                    $assign = $assignement->findBySubjectAndUser($subject->ident, $USER->ident);
                                    if (!empty($assign)) {
                                        $subjects2[] = $subject;
                                    }
                                }
                            }
                            break;
                    }
                }
            }
        }

        $resources = $area->findmodules_resources_models_ResourcesViamodules_areas_models_Areas_Resources($area->select()->order('tsregister DESC'));

        // PAGINATOR
        $page = $request->getParam('page', 1);
        $paginator = Zend_Paginator::factory($resources);
        $paginator->setItemCountPerPage(10);
        $paginator->setCurrentPageNumber($page);
        $paginator->setPageRange(10);

        $this->view->resources = $paginator;
        $this->view->route = array (
            'key' => 'areas_area_view',
            'params' => array (
                'area' => $area->url,
            ),
        );

        $this->view->model = $areas;
        $this->view->area = $area;
        $this->view->subjects = $subjects2;

        history('areas/' . $area->url);
        $breadcrumb = array();
        if (Yeah_Acl::hasPermission('areas', array('new', 'delete'))) {
            $breadcrumb['Areas'] = $this->view->url(array(), 'areas_manager');
        } else if (Yeah_Acl::hasPermission('areas', 'list')) {
            $breadcrumb['Areas'] = $this->view->url(array(), 'areas_list');
        }
        breadcrumb($breadcrumb);
    }

    public function editAction() {
        $this->requirePermission('areas', 'edit');

        $request = $this->getRequest();
        $areas = Yeah_Adapter::getModel('areas');
        $area = $areas->findByUrl($request->getParam('area'));
        $this->requireExistence($area, 'area', 'areas_area_view', 'areas_list');

        context('area', $area);

        if ($request->isPost()) {
            $session = new Zend_Session_Namespace();

            $area->label = $request->getParam('label');
            $area->url = convert($area->label);
            $area->description = $request->getParam('description');

            if ($area->isValid()) {
                $area->save();

                $session->messages->addMessage("El area {$area->label} se ha actualizado correctamente");
                $session->url = $area->url;
                $this->_redirect($request->getParam('return'));
            } else {
                foreach ($area->getMessages() as $message) {
                    $session->messages->addMessage($message);
                }
            }
        }

        $this->view->model = $areas;
        $this->view->area = $area;

        history('areas/' . $area->url . '/edit');
        $breadcrumb = array();
        if (Yeah_Acl::hasPermission('areas', array('new', 'delete'))) {
            $breadcrumb['Areas'] = $this->view->url(array(), 'areas_manager');
        } else if (Yeah_Acl::hasPermission('areas', 'list')) {
            $breadcrumb['Areas'] = $this->view->url(array(), 'areas_list');
        }
        if (Yeah_Acl::hasPermission('areas', 'view')) {
            $breadcrumb[$area->label] = $this->view->url(array('area' => $area->url), 'areas_area_view');
        }
        breadcrumb($breadcrumb);
    }

    public function deleteAction() {
        $this->requirePermission('areas', 'delete');
        $request = $this->getRequest();

        $url = $request->getParam('area');
        $areas = Yeah_Adapter::getModel('areas');
        $area = $areas->findByUrl($url);

        $session = new Zend_Session_Namespace();
        if (!empty($area) && $area->isEmpty()) {
            $label = $area->label;
            $area->delete();
            $session->messages->addMessage("El area $label ha sido eliminada");
        } else {
            $session->messages->addMessage("El area no puede ser eliminada");
        }

        $this->_redirect($this->view->currentPage());
    }
}
