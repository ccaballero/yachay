
/*============================================================================*/
/* Registro del paquete                                                       */
/*============================================================================*/
INSERT INTO `package`
(`label`, `url`, `type`, `dependency`, `tsregister`, `description`)
VALUES
('profile', 'profile', 'util', 'users', UNIX_TIMESTAMP(), 'Modulo para la visualizacion de los datos del usuario');

/*============================================================================*/
/* Registro de paginas para el paquete                                        */
/*============================================================================*/
INSERT INTO `page`
(`label`, `title`, `menuable`, `package`, `controller`, `action`, `privilege`, `route`)
VALUES
('Perfil de usuario',        '', FALSE, 'profile', 'index', 'view', '', 'profile_view'),
('Editar perfil de usuario', '', FALSE, 'profile', 'index', 'edit', '', 'profile_edit');
