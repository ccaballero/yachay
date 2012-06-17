
/*============================================================================*/
/* Registro del paquete                                                       */
/*============================================================================*/
INSERT INTO `package`
(`label`, `url`, `type`, `tsregister`, `description`)
VALUES
('analytics', 'analytics', 'application', UNIX_TIMESTAMP(), 'Modulo de visualizacion de estadisticas');

/*============================================================================*/
/* Registro de paginas para el paquete                                        */
/*============================================================================*/
INSERT INTO `page`
(`label`, `title`, `menuable`, `package`, `controller`, `action`, `privilege`, `route`)
VALUES
('Estadisticas', 'Estadisticas', TRUE, 'analytics', 'index', 'index', 'view', 'analytics_view');

/*============================================================================*/
/* Registro de privilegios para el paquete                                    */
/*============================================================================*/
INSERT INTO `privilege`
(`label`, `package`, `privilege`)
VALUES
('Ver las estadisticas del sistema', 'analytics', 'view');
