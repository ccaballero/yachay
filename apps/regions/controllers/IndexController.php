<?php

class Regions_IndexController extends Yachay_Controller_Action
{
    public function indexAction() {
        $this->requirePermission('regions', 'list');

        $model_pages = new Pages();
        $model_regions = new Regions();

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

        $this->history('regions');
        $breadcrumb = array();
        if ($this->acl('regions', 'manage')) {
            $breadcrumb['Administrador de regiones'] = $this->view->url(array(), 'regions_manager');
        }
        $this->breadcrumb($breadcrumb);
    }
}
