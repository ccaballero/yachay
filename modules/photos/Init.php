<?php

class Photos_Init extends Yeah_Init
{
    public $check = array ('photo');
    public $install = 'photos';

    public $routes = array (
    	'photos_photo_edit'                      => array('photos/:photo/edit',
                                                    array(
                                                        'module'     => 'photos',
                                                        'controller' => 'photo',
                                                        'action'     => 'edit',
                                                    )),
        'photos_photo_delete'                    => array('photos/:photo/delete',
                                                    array(
                                                        'module'     => 'photos',
                                                        'controller' => 'photo',
                                                        'action'     => 'delete',
                                                    )),
        'photos_photo_drop'                      => array('photos/:photo/drop',
                                                    array(
                                                        'module'     => 'photos',
                                                        'controller' => 'photo',
                                                        'action'     => 'drop',
                                                    )),
        'photos_photo_view'                      => array('photos/:photo',
                                                    array(
                                                        'module'     => 'photos',
                                                        'controller' => 'photo',
                                                        'action'     => 'view',
                                                    )),
        'photos_new'                             => array('photos/new',
                                                    array(
                                                        'module'     => 'photos',
                                                        'controller' => 'manager',
                                                        'action'     => 'new',
                                                   )),
    );
}
