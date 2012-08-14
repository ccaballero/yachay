
/*============================================================================*/
/* Registro del paquete                                                       */
/*============================================================================*/
INSERT INTO `package`
(`label`, `url`, `type`, `parent`, `tsregister`, `description`)
VALUES
('profile', 'profile', 'util', 'users', UNIX_TIMESTAMP(), 'Modulo para la visualizacion de los datos del usuario');

/*============================================================================*/
/* Registro de paginas para el paquete                                        */
/*============================================================================*/
-- INSERT INTO `page`
-- (`label`, `title`, `menuable`, `package`, `controller`, `action`, `privilege`, `route`)
-- VALUES
-- ('Perfil de usuario',        '', FALSE, 'profile', 'index', 'view', '', 'profile_view'),
-- ('Editar perfil de usuario', '', FALSE, 'profile', 'index', 'edit', '', 'profile_edit');

/*============================================================================*/
/* Registro de rutas para el paquete                                          */
/*============================================================================*/
INSERT INTO `route`
(`label`, `type`, `parent`, `route`, `mapping`, `module`, `controller`, `action`)
VALUES
('Perfil de usuario',        'view', 'base', 'profile_view', 'profile',      'profile', 'index', 'view'),
('Editar perfil de usuario', 'view', 'base', 'profile_edit', 'profile/edit', 'profile', 'index', 'edit');
