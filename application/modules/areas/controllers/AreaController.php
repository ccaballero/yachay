<?php

class Areas_AreaController extends Yachay_Action
{
    public function viewAction() {
        global $USER;

        $this->requirePermission('areas', 'view');
        $request = $this->getRequest();

        $model_areas = new Areas();
        $area = $model_areas->findByUrl($request->getParam('area'));
        $this->requireExistence($area, 'area', 'areas_area_view', 'areas_list');

        $this->context('area', $area);

        $model_gestions = new Gestions();
        $gestion = $model_gestions->findByActive();

        $model_subjects_users = new Subjects_Users();
        $subjects1 = $area->findSubjectsViaAreas_Subjects();
        $subjects2 = array();
        foreach ($subjects1 as $subject) {
            if ($subject->gestion == $gestion->ident) {
                if ($subject->status == 'active' || $this->acl('subjects', 'lock')) {
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
                                if ($this->acl('subjects', 'edit')) {
                                    $subjects2[] = $subject;
                                } else {
                                    $assign = $model_subjects_users->findBySubjectAndUser($subject->ident, $USER->ident);
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

        $resources = $area->findResourcesViaAreas_Resources($area->select()->order('tsregister DESC'));

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

        $this->view->model_areas = $model_areas;
        $this->view->area = $area;
        $this->view->subjects = $subjects2;

        $this->history('areas/' . $area->url);
        $breadcrumb = array();
        if ($this->acl('areas', 'list')) {
            $breadcrumb['Areas'] = $this->view->url(array(), 'areas_list');
        }
        if ($this->acl('areas', array('new', 'delete'))) {
            $breadcrumb['Administrador de areas'] = $this->view->url(array(), 'areas_manager');
        }
        breadcrumb($breadcrumb);
    }

    public function editAction() {
        $this->requirePermission('areas', 'edit');

        $request = $this->getRequest();
        $model_areas = new Areas();
        $area = $model_areas->findByUrl($request->getParam('area'));
        $this->requireExistence($area, 'area', 'areas_area_view', 'areas_list');

        $this->context('area', $area);

        if ($request->isPost()) {
            $session = new Zend_Session_Namespace('yachay');

            $area->label = $request->getParam('label');
            $area->url = convert($area->label);
            $area->description = $request->getParam('description');

            if ($area->isValid()) {
                $area->save();

                $this->_helper->flashMessenger->addMessage("El area {$area->label} se ha actualizado correctamente");

                $session->url = $area->url;
                $this->_redirect($request->getParam('return'));
            } else {
                foreach ($area->getMessages() as $message) {
                    $this->_helper->flashMessenger->addMessage($message);
                }
            }
        }

        $this->view->model_areas = $model_areas;
        $this->view->area = $area;

        $this->history('areas/' . $area->url . '/edit');
        $breadcrumb = array();
        if ($this->acl('areas', 'list')) {
            $breadcrumb['Areas'] = $this->view->url(array(), 'areas_list');
        }
        if ($this->acl('areas', array('new', 'delete'))) {
            $breadcrumb['Administrador de areas'] = $this->view->url(array(), 'areas_manager');
        }
        if ($this->acl('areas', 'view')) {
            $breadcrumb[$area->label] = $this->view->url(array('area' => $area->url), 'areas_area_view');
        }
        breadcrumb($breadcrumb);
    }

    public function deleteAction() {
        $this->requirePermission('areas', 'delete');
        $request = $this->getRequest();
        $url = $request->getParam('area');

        $model_areas = new Areas();
        $area = $model_areas->findByUrl($url);

        if (!empty($area) && $area->isEmpty()) {
            $label = $area->label;
            $area->delete();
            $this->_helper->flashMessenger->addMessage("El area $label ha sido eliminada");
        } else {
            $this->_helper->flashMessenger->addMessage('El area no puede ser eliminada');
        }

        $this->_redirect($this->view->currentPage());
    }
}
