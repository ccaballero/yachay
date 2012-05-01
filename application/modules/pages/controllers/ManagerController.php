<?php

class Pages_ManagerController extends Yachay_Action
{
    public function indexAction() {
        $this->requirePermission('pages', 'manage');

        $model_pages = new Pages();

        $request = $this->getRequest();
        if ($request->isPost()) {
            $bads = 0;

            $config = $request->getParam('pages');
            foreach ($config as $ident => $values) {
                $page = $model_pages->findByIdent($ident);
                if (!empty($page)) {
                    $page->title     = $values['title'];
                    $page->menutype  = $values['menutype'];
                    $page->menuorder = $values['menuorder'];

                    if ($page->isValid()) {
                        $page->save();
                    } else {
                        $bads++;
                    }
                } else {
                    $bads++;
                }
            }

            if ($bads == 0) {
                $this->_helper->flashMessenger->addMessage('La configuración de las paginas ha sido almacenada');
            } else {
                $this->_helper->flashMessenger->addMessage("Se han almacenado las paginas correctas, y se han encontrado $bads errores");
            }
        }

        $this->view->model_pages = $model_pages;
        $this->view->pages = $model_pages->selectByMenuable(true);

        $this->history('pages/manager');
        $breadcrumb = array();
        if ($this->acl('pages', 'list')) {
            $breadcrumb['Paginas'] = $this->view->url(array(), 'pages_list');
        }
        breadcrumb($breadcrumb);
    }
}
