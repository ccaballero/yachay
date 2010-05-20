<?php

class modules_regions_models_Regions_Pages extends Zend_Db_Table_Abstract
{
    protected $_name            = 'region_page';
    protected $_referenceMap    = array(
        'Page'                  => array(
            'columns'           => array('page'),
            'refTableClass'     => 'modules_pages_models_Pages',
            'refColumns'        => array('ident'),
        ),
        'Region'                => array(
            'columns'           => array('region'),
            'refTableClass'     => 'modules_regions_models_Regions',
            'refColumns'        => array('ident'),
        ),
    );

    public function deleteRegionsInPage($page) {
        $this->delete('page = ' . $page);
    }
}
