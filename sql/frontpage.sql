
/*====================================================================================================================*/
/* Registro de recursos para la pagina principal                                                                      */
/*====================================================================================================================*/

/*====================================================================================================================*/
/* Registro del modulo                                                                                                */
/*====================================================================================================================*/
INSERT INTO `module`
(`label`,          `url`,              `type`,        `tsregister`,       `description`)
VALUES
('frontpage',      'frontpage',        'platform',    UNIX_TIMESTAMP(),   'Modulo manejador de la pagina de inicio');

/*====================================================================================================================*/
/* Registro de paginas para el modulo                                                                                 */
/*====================================================================================================================*/
INSERT INTO `page`
(`label`,                         `title`,            `menuable`,    `module`,           `controller`,  `action`,      `route`)
VALUES
('Pagina inicial',                'Inicio',           TRUE,          'frontpage',        'index',       'visitor',     'frontpage_visitor'),
('Pagina de usuario',             '',                 FALSE,         'frontpage',        'index',       'user',        'frontpage_user');

/*====================================================================================================================*/
/* Registro de widgets para el modulo                                                                                 */
/*====================================================================================================================*/
INSERT INTO `widget`
(`label`,                              `title`,                                `module`,           `script`)
VALUES
('Espacios Disponibles',               'Espacios Disponibles',                 'frontpage',        'context');
