<?php

class Tags_IndexController extends Yachay_Action
{
    public function indexAction() {
        $this->requirePermission('tags', 'list');

        $model_tags = new Tags();
        $tags = $model_tags->selectAll();

        $max = $model_tags->findMaxWeight();
        $ratio = $max / 10.0;

        $_tags = array();
        foreach ($tags as $tag) {
            $_tags[] = array(
                'scale' => intval($tag->weight / $ratio),
                'tag' => $tag,
            );
        }
        shuffle($_tags);

        $this->view->model_tags = $model_tags;
        $this->view->tags = $_tags;

        $this->history('tags');
        $breadcrumb = array();
        if ($this->acl('tags', 'delete')) {
            $breadcrumb['Administrador de etiquetas'] = $this->view->url(array(), 'tags_manager');
        }
        $this->breadcrumb($breadcrumb);
    }
}
