
/*============================================================================*/
/* Registro del paquete                                                       */
/*============================================================================*/
INSERT INTO `package`
(`label`, `url`, `type`, `parent`, `tsregister`, `description`)
VALUES
('pages', 'pages', 'base', NULL, UNIX_TIMESTAMP(), 'Modulo de informacion para las paginas registradas'),
('routes', 'routes', 'base', NULL, UNIX_TIMESTAMP(), 'Modulo de informacion para las paginas registradas');

/*============================================================================*/
/* Registro de privilegios para el paquete                                    */
/*============================================================================*/
INSERT INTO `privilege`
(`description`, `package`, `label`)
VALUES
('Listar las paginas disponibles',   'pages', 'list'),
('Configurar los menus del sistema', 'pages', 'manage');

/*============================================================================*/
/* Registro de paginas para el paquete                                        */
/*============================================================================*/
-- INSERT INTO `page`
-- (`label`, `title`, `menuable`, `package`, `controller`, `action`, `privilege`, `route`)
-- VALUES
-- ('Lista de paginas',         'Paginas', TRUE, 'pages', 'index',   'index', 'list',   'routes_list'),
-- ('Administrador de paginas', 'Paginas', TRUE, 'pages', 'manager', 'index', 'manage', 'routes_manager');

/*============================================================================*/
/* Registro de paginas para el paquete                                        */
/*============================================================================*/
INSERT INTO `route`
(`label`, `type`, `parent`, `route`, `mapping`, `module`, `controller`, `action`)
VALUES
('Lista de rutas',         'list', 'base',        'routes_list',    'routes',         'pages', 'index',   'index'),
('Administrador de rutas', 'list', 'routes_list', 'routes_manager', 'routes/manager', 'pages', 'manager', 'index');

INSERT INTO `route_privilege`
(`route`, `package`, `privilege`)
VALUES
('routes_list',    'routes', 'list'),
('routes_manager', 'routes', 'manage');
