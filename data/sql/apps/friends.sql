
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
-- INSERT INTO `page`
-- (`label`, `title`, `menuable`, `package`, `controller`, `action`, `privilege`, `route`)
-- VALUES
-- ('Lista de contactos',   'Contactos',   TRUE, 'friends', 'index', 'friends',    'contact', 'friends_friends'),
-- ('Lista de solicitudes', 'Solicitudes', TRUE, 'friends', 'index', 'followings', 'contact', 'friends_followings'),
-- ('Lista de peticiones',  'Peticiones',  TRUE, 'friends', 'index', 'followers',  'contact', 'friends_followers');

/*============================================================================*/
/* Registro de widgets para el paquete                                        */
/*============================================================================*/
INSERT INTO `widget`
(`label`, `title`, `package`, `script`)
VALUES
('Lista de contactos', 'Contactos', 'friends', 'contacts');

/*============================================================================*/
/* Registro de rutas para el paquete                                          */
/*============================================================================*/
INSERT INTO `route`
(`label`, `type`, `parent`, `route`, `mapping`, `module`, `controller`, `action`)
VALUES
('Lista de contactos',   'list',   'base',            'friends_friends',    'friends',              'friends', 'index',  'friends'),
('Lista de solicitudes', 'list',   'friends_friends', 'friends_followings', 'friends/followings',   'friends', 'index',  'followings'),
('Lista de peticiones',  'list',   'friends_friends', 'friends_followers',  'friends/followers',    'friends', 'index',  'followers'),
('',                     'action', 'friends_friends', 'friends_add',        'friends/:user/add',    'friends', 'friend', 'add'),
('',                     'action', 'friends_friends', 'friends_delete',     'friends/:user/delete', 'friends', 'friend', 'delete');
