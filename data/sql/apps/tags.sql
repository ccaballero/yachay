
/*============================================================================*/
/* Tablas necesarias para el paquete de etiquetas                             */
/*============================================================================*/
DROP TABLE IF EXISTS `tag`;
CREATE TABLE `tag` (
    `ident`      int unsigned NOT NULL auto_increment,
    `label`      varchar(64)  NOT NULL,
    `url`        varchar(64)  NOT NULL,
    `weight`     int unsigned NOT NULL DEFAULT 1,
    `tsregister` int unsigned NOT NULL,
    PRIMARY KEY (`ident`),
    UNIQUE INDEX (`label`),
    UNIQUE INDEX (`url`)
) DEFAULT CHARACTER SET UTF8;

DROP TABLE IF EXISTS `tag_resource`;
CREATE TABLE `tag_resource` (
    `tag`      int unsigned NOT NULL,
    `resource` int unsigned NOT NULL,
    PRIMARY KEY (`tag`, `resource`),
    INDEX (`tag`),
    FOREIGN KEY (`tag`) REFERENCES `tag`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT,
    INDEX (`resource`),
    FOREIGN KEY (`resource`) REFERENCES `resource`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT
) DEFAULT CHARACTER SET UTF8;

DROP TABLE IF EXISTS `tag_community`;
CREATE TABLE `tag_community` (
    `tag`       int unsigned NOT NULL,
    `community` int unsigned NOT NULL,
    PRIMARY KEY (`tag`, `community`),
    INDEX (`tag`),
    FOREIGN KEY (`tag`) REFERENCES `tag`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT,
    INDEX (`community`),
    FOREIGN KEY (`community`) REFERENCES `community`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT
) DEFAULT CHARACTER SET UTF8;

DROP TABLE IF EXISTS `tag_user`;
CREATE TABLE `tag_user` (
    `tag`  int unsigned NOT NULL,
    `user` int unsigned NOT NULL,
    PRIMARY KEY (`tag`, `user`),
    INDEX (`tag`),
    FOREIGN KEY (`tag`) REFERENCES `tag`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT,
    INDEX (`user`),
    FOREIGN KEY (`user`) REFERENCES `user`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT
) DEFAULT CHARACTER SET UTF8;

/*============================================================================*/
/* Registro del paquete                                                       */
/*============================================================================*/
INSERT INTO `package`
(`label`, `url`, `type`, `parent`, `tsregister`, `description`)
VALUES
('tags', 'tags', 'util', 'resources', UNIX_TIMESTAMP(), 'Modulo manejador de las etiquetas en todos los recursos disponibles del sistema');

/*============================================================================*/
/* Registro de paginas para el paquete                                        */
/*============================================================================*/
INSERT INTO `page`
(`label`, `title`, `menuable`, `package`, `controller`, `action`, `privilege`, `route`)
VALUES
('Nube de etiquetas',          'Etiquetas', TRUE,  'tags', 'index',   'index', 'list',   'tags_list'),
('Administrador de etiquetas', 'Etiquetas', TRUE,  'tags', 'manager', 'index', 'delete', 'tags_manager'),
('Ver etiqueta',               '',          FALSE, 'tags', 'tag',     'view',  'list',   'tags_tag_view');

/*============================================================================*/
/* Registro de privilegios para el paquete                                    */
/*============================================================================*/
INSERT INTO `privilege`
(`label`, `package`, `privilege`)
VALUES
('Ver nube de etiquetas', 'tags', 'list'),
('Eliminar etiqueta',     'tags', 'delete');
