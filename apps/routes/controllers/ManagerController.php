<?php

class Routes_ManagerController extends Yachay_Controller_Action
{
    public function indexAction() {
        $this->requirePermission('routes', 'manage');

        $model_routes = new Db_Routes();

        $request = $this->getRequest();
        if ($request->isPost()) {
//            $bads = 0;
//
//            $config = $request->getParam('pages');
//            foreach ($config as $ident => $values) {
//                $page = $model_pages->findByIdent($ident);
//                if (!empty($page)) {
//                    $page->title     = $values['title'];
//                    $page->menutype  = $values['menutype'];
//                    $page->menuorder = $values['menuorder'];
//
//                    if ($page->isValid()) {
//                        $page->save();
//                    } else {
//                        $bads++;
//                    }
//                } else {
//                    $bads++;
//                }
//            }
//
//            if ($bads == 0) {
//                $this->_helper->flashMessenger->addMessage('La configuración de las paginas ha sido almacenada');
//            } else {
//                $this->_helper->flashMessenger->addMessage("Se han almacenado las paginas correctas, y se han encontrado $bads errores");
//            }
//        } else {
//            $this->history('pages/manager');
        }

        $this->view->model_routes = $model_routes;
        $this->view->routes = $model_routes->selectByType('list');

        $breadcrumb = array();
        if ($this->acl('routes', 'list')) {
            $breadcrumb['Rutas'] = $this->view->url(array(), 'routes_list');
        }
        $this->breadcrumb($breadcrumb);
    }
}
