<?php

class Regions_IndexController extends Yeah_Action
{
    public function indexAction() {
        $this->requirePermission('regions', 'list');

        $pages = Yeah_Adapter::getModel('pages');
        $regions = Yeah_Adapter::getModel('regions');

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

        history('regions');
        $breadcrumb = array();
        if (Yeah_Acl::hasPermission('regions', 'manage')) {
            $breadcrumb['Regiones'] = $this->view->url(array(), 'regions_manager');
        }
        breadcrumb($breadcrumb);
    }
}
