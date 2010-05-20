<?php

class Pages_ManagerController extends Yeah_Action
{
    public function indexAction() {
        $this->requirePermission('pages', 'manage');

        $pages = Yeah_Adapter::getModel('pages');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $session = new Zend_Session_Namespace();

            $bads = 0;

            $config = $request->getParam('pages');
            foreach ($config as $ident => $values) {
                $page = $pages->findByIdent($ident);
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
                $session->messages->addMessage('La configuraci&oacute;n de las paginas ha sido almacenada');
            } else {
                $session->messages->addMessage("Se han almacenado las paginas correctas, y se han encontrado $bads errores");
            }
        }

        $this->view->model = $pages;
        $this->view->pages = $pages->selectByMenuable(true);

        history('pages');
        breadcrumb();
    }
}
