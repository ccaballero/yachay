<?php

class Ratings_Init extends Yachay_Init
{
    public $check = array ('rating');
    public $install = 'ratings';

    public $routes = array (
        'notes_note_rating_up'                   => array('notes/:resource/rating/up',
                                                    array(
                                                        'module'     => 'ratings',
                                                        'controller' => 'rating',
                                                        'action'     => 'up',
                                                        'type'       => 'note',
                                                    )),
        'links_link_rating_up'                   => array('links/:resource/rating/up',
                                                    array(
                                                        'module'     => 'ratings',
                                                        'controller' => 'rating',
                                                        'action'     => 'up',
                                                        'type'       => 'link',
                                                    )),
        'files_file_rating_up'                   => array('files/:resource/rating/up',
                                                    array(
                                                        'module'     => 'ratings',
                                                        'controller' => 'rating',
                                                        'action'     => 'up',
                                                        'type'       => 'file',
                                                    )),
        'events_event_rating_up'                 => array('events/:resource/rating/up',
                                                    array(
                                                        'module'     => 'ratings',
                                                        'controller' => 'rating',
                                                        'action'     => 'up',
                                                        'type'       => 'event',
                                                    )),
        'photos_photo_rating_up'                 => array('photos/:resource/rating/up',
                                                    array(
                                                        'module'     => 'ratings',
                                                        'controller' => 'rating',
                                                        'action'     => 'up',
                                                        'type'       => 'photo',
                                                    )),
        'videos_video_rating_up'                 => array('videos/:resource/rating/up',
                                                    array(
                                                        'module'     => 'ratings',
                                                        'controller' => 'rating',
                                                        'action'     => 'up',
                                                        'type'       => 'video',
                                                    )),
        'feedback_entry_rating_up'               => array('feedback/:resource/rating/up',
                                                    array(
                                                        'module'     => 'ratings',
                                                        'controller' => 'rating',
                                                        'action'     => 'up',
                                                        'type'       => 'entry',
                                                    )),
        'notes_note_rating_down'                 => array('notes/:resource/rating/down',
                                                    array(
                                                        'module'     => 'ratings',
                                                        'controller' => 'rating',
                                                        'action'     => 'down',
                                                        'type'       => 'note',
                                                    )),
        'links_link_rating_down'                 => array('links/:resource/rating/down',
                                                    array(
                                                        'module'     => 'ratings',
                                                        'controller' => 'rating',
                                                        'action'     => 'down',
                                                        'type'       => 'link',
                                                    )),
        'files_file_rating_down'                 => array('files/:resource/rating/down',
                                                    array(
                                                        'module'     => 'ratings',
                                                        'controller' => 'rating',
                                                        'action'     => 'down',
                                                        'type'       => 'file',
                                                    )),
        'events_event_rating_down'               => array('events/:resource/rating/down',
                                                    array(
                                                        'module'     => 'ratings',
                                                        'controller' => 'rating',
                                                        'action'     => 'down',
                                                        'type'       => 'event',
                                                    )),
        'photos_photo_rating_down'               => array('photos/:resource/rating/down',
                                                    array(
                                                        'module'     => 'ratings',
                                                        'controller' => 'rating',
                                                        'action'     => 'down',
                                                        'type'       => 'photo',
                                                    )),
        'videos_video_rating_down'               => array('videos/:resource/rating/down',
                                                    array(
                                                        'module'     => 'ratings',
                                                        'controller' => 'rating',
                                                        'action'     => 'down',
                                                        'type'       => 'video',
                                                    )),
        'feedback_entry_rating_down'             => array('feedback/:resource/rating/down',
                                                    array(
                                                        'module'     => 'ratings',
                                                        'controller' => 'rating',
                                                        'action'     => 'down',
                                                        'type'       => 'entry',
                                                    )),
    );
}
