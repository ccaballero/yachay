
/*============================================================================*/
/* Tablas necesarias para el manejo de recursos de aplicacion                 */
/*============================================================================*/
DROP TABLE IF EXISTS `resource`;
CREATE TABLE `resource` (
    `ident`      int unsigned NOT NULL auto_increment,
    `author`     int unsigned NOT NULL,
    `recipient`  varchar(32)  NOT NULL,
    `viewers`    int unsigned NOT NULL DEFAULT 0,
    `comments`   int unsigned NOT NULL DEFAULT 0,
    `ratings`    int          NOT NULL DEFAULT 0,
    `raters`     int unsigned NOT NULL DEFAULT 0,
    `tsregister` int unsigned NOT NULL,
    PRIMARY KEY (`ident`, `author`),
    INDEX (`author`),
    FOREIGN KEY (`author`) REFERENCES `user`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT
) DEFAULT CHARACTER SET UTF8;

DROP TABLE IF EXISTS `resource_global`;
CREATE TABLE `resource_global` (
    `resource` int unsigned NOT NULL,
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
('resources', 'resources', 'app', 'spaces', UNIX_TIMESTAMP(), 'Modulo de registro de los recursos del sistema');

/*============================================================================*/
/* Registro de paginas para el paquete                                        */
/*============================================================================*/
INSERT INTO `page`
(`label`, `title`, `menuable`, `package`, `controller`, `action`, `privilege`, `route`)
VALUES
('Lista de recursos',          'Recursos', TRUE,  'resources', 'index', 'list',     'new', 'resources_list'),
('Lista de recursos por tipo', '',         FALSE, 'resources', 'index', 'filtered', 'new', 'resources_filtered');

/*============================================================================*/
/* Registro de privilegios para el paquete                                    */
/*============================================================================*/
INSERT INTO `privilege`
(`label`, `package`, `privilege`)
VALUES
('Publicar nuevo recurso',                    'resources', 'new'),
('Ver recurso publicado',                     'resources', 'view'),
('Edicion del recurso por parte de su autor', 'resources', 'edit'),
('Eliminar recurso por parte de su autor',    'resources', 'delete'),
('Eliminar cualquier recurso',                'resources', 'drop');

/*============================================================================*/
/* Registro de widgets para el paquete                                        */
/*============================================================================*/
INSERT INTO `widget`
(`label`, `title`, `package`, `script`)
VALUES
('Manejo de recursos', 'Manejo de recursos', 'resources', 'manager');
