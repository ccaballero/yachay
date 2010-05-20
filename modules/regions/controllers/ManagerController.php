<?php

class Regions_ManagerController extends Yeah_Action
{
    public function indexAction() {
        $this->requirePermission('regions', 'manage');

        $pages = Yeah_Adapter::getModel('pages');
        $regions = Yeah_Adapter::getModel('regions');
        $regions_pages = Yeah_Adapter::getModel('regions', 'Regions_Pages');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $session = new Zend_Session_Namespace();

            $config = $request->getParam('regions');
            foreach ($config as $page_ident => $array_regions) {
                $page = $pages->findByIdent($page_ident);
                if (!empty($page)) {
                    // delete of regions in page
                    $regions_pages->deleteRegionsInPage($page->ident);
                    // set of new configuration
                    foreach ($array_regions as $region_ident) {
                        $region = $regions->findByIdent($region_ident);
                        if (!empty($region)) {
                            $region_page = $regions_pages->createRow();
                            $region_page->page = $page->ident;
                            $region_page->region = $region->ident;
                            $region_page->save();
                        }
                    }
                }
            }

            $session->messages->addMessage('Su configuraci&oacute;n de las regiones ha sido almacenada');
        }

        $regions_pages = array();
        foreach ($pages->selectAll() as $page) {
            $regions_pages[$page->ident] = array(
                'search'  => new modules_regions_models_Regions_Empty,
                'menubar' => new modules_regions_models_Regions_Empty,
                'toolbar' => new modules_regions_models_Regions_Empty,
                'footer'  => new modules_regions_models_Regions_Empty,
            );
            $region_page = $page->findManyToManyRowset('modules_regions_models_Regions', 'modules_regions_models_Regions_Pages');
            foreach ($region_page as $region) {
                $regions_pages[$page->ident][$region->region] = $region;
            }
        }

        $this->view->model = $pages;
        $this->view->pages = $pages->selectAll();
        $this->view->regions = $regions->selectAll();
        $this->view->regions_pages = $regions_pages;

        history('regions/manager');
        breadcrumb();
    }
}
