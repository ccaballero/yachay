
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
(`label`, `url`, `type`, `tsregister`, `description`)
VALUES
('photos', 'photos', 'application', UNIX_TIMESTAMP(), 'Modulo de gestion de imagenes');

/*============================================================================*/
/* Registro de paginas para el paquete                                        */
/*============================================================================*/
INSERT INTO `page`
(`label`, `title`, `menuable`, `package`, `controller`, `action`, `privilege`, `route`)
VALUES
('Nueva imagen',       'Nueva imagen', TRUE,  'photos', 'manager', 'new',  '', 'photos_new'),
('Visor de imagenes',  '',             FALSE, 'photos', 'photo',   'view', '', 'photos_photo_view'),
('Editor de imagenes', '',             FALSE, 'photos', 'photo',   'edit', '', 'photos_photo_edit');
