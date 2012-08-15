
/*============================================================================*/
/* Tablas necesarias para el paquete de videos                                */
/*============================================================================*/
DROP TABLE IF EXISTS `video`;
CREATE TABLE `video` (
    `resource`    int unsigned NOT NULL,
    `description` text         NOT NULL DEFAULT '',
    `proportion`  varchar(8)   NOT NULL DEFAULT '1:1',
    `size`        int unsigned NOT NULL,
    `filename`    varchar(64)  NOT NULL,
    `priority`    boolean      NOT NULL DEFAULT FALSE,
    PRIMARY KEY (`resource`),
    INDEX (`resource`),
    FOREIGN KEY (`resource`) REFERENCES `resource`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT
) DEFAULT CHARACTER SET UTF8;

/*============================================================================*/
/* Registro del paquete                                                       */
/*============================================================================*/
INSERT INTO `package`
(`label`, `url`, `type`, `parent`, `tsregister`, `description`)
VALUES
('videos', 'videos', 'app', 'files', UNIX_TIMESTAMP(), 'Modulo de gestion de videos online');

/*============================================================================*/
/* Registro de privilegios para el paquete                                    */
/*============================================================================*/
INSERT INTO `privilege`
(`description`, `package`, `label`)
VALUES
('Subir videos', 'videos', 'upload');

/*============================================================================*/
/* Registro de rutas para el paquete                                          */
/*============================================================================*/
INSERT INTO `route`
(`label`, `type`, `parent`, `route`, `mapping`, `module`, `controller`, `action`)
VALUES
('Nuevo video',       'view',   'resources_list',    'videos_new',          'videos/new',           'videos', 'manager', 'new'),
('Video: $resource',  'view',   'resources_list',    'videos_video_view',   'videos/:video',        'videos', 'video',   'view'),
('Editar: $resource', 'view',   'videos_video_view', 'videos_video_edit',   'videos/:video/edit',   'videos', 'video',   'edit'),
('',                  'action', 'videos_video_view', 'videos_video_delete', 'videos/:video/delete', 'videos', 'video',   'delete'),
('',                  'action', 'videos_video_view', 'videos_video_drop',   'videos/:video/drop',   'videos', 'video',   'drop');
