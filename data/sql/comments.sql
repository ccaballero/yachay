
/*============================================================================*/
/* Tablas necesarias para el manejo de comentarios de todos los recursos      */
/*============================================================================*/
DROP TABLE IF EXISTS `comment`;
CREATE TABLE `comment` (
    `ident`      int unsigned NOT NULL auto_increment,
    `resource`   int unsigned NOT NULL,
    `author`     int unsigned NOT NULL,
    `comment`    text         NOT NULL,
    `tsregister` int unsigned NOT NULL,
    PRIMARY KEY (`ident`, `resource`),
    UNIQUE INDEX (`ident`),
    INDEX (`resource`),
    FOREIGN KEY (`resource`) REFERENCES `resource`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT,
    INDEX (`author`),
    FOREIGN KEY (`author`) REFERENCES `user`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT
) DEFAULT CHARACTER SET UTF8;

/*============================================================================*/
/* Registro del paquete                                                       */
/*============================================================================*/
INSERT INTO `package`
(`label`, `url`, `type`, `tsregister`, `description`)
VALUES
('comments', 'comments', 'application', UNIX_TIMESTAMP(), 'Modulo manejador de los comentarios en todos los recursos disponibles del sistema');

/*============================================================================*/
/* Registro de privilegios para el paquete                                    */
/*============================================================================*/
INSERT INTO `privilege`
(`label`, `package`, `privilege`)
VALUES
('Publicar comentario',                       'comments', 'new'),
('Ver comentarios',                           'comments', 'view'),
('Eliminar comentario por parte de su autor', 'comments', 'delete'),
('Eliminar cualquier comentario',             'comments', 'drop');
