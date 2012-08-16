
/*============================================================================*/
/* Tablas necesarias para el manejo de comentarios de todos los recursos      */
/*============================================================================*/

DROP TABLE IF EXISTS `rating`;
CREATE TABLE `rating` (
    `resource` int unsigned NOT NULL,
    `author`   int unsigned NOT NULL,
    `rating`   boolean      NOT NULL,
    PRIMARY KEY (`resource`, `author`),
    INDEX (`resource`),
    FOREIGN KEY (`resource`) REFERENCES `resource`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT,
    INDEX (`author`),
    FOREIGN KEY (`author`) REFERENCES `user`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT
) DEFAULT CHARACTER SET UTF8;

/*============================================================================*/
/* Registro de privilegios para el paquete                                    */
/*============================================================================*/
INSERT INTO `privilege`
(`description`, `package`, `label`)
VALUES
('Calificar un recurso', 'ratings', 'new');

/*============================================================================*/
/* Registro del paquete                                                       */
/*============================================================================*/
INSERT INTO `package`
(`label`, `url`, `type`, `parent`, `tsregister`, `description`)
VALUES
('ratings', 'ratings', 'util', 'resources', UNIX_TIMESTAMP(), 'Modulo manejador de las puntuaciones en todos los recursos disponibles del sistema');

/*============================================================================*/
/* Registro de rutas para el paquete                                          */
/*============================================================================*/
INSERT INTO `route`
(`label`, `type`, `parent`, `route`, `mapping`, `module`, `controller`, `action`)
VALUES
('', 'action', '', 'notes_note_rating_up',       'notes/:resource/rating/up',      'ratings', 'rating', 'up'),
('', 'action', '', 'links_link_rating_up',       'links/:resource/rating/up',      'ratings', 'rating', 'up'),
('', 'action', '', 'files_file_rating_up',       'files/:resource/rating/up',      'ratings', 'rating', 'up'),
('', 'action', '', 'events_event_rating_up',     'events/:resource/rating/up',     'ratings', 'rating', 'up'),
('', 'action', '', 'photos_photo_rating_up',     'photos/:resource/rating/up',     'ratings', 'rating', 'up'),
('', 'action', '', 'videos_video_rating_up',     'videos/:resource/rating/up',     'ratings', 'rating', 'up'),
('', 'action', '', 'feedback_entry_rating_up',   'feedback/:resource/rating/up',   'ratings', 'rating', 'up'),
('', 'action', '', 'notes_note_rating_down',     'notes/:resource/rating/down',    'ratings', 'rating', 'down'),
('', 'action', '', 'links_link_rating_down',     'links/:resource/rating/down',    'ratings', 'rating', 'down'),
('', 'action', '', 'files_file_rating_down',     'files/:resource/rating/down',    'ratings', 'rating', 'down'),
('', 'action', '', 'events_event_rating_down',   'events/:resource/rating/down',   'ratings', 'rating', 'down'),
('', 'action', '', 'photos_photo_rating_down',   'photos/:resource/rating/down',   'ratings', 'rating', 'down'),
('', 'action', '', 'videos_video_rating_down',   'videos/:resource/rating/down',   'ratings', 'rating', 'down'),
('', 'action', '', 'feedback_entry_rating_down', 'feedback/:resource/rating/down', 'ratings', 'rating', 'down');
