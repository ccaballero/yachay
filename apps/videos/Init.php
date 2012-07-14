<?php

class Videos_Init extends Yachay_Init
{
    public $check = array ('video');
    public $install = 'videos';

    public $routes = array (
    	'videos_video_edit'                      => array('videos/:video/edit',
                                                    array(
                                                        'module'     => 'videos',
                                                        'controller' => 'video',
                                                        'action'     => 'edit',
                                                    )),
        'videos_video_delete'                    => array('videos/:video/delete',
                                                    array(
                                                        'module'     => 'videos',
                                                        'controller' => 'video',
                                                        'action'     => 'delete',
                                                    )),
        'videos_video_drop'                      => array('videos/:video/drop',
                                                    array(
                                                        'module'     => 'videos',
                                                        'controller' => 'video',
                                                        'action'     => 'drop',
                                                    )),
        'videos_video_view'                      => array('videos/:video',
                                                    array(
                                                        'module'     => 'videos',
                                                        'controller' => 'video',
                                                        'action'     => 'view',
                                                    )),
        'videos_new'                             => array('videos/new',
                                                    array(
                                                        'module'     => 'videos',
                                                        'controller' => 'manager',
                                                        'action'     => 'new',
                                                   )),
    );
}
