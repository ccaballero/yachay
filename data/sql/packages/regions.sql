
/*============================================================================*/
/* Registro del paquete                                                       */
/*============================================================================*/
INSERT INTO `package`
(`label`, `url`, `type`, `dependency`, `tsregister`, `description`)
VALUES
('regions', 'regions', 'middle', 'templates', UNIX_TIMESTAMP(), 'Modulo de configuracion para las regiones por pagina');

/*============================================================================*/
/* Registro de paginas para el paquete                                        */
/*============================================================================*/
INSERT INTO `page`
(`label`, `title`, `menuable`, `package`, `controller`, `action`, `privilege`, `route`)
VALUES
('Lista de regiones',         'Regiones', TRUE, 'regions', 'index',   'index', 'list',   'regions_list'),
('Administrador de regiones', 'Regiones', TRUE, 'regions', 'manager', 'index', 'manage', 'regions_manager');

/*============================================================================*/
/* Registro de privilegios para el paquete                                    */
/*============================================================================*/
INSERT INTO `privilege`
(`label`, `package`, `privilege`)
VALUES
('Listar la configuracion de las regiones por pagina', 'regions', 'list'),
('Configuracion de las regiones por pagina',           'regions', 'manage');
