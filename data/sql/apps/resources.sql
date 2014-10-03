
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
/* Registro de recurso por espacio                                            */
/*============================================================================*/
DROP TABLE IF EXISTS `user_resource`;
CREATE TABLE `user_resource` (
    `user`     int unsigned NOT NULL,
    `resource` int unsigned NOT NULL,
    PRIMARY KEY (`user`, `resource`),
    INDEX (`user`),
    FOREIGN KEY (`user`) REFERENCES `user`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT,
    INDEX (`resource`),
    FOREIGN KEY (`resource`) REFERENCES `resource`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT
) DEFAULT CHARACTER SET UTF8;

DROP TABLE IF EXISTS `subject_resource`;
CREATE TABLE `subject_resource` (
    `subject`  int unsigned NOT NULL,
    `resource` int unsigned NOT NULL,
    PRIMARY KEY (`subject`, `resource`),
    INDEX (`subject`),
    FOREIGN KEY (`subject`) REFERENCES `subject`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT,
    INDEX (`resource`),
    FOREIGN KEY (`resource`) REFERENCES `resource`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT
) DEFAULT CHARACTER SET UTF8;

DROP TABLE IF EXISTS `area_resource`;
CREATE TABLE `area_resource` (
    `area`     int unsigned NOT NULL,
    `resource` int unsigned NOT NULL,
    PRIMARY KEY (`area`, `resource`),
    INDEX (`area`),
    FOREIGN KEY (`area`) REFERENCES `area`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT,
    INDEX (`resource`),
    FOREIGN KEY (`resource`) REFERENCES `resource`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT
) DEFAULT CHARACTER SET UTF8;

DROP TABLE IF EXISTS `career_resource`;
CREATE TABLE `career_resource` (
    `career`   int unsigned NOT NULL,
    `resource` int unsigned NOT NULL,
    PRIMARY KEY (`career`, `resource`),
    INDEX (`career`),
    FOREIGN KEY (`career`) REFERENCES `career`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT,
    INDEX (`resource`),
    FOREIGN KEY (`resource`) REFERENCES `resource`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT
) DEFAULT CHARACTER SET UTF8;

DROP TABLE IF EXISTS `group_resource`;
CREATE TABLE `group_resource` (
    `group`    int unsigned NOT NULL,
    `resource` int unsigned NOT NULL,
    PRIMARY KEY (`group`, `resource`),
    INDEX (`group`),
    FOREIGN KEY (`group`) REFERENCES `group`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT,
    INDEX (`resource`),
    FOREIGN KEY (`resource`) REFERENCES `resource`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT
) DEFAULT CHARACTER SET UTF8;

DROP TABLE IF EXISTS `team_resource`;
CREATE TABLE `team_resource` (
    `team`     int unsigned NOT NULL,
    `resource` int unsigned NOT NULL,
    PRIMARY KEY (`team`, `resource`),
    INDEX (`team`),
    FOREIGN KEY (`team`) REFERENCES `team`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT,
    INDEX (`resource`),
    FOREIGN KEY (`resource`) REFERENCES `resource`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT
) DEFAULT CHARACTER SET UTF8;

DROP TABLE IF EXISTS `community_resource`;
CREATE TABLE `community_resource` (
    `community` int unsigned NOT NULL,
    `resource`  int unsigned NOT NULL,
    PRIMARY KEY (`community`, `resource`),
    INDEX (`community`),
    FOREIGN KEY (`community`) REFERENCES `community`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT,
    INDEX (`resource`),
    FOREIGN KEY (`resource`) REFERENCES `resource`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT
) DEFAULT CHARACTER SET UTF8;

/*============================================================================*/
/* Registro del paquete                                                       */
/*============================================================================*/
INSERT INTO `package`
(`label`, `url`, `type`, `parent`, `tsregister`, `description`)
VALUES
('resources', 'resources', 'app', 'routes', UNIX_TIMESTAMP(), 'Modulo de registro de los recursos del sistema');

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
