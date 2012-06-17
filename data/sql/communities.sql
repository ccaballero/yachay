
/*============================================================================*/
/* Tablas necesarias para el registro de comunidades                          */
/*============================================================================*/
DROP TABLE IF EXISTS `community`;
CREATE TABLE `community` (
    `ident`       int unsigned          NOT NULL auto_increment,
    `author`      int unsigned          NOT NULL DEFAULT 1,
    `label`       varchar(64)           NOT NULL,
    `url`         varchar(64)           NOT NULL,
    `mode`        enum('open', 'close') NOT NULL DEFAULT 'open',
    `members`     int unsigned          NOT NULL DEFAULT 1,
    `petitions`   int unsigned          NOT NULL DEFAULT 0,
    `description` text                  NOT NULL DEFAULT '',
    `tsregister`  int unsigned          NOT NULL,
    PRIMARY KEY (`ident`),
    INDEX (`author`),
    FOREIGN KEY (`author`) REFERENCES `user`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT,
    UNIQUE INDEX (`label`),
    UNIQUE INDEX (`url`)
) DEFAULT CHARACTER SET UTF8;

DROP TABLE IF EXISTS `community_user`;
CREATE TABLE `community_user` (
    `community`  int unsigned                NOT NULL,
    `user`       int unsigned                NOT NULL,
    `type`       enum('moderator', 'member') NOT NULL DEFAULT 'member',
    `status`     enum('active', 'inactive')  NOT NULL DEFAULT 'inactive',
    `tsregister` int unsigned                NOT NULL,
    PRIMARY KEY (`community`, `user`),
    INDEX (`community`),
    FOREIGN KEY (`community`) REFERENCES `community`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT,
    INDEX (`user`),
    FOREIGN KEY (`user`) REFERENCES `user`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT
) DEFAULT CHARACTER SET UTF8;

DROP TABLE IF EXISTS `community_petition`;
CREATE TABLE `community_petition` (
    `community`  int unsigned NOT NULL,
    `user`       int unsigned NOT NULL,
    `tsregister` int unsigned NOT NULL,
    PRIMARY KEY (`community`, `user`),
    INDEX (`community`),
    FOREIGN KEY (`community`) REFERENCES `community`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT,
    INDEX (`user`),
    FOREIGN KEY (`user`) REFERENCES `user`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT
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
(`label`, `url`, `type`, `tsregister`, `description`)
VALUES
('communities', 'communities', 'middleware', UNIX_TIMESTAMP(), 'Modulo manejador de las comunidades');

/*============================================================================*/
/* Registro de paginas para el paquete                                        */
/*============================================================================*/
INSERT INTO `page`
(`label`, `title`, `menuable`, `package`, `controller`, `action`, `privilege`, `route`)
VALUES
('Lista de comunidades',         'Comunidades',     TRUE,  'communities', 'index',     'index', 'list',       'communities_list'),
('Administrador de comunidades', 'Comunidades',     TRUE,  'communities', 'manager',   'index', 'list|enter', 'communities_manager'),
('Nueva comunidad',              'Nueva comunidad', TRUE,  'communities', 'manager',   'new',   'enter',      'communities_new'),
('Vista de una comunidad',       '',                FALSE, 'communities', 'community', 'view',  '',           'communities_community_view'),
('Edicion de una comunidad',     '',                FALSE, 'communities', 'community', 'edit',  '',           'communities_community_edit'),
('Miembros de una comunidad',    '',                FALSE, 'communities', 'assign',    'index', '',           'communities_community_assign'),
('Peticiones de una comunidad',  '',                FALSE, 'communities', 'petition',  'index', '',           'communities_community_petition');

/*============================================================================*/
/* Registro de privilegios para el paquete                                    */
/*============================================================================*/
INSERT INTO `privilege`
(`label`, `package`, `privilege`)
VALUES
('Listar las comunidades disponibles',       'communities', 'list'),
('Crear e ingresar comunidades',             'communities', 'enter'),
('Ver las caracteristicas de una comunidad', 'communities', 'view');
