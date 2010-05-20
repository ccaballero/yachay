
/*====================================================================================================================*/
/* Tablas necesarias para el manejo de comentarios de todos los recursos                                              */
/*====================================================================================================================*/

DROP TABLE IF EXISTS `comment`;
CREATE TABLE `comment` (
    `ident`             int unsigned                                                NOT NULL auto_increment,
    `resource`          int unsigned                                                NOT NULL,
    `author`            int unsigned                                                NOT NULL,
    `comment`           text                                                        NOT NULL,
    `tsregister`        timestamp                                                   NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`ident`, `resource`),
    UNIQUE INDEX (`ident`),
    INDEX (`resource`),
    FOREIGN KEY (`resource`)      REFERENCES `resource`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT,
    INDEX (`author`),
    FOREIGN KEY (`author`)        REFERENCES `user`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT
) DEFAULT CHARACTER SET UTF8;

/*====================================================================================================================*/
/* Registro del modulo                                                                                                */
/*====================================================================================================================*/
INSERT INTO `module`
(`label`,          `url`,              `type`,        `tsregister`,       `description`)
VALUES
('comments',       'comments',         'automagic',   UNIX_TIMESTAMP(),   'Modulo manejador de los comentarios en todos los recursos disponibles del sistema');

/*====================================================================================================================*/
/* Registro de privilegios para el modulo                                                                             */
/*====================================================================================================================*
INSERT INTO `privilege`
(`category`,  `label`,                                                         `module`,           `privilege`,        `delegate`)
VALUES
(6,           'Publicar un comentario',                                        'comments',         'new',              FALSE),
(7,           'Ver comentarios',                                               'comments',         'view',             FALSE),
(6,           'Edicion del comentario por parte de su autor',                  'comments',         'edit',             FALSE),
(6,           'Eliminar comentario por parte de su autor',                     'comments',         'delete',           FALSE),
(3,           'Eliminar cualquier comentario',                                 'comments',         'drop',             FALSE);
*/