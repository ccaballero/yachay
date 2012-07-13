
/*============================================================================*/
/* Registro del paquete                                                       */
/*============================================================================*/
INSERT INTO `package`
(`label`, `url`, `type`, `dependency`, `tsregister`, `description`)
VALUES
('settings', 'settings', 'app', 'users', UNIX_TIMESTAMP(), 'Modulo para la configuracion de usuario en el sistema');

/*============================================================================*/
/* Registro de paginas para el paquete                                        */
/*============================================================================*/
INSERT INTO `page`
(`label`, `title`, `menuable`, `package`, `controller`, `action`, `privilege`, `route`)
VALUES
('Preferencias de usuario', '', FALSE, 'settings', 'index', 'index', '', 'settings');
