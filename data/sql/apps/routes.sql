
/*============================================================================*/
/* Registro del paquete                                                       */
/*============================================================================*/
INSERT INTO `package`
(`label`, `url`, `type`, `parent`, `tsregister`, `description`)
VALUES
('routes', 'routes', 'base', NULL, UNIX_TIMESTAMP(), 'Modulo de informacion para las paginas registradas');

/*============================================================================*/
/* Registro de privilegios para el paquete                                    */
/*============================================================================*/
INSERT INTO `privilege`
(`description`, `package`, `label`)
VALUES
('Listar las paginas disponibles',   'routes', 'list'),
('Configurar los menus del sistema', 'routes', 'manage');

/*============================================================================*/
/* Registro de paginas para el paquete                                        */
/*============================================================================*/
INSERT INTO `route`
(`label`, `type`, `parent`, `route`, `mapping`, `module`, `controller`, `action`)
VALUES
('Lista de rutas',         'list', 'base',        'routes_list',    'routes',         'routes', 'index',   'index'),
('Administrador de rutas', 'list', 'routes_list', 'routes_manager', 'routes/manager', 'routes', 'manager', 'index');

INSERT INTO `route_privilege`
(`route`, `package`, `privilege`)
VALUES
('routes_list',    'routes', 'list'),
('routes_manager', 'routes', 'manage');
