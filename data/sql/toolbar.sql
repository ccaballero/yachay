
/*============================================================================*/
/* Registro de manejador basico para la region toolbar                        */
/*============================================================================*/

/*============================================================================*/
/* Registro del paquete                                                       */
/*============================================================================*/
INSERT INTO `package`
(`label`, `url`, `type`, `tsregister`, `description`)
VALUES
('toolbar', 'toolbar', 'middleware', UNIX_TIMESTAMP(), 'Modulo utilidad para la region toolbar del sistema');

/*============================================================================*/
/* Registro de regiones para el paquete                                       */
/*============================================================================*/
INSERT INTO `region`
(`label`, `package`, `script`, `region`)
VALUES
('Basica', 'toolbar', 'toolbar', 'toolbar');
