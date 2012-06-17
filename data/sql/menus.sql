
/*============================================================================*/
/* Registro de manejador basico para la region primary                        */
/*============================================================================*/

/*============================================================================*/
/* Registro del paquete                                                       */
/*============================================================================*/
INSERT INTO `package`
(`label`, `url`, `type`, `tsregister`, `description`)
VALUES
('menus', 'menus', 'middleware', UNIX_TIMESTAMP(), 'Modulo utilidad para la region de menus del sistema');

/*============================================================================*/
/* Registro de regiones para el paquete                                       */
/*============================================================================*/
INSERT INTO `region`
(`label`, `package`, `script`, `region`)
VALUES
('Basica', 'menus', 'menubar', 'menubar'),
('Basica', 'menus', 'footer',  'footer');

/*============================================================================*/
/* Registro de widgets para el paquete                                        */
/*============================================================================*/
INSERT INTO `widget`
(`label`, `title`, `package`, `script`)
VALUES
('Enlaces', 'Enlaces recomendados', 'menus', 'quicklinks');
