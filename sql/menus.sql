
/*====================================================================================================================*/
/* Registro de manejador basico para la region primary                                                                */
/*====================================================================================================================*/

/*====================================================================================================================*/
/* Registro del modulo                                                                                                */
/*====================================================================================================================*/
INSERT INTO `module`
(`label`,          `url`,              `type`,        `tsregister`,       `description`)
VALUES
('menus',          'menus',            'middleware',  UNIX_TIMESTAMP(),   'Modulo utilidad para la region de menus del sistema');

/*====================================================================================================================*/
/* Registro de regiones para el modulo                                                                                */
/*====================================================================================================================*/
INSERT INTO `region`
(`label`,          `module`,           `script`,           `region`)
VALUES
('Basica',         'menus',            'menubar.php',      'menubar'),
('Basica',         'menus',            'footer.php',       'footer');

/*====================================================================================================================*/
/* Registro de widgets para el modulo                                                                                 */
/*====================================================================================================================*/
INSERT INTO `widget`
(`label`,                              `title`,                                `module`,           `script`)
VALUES
('Enlaces',                            'Enlaces recomendados',                 'menus',            'quicklinks');
