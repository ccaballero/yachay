
/*============================================================================*/
/* Registro del paquete                                                       */
/*============================================================================*/
INSERT INTO `package`
(`label`, `url`, `type`, `parent`, `tsregister`, `description`)
VALUES
('widgets', 'widgets', 'middle', 'templates', UNIX_TIMESTAMP(), 'Modulo de configuracion para los widgets de las paginas');

/*============================================================================*/
/* Registro de privilegios para el paquete                                    */
/*============================================================================*/
INSERT INTO `privilege`
(`description`, `package`, `label`)
VALUES
('Listar la configuracion de los widgets por pagina', 'widgets', 'list'),
('Configuracion de las widgets por pagina',           'widgets', 'manage');

/*============================================================================*/
/* Registro de rutas para el paquete                                          */
/*============================================================================*/
INSERT INTO `route`
(`label`, `type`, `parent`, `route`, `mapping`, `module`, `controller`, `action`)
VALUES
('Lista de widgets',         'list', 'base',         'widgets_list',    'widgets',         'widgets', 'index',   'index'),
('Administrador de widgets', 'list', 'widgets_list', 'widgets_manager', 'widgets/manager', 'widgets', 'manager', 'index');

INSERT INTO `route_privilege`
(`route`, `package`, `privilege`)
VALUES
('widgets_list', 'widgets', 'list'),
('widgets_manager', 'widgets', 'manage');

/*============================================================================*/
/* Registro de widgets para el paquete                                        */
/*============================================================================*/
INSERT INTO `widget`
(`label`, `title`, `package`, `script`)
VALUES
('Enlaces', 'Enlaces recomendados', 'widgets', 'quicklinks');
