<?php

class Tags_IndexController extends Yeah_Action
{
    public function indexAction() {
        $this->requirePermission('tags', 'list');

        $tags_model = Yeah_Adapter::getModel('tags');
        $tags = $tags_model->selectAll();

        $max = $tags_model->findMaxWeight();
        $ratio = $max / 10.0;

        $_tags = array();
        foreach ($tags as $tag) {
            $_tags[] = array(
                'scale' => intval($tag->weight / $ratio),
                'tag' => $tag,
            );
        }
        shuffle($_tags);

        $this->view->model = $tags_model;
        $this->view->tags = $_tags;

        history('tags');
        $breadcrumb = array();
        if (Yeah_Acl::hasPermission('tags', 'delete')) {
            $breadcrumb['Etiquetas'] = $this->view->url(array(), 'tags_manager');
        }
        breadcrumb($breadcrumb);
    }
}
