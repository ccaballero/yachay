<?php

class Regions_Pages extends Yachay_Model_Table
{
    protected $_name            = 'region_page';
    protected $_referenceMap    = array(
        'Page'                  => array(
            'columns'           => array('page'),
            'refTableClass'     => 'Pages',
            'refColumns'        => array('ident'),
        ),
        'Region'                => array(
            'columns'           => array('region'),
            'refTableClass'     => 'Regions',
            'refColumns'        => array('ident'),
        ),
    );

    public function deleteRegionsInPage($page) {
        $this->delete('page = ' . $page);
    }
}
