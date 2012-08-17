
/*============================================================================*/
/* Registro de manejador generico de espacios virtuales                       */
/*============================================================================*/

/*============================================================================*/
/* Registro del paquete                                                       */
/*============================================================================*/
INSERT INTO `package`
(`label`, `url`, `type`, `parent`, `tsregister`, `description`)
VALUES
('spaces', 'spaces', 'middle', 'routes', UNIX_TIMESTAMP(), 'Modulo generico de espacios virtuales');

/*============================================================================*/
/* Registro de rutas para el paquete                                          */
/*============================================================================*/
-- INSERT INTO `route`
-- (`label`, `type`, `parent`, `route`, `mapping`, `module`, `controller`, `action`)
-- VALUES
