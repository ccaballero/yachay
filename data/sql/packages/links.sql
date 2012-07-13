
/*============================================================================*/
/* Tablas necesarias para el paquete de links                                 */
/*============================================================================*/
DROP TABLE IF EXISTS `link`;
CREATE TABLE `link` (
    `resource`    int unsigned NOT NULL,
    `link`        varchar(256) NOT NULL,
    `description` text         NOT NULL DEFAULT '',
    `priority`    boolean	NOT NULL DEFAULT FALSE,
    PRIMARY KEY (`resource`),
    INDEX (`resource`),
    FOREIGN KEY (`resource`) REFERENCES `resource`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT
) DEFAULT CHARACTER SET UTF8;

/*============================================================================*/
/* Registro del paquete                                                       */
/*============================================================================*/
INSERT INTO `package`
(`label`, `url`, `type`, `dependency`, `tsregister`, `description`)
VALUES
('links', 'links', 'app', 'resources', UNIX_TIMESTAMP(), 'Modulo de gestion de enlaces');

/*============================================================================*/
/* Registro de paginas para el paquete                                        */
/*============================================================================*/
INSERT INTO `page`
(`label`, `title`, `menuable`, `package`, `controller`, `action`, `privilege`, `route`)
VALUES
('Nuevo enlace',      'Nuevo enlace', TRUE,  'links', 'manager', 'new',  '', 'links_new'),
('Visor de enlaces',  '',             FALSE, 'links', 'link',    'view', '', 'links_link_view'),
('Editor de enlaces', '',             FALSE, 'links', 'link',    'edit', '', 'links_link_edit');
