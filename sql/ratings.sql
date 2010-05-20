
/*====================================================================================================================*/
/* Informacion necesaria para el manejo de puntuaciones de los recursos                                               */
/*====================================================================================================================*/

/*====================================================================================================================*/
/* Registro del modulo                                                                                                */
/*====================================================================================================================*/
INSERT INTO `module`
(`label`,          `url`,              `type`,        `tsregister`,       `description`)
VALUES
('ratings',        'ratings',          'automagic',   UNIX_TIMESTAMP(),   'Modulo manejador de las puntuaciones en todos los recursos disponibles del sistema');

/*====================================================================================================================*/
/* Registro de privilegios para el modulo                                                                             */
/*====================================================================================================================
INSERT INTO `privilege`
(`category`,  `label`,                                                         `module`,           `privilege`,        `delegate`)
VALUES
(6,           'Calificar un recurso',                                          'ratings',          'new',              FALSE);
*/