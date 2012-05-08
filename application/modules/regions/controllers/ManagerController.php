<?php

class Regions_ManagerController extends Yachay_Controller_Action
{
    public function indexAction() {
        $this->requirePermission('regions', 'manage');

        $model_pages = new Pages();
        $model_regions = new Regions();
        $model_regions_pages = new Regions_Pages();

        $request = $this->getRequest();
        if ($request->isPost()) {
            $config = $request->getParam('regions');
            foreach ($config as $page_ident => $array_regions) {
                $page = $model_pages->findByIdent($page_ident);
                if (!empty($page)) {
                    // delete of regions in page
                    $model_regions_pages->deleteRegionsInPage($page->ident);
                    // set of new configuration
                    foreach ($array_regions as $region_ident) {
                        $region = $model_regions->findByIdent($region_ident);
                        if (!empty($region)) {
                            $region_page = $model_regions_pages->createRow();
                            $region_page->page = $page->ident;
                            $region_page->region = $region->ident;
                            $region_page->save();
                        }
                    }
                }
            }

            $this->_helper->flashMessenger->addMessage('Su configuración de las regiones ha sido almacenada');
        }

        $regions_pages = array();
        foreach ($model_pages->selectAll() as $page) {
            $regions_pages[$page->ident] = array(
                'search'  => new Regions_Empty(),
                'menubar' => new Regions_Empty(),
                'toolbar' => new Regions_Empty(),
                'footer'  => new Regions_Empty(),
            );
            $region_page = $page->findRegionsViaRegions_Pages();
            foreach ($region_page as $region) {
                $regions_pages[$page->ident][$region->region] = $region;
            }
        }

        $this->view->model_pages = $model_pages;
        $this->view->pages = $model_pages->selectAll();
        $this->view->model_regions = $model_regions;
        $this->view->regions = $model_regions->selectAll();
        $this->view->regions_pages = $regions_pages;

        $this->history('regions/manager');
        $breadcrumb = array();
        if ($this->acl('regions', 'list')) {
            $breadcrumb['Regiones'] = $this->view->url(array(), 'regions_list');
        }
        $this->breadcrumb($breadcrumb);
    }
}
