<?php

class Comments_Init extends Yeah_Init
{
    public $check = array ('comment');
    public $install = 'comments';

    public $routes = array (
        'comments_drop'                          => array('comments/:comment/drop',
                                                    array(
                                                        'module'     => 'comments',
                                                        'controller' => 'comment',
                                                        'action'     => 'drop',
                                                    )),
        'notes_note_comment_delete'              => array('notes/:resource/comments/:comment/delete',
                                                    array(
                                                        'module'     => 'comments',
                                                        'controller' => 'comment',
                                                        'action'     => 'delete',
                                                        'type'       => 'note',
                                                    )),
        'links_link_comment_delete'              => array('links/:resource/comments/:comment/delete',
                                                    array(
                                                        'module'     => 'comments',
                                                        'controller' => 'comment',
                                                        'action'     => 'delete',
                                                        'type'       => 'link',
                                                    )),
        'files_file_comment_delete'              => array('files/:resource/comments/:comment/delete',
                                                    array(
                                                        'module'     => 'comments',
                                                        'controller' => 'comment',
                                                        'action'     => 'delete',
                                                        'type'       => 'file',
                                                    )),
        'events_event_comment_delete'            => array('events/:resource/comments/:comment/delete',
                                                    array(
                                                        'module'     => 'comments',
                                                        'controller' => 'comment',
                                                        'action'     => 'delete',
                                                        'type'       => 'event',
                                                    )),
        'photos_photo_comment_delete'            => array('photos/:resource/comments/:comment/delete',
                                                    array(
                                                        'module'     => 'comments',
                                                        'controller' => 'comment',
                                                        'action'     => 'delete',
                                                        'type'       => 'photo',
                                                    )),
        'videos_video_comment_delete'            => array('videos/:resource/comments/:comment/delete',
                                                    array(
                                                        'module'     => 'comments',
                                                        'controller' => 'comment',
                                                        'action'     => 'delete',
                                                        'type'       => 'video',
                                                    )),
        'feedback_entry_comment_delete'          => array('feedback/:resource/comments/:comment/delete',
                                                    array(
                                                        'module'     => 'comments',
                                                        'controller' => 'comment',
                                                        'action'     => 'delete',
                                                        'type'       => 'feedback',
                                                    )),
        'notes_note_comment'                     => array('notes/:resource/comment',
                                                    array(
                                                        'module'     => 'comments',
                                                        'controller' => 'comment',
                                                        'action'     => 'new',
                                                        'type'       => 'note',
                                                    )),
        'links_link_comment'                     => array('links/:resource/comment',
                                                    array(
                                                        'module'     => 'comments',
                                                        'controller' => 'comment',
                                                        'action'     => 'new',
                                                        'type'       => 'link',
                                                    )),
        'files_file_comment'                     => array('files/:resource/comment',
                                                    array(
                                                        'module'     => 'comments',
                                                        'controller' => 'comment',
                                                        'action'     => 'new',
                                                        'type'       => 'file',
                                                    )),
        'events_event_comment'                   => array('events/:resource/comment',
                                                    array(
                                                        'module'     => 'comments',
                                                        'controller' => 'comment',
                                                        'action'     => 'new',
                                                        'type'       => 'event',
                                                    )),
        'photos_photo_comment'                   => array('photos/:resource/comment',
                                                    array(
                                                        'module'     => 'comments',
                                                        'controller' => 'comment',
                                                        'action'     => 'new',
                                                        'type'       => 'photo',
                                                    )),
        'videos_video_comment'                   => array('videos/:resource/comment',
                                                    array(
                                                        'module'     => 'comments',
                                                        'controller' => 'comment',
                                                        'action'     => 'new',
                                                        'type'       => 'video',
                                                    )),
        'feedback_entry_comment'                 => array('feedback/:resource/comment',
                                                    array(
                                                        'module'     => 'comments',
                                                        'controller' => 'comment',
                                                        'action'     => 'new',
                                                        'type'       => 'feedback',
                                                    )),
    );
}
