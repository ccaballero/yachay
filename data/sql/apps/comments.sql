
/*============================================================================*/
/* Tablas necesarias para el manejo de comentarios de todos los recursos      */
/*============================================================================*/
DROP TABLE IF EXISTS `comment`;
CREATE TABLE `comment` (
    `ident`      int unsigned NOT NULL auto_increment,
    `resource`   int unsigned NOT NULL,
    `author`     int unsigned NOT NULL,
    `comment`    text         NOT NULL,
    `tsregister` int unsigned NOT NULL,
    PRIMARY KEY (`ident`, `resource`),
    UNIQUE INDEX (`ident`),
    INDEX (`resource`),
    FOREIGN KEY (`resource`) REFERENCES `resource`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT,
    INDEX (`author`),
    FOREIGN KEY (`author`) REFERENCES `user`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT
) DEFAULT CHARACTER SET UTF8;

/*============================================================================*/
/* Registro del paquete                                                       */
/*============================================================================*/
INSERT INTO `package`
(`label`, `url`, `type`, `parent`, `tsregister`, `description`)
VALUES
('comments', 'comments', 'app', 'resources', UNIX_TIMESTAMP(), 'Modulo manejador de comentarios en los recursos disponibles del sistema');

/*============================================================================*/
/* Registro de privilegios para el paquete                                    */
/*============================================================================*/
INSERT INTO `privilege`
(`description`, `package`, `label`)
VALUES
('Publicar comentario',                       'comments', 'new'),
('Ver comentarios',                           'comments', 'view'),
('Eliminar comentario por parte de su autor', 'comments', 'delete'),
('Eliminar cualquier comentario',             'comments', 'drop');


/*============================================================================*/
/* Registro de rutas para el paquete                                          */
/*============================================================================*/
INSERT INTO `route`
(`label`, `type`, `parent`, `route`, `mapping`, `module`, `controller`, `action`)
VALUES
('', 'view',   'notes_note_view',     'notes_note_comment',            'notes/:resource/comment',                     'comments', 'comment', 'new'),
('', 'view',   'links_link_view',     'links_link_comment',            'links/:resource/comment',                     'comments', 'comment', 'new'),
('', 'view',   'files_file_view',     'files_file_comment',            'files/:resource/comment',                     'comments', 'comment', 'new'),
('', 'view',   'events_event_view',   'events_event_comment',          'events/:resource/comment',                    'comments', 'comment', 'new'),
('', 'view',   'photos_photo_view',   'photos_photo_comment',          'photos/:resource/comment',                    'comments', 'comment', 'new'),
('', 'view',   'videos_video_view',   'videos_video_comment',          'videos/:resource/comment',                    'comments', 'comment', 'new'),
('', 'view',   'feedback_entry_view', 'feedback_entry_comment',        'feedback/:resource/comment',                  'comments', 'comment', 'new'),
('', 'action', 'notes_note_view',     'notes_note_comment_delete',     'notes/:resource/comments/:comment/delete',    'comments', 'comment', 'delete'),
('', 'action', 'links_link_view',     'links_link_comment_delete',     'links/:resource/comments/:comment/delete',    'comments', 'comment', 'delete'),
('', 'action', 'files_file_view',     'files_file_comment_delete',     'files/:resource/comments/:comment/delete',    'comments', 'comment', 'delete'),
('', 'action', 'event_event_view',    'events_event_comment_delete',   'events/:resource/comments/:comment/delete',   'comments', 'comment', 'delete'),
('', 'action', 'photos_photo_view',   'photos_photo_comment_delete',   'photos/:resource/comments/:comment/delete',   'comments', 'comment', 'delete'),
('', 'action', 'videos_video_view',   'videos_video_comment_delete',   'videos/:resource/comments/:comment/delete',   'comments', 'comment', 'delete'),
('', 'action', 'feedback_entry_view', 'feedback_entry_comment_delete', 'feedback/:resource/comments/:comment/delete', 'comments', 'comment', 'delete'),
('', 'action', 'base',                'comments_drop',                 'comments/:comment/drop',                      'comments', 'comment', 'drop');
