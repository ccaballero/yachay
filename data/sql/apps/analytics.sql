
/*============================================================================*/
/* Registro del paquete                                                       */
/*============================================================================*/
INSERT INTO `package`
(`label`, `url`, `type`, `parent`, `tsregister`, `description`)
VALUES
('analytics', 'analytics', 'app', NULL, UNIX_TIMESTAMP(), 'Modulo de visualizacion de estadisticas');

/*============================================================================*/
/* Registro de privilegios para el paquete                                    */
/*============================================================================*/
INSERT INTO `privilege`
(`description`, `package`, `label`)
VALUES
('Ver las estadisticas del sistema', 'analytics', 'view');

/*============================================================================*/
/* Registro de paginas para el paquete                                        */
/*============================================================================*/
-- INSERT INTO `page`
-- (`label`, `title`, `menuable`, `package`, `controller`, `action`, `privilege`, `route`)
-- VALUES
-- ('Estadisticas', 'Estadisticas', TRUE, 'analytics', 'index', 'index', 'view', 'analytics_view');
-- 
/*============================================================================*/
/* Registro de rutas para el paquete                                          */
/*============================================================================*/
INSERT INTO `route`
(`label`, `type`, `parent`, `route`, `mapping`, `module`, `controller`, `action`)
VALUES
('Estadisticas', 'view', 'base', 'analytics_view', 'analytics/:page', 'analytics', 'index', 'index');
