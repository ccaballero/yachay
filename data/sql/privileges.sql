
/*============================================================================*/
/* Informacion necesaria para el registro de paquetes                         */
/*============================================================================*/

/*============================================================================*/
/* Registro del paquete                                                       */
/*============================================================================*/
INSERT INTO `package`
(`label`, `url`, `type`, `dependency`, `tsregister`, `description`)
VALUES
('privileges', 'privileges', 'base', NULL, UNIX_TIMESTAMP(), 'Modulo registro de los privileges del sistema');
