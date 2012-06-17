
/*============================================================================*/
/* Registro del paquete                                                       */
/*============================================================================*/
INSERT INTO `package`
(`label`, `url`, `type`, `dependency`, `tsregister`, `description`)
VALUES
('packages', 'packages', 'base', NULL, UNIX_TIMESTAMP(), 'Modulo registro de los paquetes del sistema');

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
/* Registro de privilegios para el paquete                                    */
/*============================================================================*/
INSERT INTO `privilege`
(`label`, `package`, `privilege`)
VALUES
('Listar los paquetes disponibles',         'packages', 'list'),
('Activar/desactivar paquetes',             'packages', 'lock'),
('Ver las caracteristicas de los paquetes', 'packages', 'view');
