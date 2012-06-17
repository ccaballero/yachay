
/*============================================================================*/
/* Informacion necesaria para el registro de paquetes                         */
/*============================================================================*/

/*============================================================================*/
/* Registro del paquete                                                       */
/*============================================================================*/
INSERT INTO `package`
(`label`, `url`, `type`, `tsregister`, `description`)
VALUES
('privileges', 'privileges', 'platform', UNIX_TIMESTAMP(), 'Modulo registro de los privileges del sistema');
