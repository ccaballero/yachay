<?php

class Packages_IndexController extends Yachay_Controller_Action
{
    public function indexAction() {
        $this->requirePermission('packages', 'list');

        $model_packages = new Packages();
        $packages = $model_packages->fetchAll();

        $tree = new Structures_Tree();
        foreach ($packages as $package) {
            $tree->addNode($package);
        }

        $tree->indexAll();
        $this->view->tree = $tree;

        $this->history('packages');
        $breadcrumb = array();
        if ($this->acl('packages', array('new', 'lock'))) {
            $breadcrumb['Administrador de modulos'] = $this->view->url(array(), 'packages_manager');
        }
        $this->breadcrumb($breadcrumb);
    }
}
