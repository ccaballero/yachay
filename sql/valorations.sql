
/*====================================================================================================================*/
/* Informacion necesaria para el manejo de valoraciones de los usuarios                                               */
/*====================================================================================================================*/

/*====================================================================================================================*/
/* Registro del modulo                                                                                                */
/*====================================================================================================================*/
INSERT INTO `module`
(`label`,          `url`,              `type`,        `tsregister`,       `description`)
VALUES
('valorations',    'valorations',      'automagic',   UNIX_TIMESTAMP(),   'Modulo manejador de las valoraciones de los usuarios del sistema');
