<?php

class Files_Init extends Yeah_Init
{
    public $check = array ('file');
    public $install = 'files';

    public $routes = array (
        'files_file_download'                    => array('files/:file/download',
                                                    array(
                                                        'module'     => 'files',
                                                        'controller' => 'file',
                                                        'action'     => 'download',
                                                    )),
    	'files_file_edit'                        => array('files/:file/edit',
                                                    array(
                                                        'module'     => 'files',
                                                        'controller' => 'file',
                                                        'action'     => 'edit',
                                                    )),
        'files_file_delete'                      => array('files/:file/delete',
                                                    array(
                                                        'module'     => 'files',
                                                        'controller' => 'file',
                                                        'action'     => 'delete',
                                                    )),
        'files_file_drop'                        => array('files/:file/drop',
                                                    array(
                                                        'module'     => 'files',
                                                        'controller' => 'file',
                                                        'action'     => 'drop',
                                                    )),
        'files_file_view'                        => array('files/:file',
                                                    array(
                                                        'module'     => 'files',
                                                        'controller' => 'file',
                                                        'action'     => 'view',
                                                    )),
        'files_new'                              => array('files/new',
                                                    array(
                                                        'module'     => 'files',
                                                        'controller' => 'manager',
                                                        'action'     => 'new',
                                                   )),
    );
}
