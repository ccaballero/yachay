
/*============================================================================*/
/* Tablas necesarias para el paquete de fotografias                           */
/*============================================================================*/

DROP TABLE IF EXISTS `photo`;
CREATE TABLE `photo` (
    `resource`    int unsigned NOT NULL,
    `description` text         NOT NULL DEFAULT '',
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
('photos', 'photos', 'app', 'files', UNIX_TIMESTAMP(), 'Modulo de gestion de imagenes');

/*============================================================================*/
/* Registro de paginas para el paquete                                        */
/*============================================================================*/
INSERT INTO `page`
(`label`, `title`, `menuable`, `package`, `controller`, `action`, `privilege`, `route`)
VALUES
('Nueva imagen',       'Nueva imagen', TRUE,  'photos', 'manager', 'new',  '', 'photos_new'),
('Visor de imagenes',  '',             FALSE, 'photos', 'photo',   'view', '', 'photos_photo_view'),
('Editor de imagenes', '',             FALSE, 'photos', 'photo',   'edit', '', 'photos_photo_edit');

/*============================================================================*/
/* Registro de rutas para el paquete                                          */
/*============================================================================*/
INSERT INTO `route`
(`label`, `type`, `parent`, `route`, `mapping`, `module`, `controller`, `action`)
VALUES
('Nueva imagen',       'view',   'resources_list',    'photos_new',          'photos/new',           'photos', 'manager', 'new'),
('Visor de imagenes',  'view',   'resources_list',    'photos_photo_view',   'photos/:photo',        'photos', 'photo',   'view'),
('Editor de imagenes', 'view',   'photos_photo_view', 'photos_photo_edit',   'photos/:photo/edit',   'photos', 'photo',   'edit'),
('',                   'action', 'photos_photo_view', 'photos_photo_delete', 'photos/:photo/delete', 'photos', 'photo',   'delete'),
('',                   'action', 'photos_photo_view', 'photos_photo_drop',   'photos/:photo/drop',   'photos', 'photo',   'drop');
