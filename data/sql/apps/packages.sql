
/*============================================================================*/
/* Registro del paquete                                                       */
/*============================================================================*/
INSERT INTO `package`
(`label`, `url`, `type`, `parent`, `tsregister`, `description`)
VALUES
('packages', 'packages', 'base', NULL, UNIX_TIMESTAMP(), 'Modulo registro de los paquetes del sistema');

/*============================================================================*/
/* Registro de privilegios para el paquete                                    */
/*============================================================================*/
INSERT INTO `privilege`
(`description`, `package`, `label`)
VALUES
('Listar los paquetes disponibles',         'packages', 'list'),
('Activar/desactivar paquetes',             'packages', 'lock'),
('Ver las caracteristicas de los paquetes', 'packages', 'view');

/*============================================================================*/
/* Registro de paginas para el paquete                                        */
/*============================================================================*/
INSERT INTO `page`
(`label`, `title`, `menuable`, `package`, `controller`, `action`, `privilege`, `route`)
VALUES
('Lista de paquetes',         'Paquetes', TRUE,  'packages', 'index',   'index', 'list',     'packages_list'),
('Administrador de paquetes', 'Paquetes', TRUE,  'packages', 'manager', 'index', 'new|lock', 'packages_manager'),
('Vista de un paquete',       '',         FALSE, 'packages', 'package', 'view',  '',         'packages_package_view');

/*============================================================================*/
/* Registro de rutas para el paquete                                          */
/*============================================================================*/
INSERT INTO `route`
(`label`, `type`, `parent`, `route`, `mapping`, `module`, `controller`, `action`)
VALUES
('Lista de paquetes',         'list',   'base',                  'packages_list',           'packages',                 'packages', 'index',   'index'),
('Administrador de paquetes', 'list',   'packages_list',         'packages_manager',        'packages/manager',         'packages', 'index',   'manager'),
('',                          'action', 'packages_manager',      'packages_unlock',         'packages/unlock',          'packages', 'manager', 'unlock'),
('',                          'action', 'packages_manager',      'packages_lock',           'packages/lock',            'packages', 'manager', 'lock'),
('Paquete: $package',         'view',   'packages_manager',      'packages_package_view',   'packages/:package',        'packages', 'package', 'view'),
('',                          'action', 'packages_package_view', 'packages_package_unlock', 'packages/:package/unlock', 'packages', 'package', 'unlock'),
('',                          'action', 'packages_package_view', 'packages_package_lock',   'packages/:package/lock',   'packages', 'package', 'lock');

INSERT INTO `route_privilege`
(`route`, `package`, `privilege`)
VALUES
('packages_list',           'packages', 'list'),
('packages_manager',        'packages', 'lock'),
('packages_unlock',         'packages', 'lock'),
('packages_lock',           'packages', 'lock'),
('packages_package_view',   'packages', 'view'),
('packages_package_unlock', 'packages', 'lock'),
('packages_package_lock',   'packages', 'lock');
