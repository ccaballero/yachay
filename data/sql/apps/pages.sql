
/*============================================================================*/
/* Registro del paquete                                                       */
/*============================================================================*/
INSERT INTO `package`
(`label`, `url`, `type`, `parent`, `tsregister`, `description`)
VALUES
('pages', 'pages', 'base', NULL, UNIX_TIMESTAMP(), 'Modulo de informacion para las paginas registradas');

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
INSERT INTO `page`
(`label`, `title`, `menuable`, `package`, `controller`, `action`, `privilege`, `route`)
VALUES
('Lista de paginas',         'Paginas', TRUE, 'pages', 'index',   'index', 'list',   'pages_list'),
('Administrador de paginas', 'Paginas', TRUE, 'pages', 'manager', 'index', 'manage', 'pages_manager');
