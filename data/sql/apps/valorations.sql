
/*============================================================================*/
/* Informacion necesaria para el manejo de valoraciones de los usuarios       */
/*============================================================================*/

/*============================================================================*/
/* Registro del paquete                                                       */
/*============================================================================*/
INSERT INTO `package`
(`label`, `url`, `type`, `parent`, `tsregister`, `description`)
VALUES
('valorations', 'valorations', 'app', 'resources', UNIX_TIMESTAMP(), 'Modulo manejador de las valoraciones de los usuarios del sistema');
