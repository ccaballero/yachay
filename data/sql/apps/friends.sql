
/*============================================================================*/
/* Tablas necesarias para el paquete de friends                               */
/*============================================================================*/
DROP TABLE IF EXISTS `friend`;
CREATE TABLE `friend` (
    `user`       int unsigned NOT NULL,
    `friend`     int unsigned NOT NULL,
    `mutual`     boolean      NOT NULL DEFAULT FALSE,
    `tsregister` int unsigned NOT NULL,
    PRIMARY KEY (`user`, `friend`),
    INDEX (`user`),
    FOREIGN KEY (`user`) REFERENCES `user`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT,
    INDEX (`friend`),
    FOREIGN KEY (`friend`) REFERENCES `user`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT
) DEFAULT CHARACTER SET UTF8;

/*============================================================================*/
/* Registro del paquete                                                       */
/*============================================================================*/
INSERT INTO `package`
(`label`, `url`, `type`, `parent`, `tsregister`, `description`)
VALUES
('friends', 'friends', 'middle', 'users', UNIX_TIMESTAMP(), 'Modulo de conecciones entre usuarios');

/*============================================================================*/
/* Registro de privilegios para el paquete                                    */
/*============================================================================*/
INSERT INTO `privilege`
(`description`, `package`, `label`)
VALUES
('Agregar contactos', 'friends', 'contact');

/*============================================================================*/
/* Registro de paginas para el paquete                                        */
/*============================================================================*/
INSERT INTO `page`
(`label`, `title`, `menuable`, `package`, `controller`, `action`, `privilege`, `route`)
VALUES
('Lista de contactos',   'Contactos',   TRUE, 'friends', 'index', 'friends',    'contact', 'friends_friends'),
('Lista de solicitudes', 'Solicitudes', TRUE, 'friends', 'index', 'followings', 'contact', 'friends_followings'),
('Lista de peticiones',  'Peticiones',  TRUE, 'friends', 'index', 'followers',  'contact', 'friends_followers');

/*============================================================================*/
/* Registro de widgets para el paquete                                        */
/*============================================================================*/
INSERT INTO `widget`
(`label`, `title`, `package`, `script`)
VALUES
('Lista de contactos', 'Contactos', 'friends', 'contacts');
