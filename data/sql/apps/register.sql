
/*============================================================================*/
/* Registro del paquete                                                       */
/*============================================================================*/
INSERT INTO `package`
(`label`, `url`, `type`, `parent`, `tsregister`, `description`)
VALUES
('register', 'register', 'util', 'users', UNIX_TIMESTAMP(), 'Modulo de registro publico de usuarios');

/*============================================================================*/
/* Registro de privilegios para el paquete                                    */
/*============================================================================*/
INSERT INTO `privilege`
(`description`, `package`, `label`)
VALUES
('Registrar una cuenta',                      'register', 'new');

/*============================================================================*/
/* Registro de rutas para el paquete                                          */
/*============================================================================*/
INSERT INTO `route`
(`label`, `type`, `parent`, `route`, `mapping`, `module`, `controller`, `action`)
VALUES
('Registro de usuario', 'view', 'base', 'register', 'register', 'register', 'index', 'index');

INSERT INTO `route_privilege`
(`route`, `package`, `privilege`)
VALUES
('register',     'register', 'new');
