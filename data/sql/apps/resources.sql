
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
(`label`, `url`, `type`, `parent`, `tsregister`, `description`)
VALUES
('resources', 'resources', 'app', 'pages', UNIX_TIMESTAMP(), 'Modulo de registro de los recursos del sistema');

/*============================================================================*/
/* Registro de privilegios para el paquete                                    */
/*============================================================================*/
INSERT INTO `privilege`
(`description`, `package`, `label`)
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

/*============================================================================*/
/* Registro de rutas para el paquete                                          */
/*============================================================================*/
INSERT INTO `route`
(`label`, `type`, `parent`, `route`, `mapping`, `module`, `controller`, `action`)
VALUES
('Lista de recursos',          'list', 'base',           'resources_list',     'resources',         'resources', 'index', 'list'),
('Lista de recursos por tipo', 'list', 'resources_list', 'resources_filtered', 'resources/:filter', 'resources', 'index', 'filtered');

INSERT INTO `route_privilege`
(`route`, `package`, `privilege`)
VALUES
('resources_list',     'resources', 'new'),
('resources_filtered', 'resources', 'new');
