
/*============================================================================*/
/* Registro del paquete                                                       */
/*============================================================================*/
INSERT INTO `package`
(`label`, `url`, `type`, `parent`, `tsregister`, `description`)
VALUES
('widgets', 'widgets', 'middle', 'templates', UNIX_TIMESTAMP(), 'Modulo de configuracion para los widgets de las paginas');

/*============================================================================*/
/* Registro de paginas para el paquete                                        */
/*============================================================================*/
INSERT INTO `page`
(`label`, `title`, `menuable`, `package`, `controller`, `action`, `privilege`, `route`)
VALUES
('Lista de widgets',         'Widgets', TRUE, 'widgets', 'index',   'index', 'list',   'widgets_list'),
('Administrador de widgets', 'Widgets', TRUE, 'widgets', 'manager', 'index', 'manage', 'widgets_manager');

/*============================================================================*/
/* Registro de privilegios para el paquete                                    */
/*============================================================================*/
INSERT INTO `privilege`
(`label`, `package`, `privilege`)
VALUES
('Listar la configuracion de los widgets por pagina', 'widgets', 'list'),
('Configuracion de las widgets por pagina',           'widgets', 'manage');
