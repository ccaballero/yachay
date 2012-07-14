
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
/* Registro de paginas para el paquete                                        */
/*============================================================================*/
INSERT INTO `page`
(`label`, `title`, `menuable`, `package`, `controller`, `action`, `privilege`, `route`)
VALUES
('Nuevo video',      'Nuevo video', TRUE,  'videos', 'manager', 'new',  '', 'videos_new'),
('Visor de videos',  '',            FALSE, 'videos', 'video',   'view', '', 'videos_video_view'),
('Editor de videos', '',            FALSE, 'videos', 'video',   'edit', '', 'videos_video_edit');

/*============================================================================*/
/* Registro de privilegios para el paquete                                    */
/*============================================================================*/
INSERT INTO `privilege`
(`label`, `package`, `privilege`)
VALUES
('Subir videos', 'videos', 'upload');
