<?php

class Pages extends Yachay_Model_Table
{
    protected $_name            = 'page';
    protected $_primary         = 'ident';
    protected $_rowClass        = 'Pages_Page';
    protected $_dependentTables = array('Widgets_Pages');
    public    $_mapping         = array(
        'ident'                 => 'Codigo',
        'label'                 => 'Pagina',
        'title'                 => 'Etiqueta',
        'package'               => 'Paquete',
        'controller'            => 'Controlador',
        'action'                => 'Accion',
        'route'                 => 'Codigo de ruta',
        'privilege'             => 'Codigo de privilegio',
        'menuable'              => 'En menu',
        'menutype'              => 'Tipo de menu',
        'menuparent'            => 'Menu superior',
        'menuorder'             => 'Peso',
    );

    // Find uniques indexes
    public function findByIdent($ident) {
        return $this->fetchRow($this->getAdapter()->quoteInto('ident = ?', $ident));
    }

    public function findByLabel($label) {
        return $this->fetchRow($this->getAdapter()->quoteInto('label = ?', $label));
    }

    public function findByRoute($route) {
        return $this->fetchRow($this->getAdapter()->quoteInto('route = ?', $route));
    }

    public function findByModuleControllerAction($package, $controller, $action) {
        return $this->fetchRow($this->select()
                                    ->where('package = ?', $package)
                                    ->where('controller = ?', $controller)
                                    ->where('action = ?', $action));
    }

    // Selects in table
    public function selectAll() {
        return $this->fetchAll($this->select()->order('label ASC'));
    }

    public function selectByMenuable($menuable) {
        return $this->fetchAll($this->select()->where('menuable = ?', $menuable)->order('label ASC'));
    }

    public function selectByMenutype($menutype = '') {
        return $this->fetchAll($this->select()->where('menutype = ?', $menutype)->order('menuorder ASC'));
    }

    public function selectByMenuparent($menuparent) {
        return $this->fetchAll($this->select()->where('menuparent = ?', $menuparent)->order('menuorder ASC'));
    }
}
