<?php

class modules_widgets_models_Widgets_Pages extends Zend_Db_Table_Abstract
{
    protected $_name            = 'widget_page';
    protected $_referenceMap    = array(
        'Page'                  => array(
            'columns'           => array('page'),
            'refTableClass'     => 'modules_pages_models_Pages',
            'refColumns'        => array('ident'),
        ),
        'Widget'                => array(
            'columns'           => array('widget'),
            'refTableClass'     => 'modules_widgets_models_Widgets',
            'refColumns'        => array('ident'),
        ),
    );

    public function deleteWidgetsInPage($page) {
        $this->delete('page = ' . $page);
    }

    public function getPosition($page, $widget) {
        return $this->fetchRow($this->select()->where('page = ?', $page)->where('widget = ?', $widget));
    }
}
