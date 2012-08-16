<?php

class Widgets_Routes extends Yachay_Db_Table
{
    protected $_name            = 'widget_route';
    protected $_referenceMap    = array(
        'Route'                 => array(
            'columns'           => array('route'),
            'refTableClass'     => 'Db_Routes',
            'refColumns'        => array('route'),
        ),
        'Widget'                => array(
            'columns'           => array('widget'),
            'refTableClass'     => 'Widgets',
            'refColumns'        => array('ident'),
        ),
    );

    public function deleteWidgetsInRoute($route) {
        $this->delete("route = '$route'");
    }

    public function getPosition($route, $widget) {
        return $this->fetchRow($this->select()->where('route = ?', $route)->where('widget = ?', $widget));
    }
}
