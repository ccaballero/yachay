
/*============================================================================*/
/* Registro de manejador generico de espacios virtuales                       */
/*============================================================================*/

/*============================================================================*/
/* Registro del paquete                                                       */
/*============================================================================*/
INSERT INTO `package`
(`label`, `url`, `type`, `dependency`, `tsregister`, `description`)
VALUES
('spaces', 'spaces', 'middle', 'pages', UNIX_TIMESTAMP(), 'Modulo generico de espacios virtuales');
