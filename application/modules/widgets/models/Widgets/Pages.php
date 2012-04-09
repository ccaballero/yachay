<?php

class Widgets_Pages extends Yachay_Models_Table
{
    protected $_name            = 'widget_page';
    protected $_referenceMap    = array(
        'Page'                  => array(
            'columns'           => array('page'),
            'refTableClass'     => 'Pages',
            'refColumns'        => array('ident'),
        ),
        'Widget'                => array(
            'columns'           => array('widget'),
            'refTableClass'     => 'Widgets',
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
