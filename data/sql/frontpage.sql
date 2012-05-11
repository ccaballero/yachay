
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
(`label`,                         `title`,             `menuable`,    `module`,           `controller`,  `action`,      `route`)
VALUES
('Pagina inicial',                'Inicio',            TRUE,          'frontpage',        'index',       'visitor',     'frontpage_visitor'),
('Pagina de usuario',             '',                  FALSE,         'frontpage',        'index',       'user',        'frontpage_user'),
('Pagina 404',                    '',                  FALSE,         'frontpage',        'error',       'error',       'default'),
('Colabora',                      'Desarrollo',        TRUE,          'frontpage',        'static',      'development', 'frontpage_development'),
('Terminos de uso',               'Terminos de uso',   TRUE,          'frontpage',        'static',      'terms',       'frontpage_terms'),
('Politica de privacidad',        'Privacidad',        TRUE,          'frontpage',        'static',      'privacy',     'frontpage_privacy');

/*====================================================================================================================*/
/* Registro de widgets para el modulo                                                                                 */
/*====================================================================================================================*/
INSERT INTO `widget`
(`label`,                              `title`,                                `module`,           `script`)
VALUES
('Espacios Disponibles',               'Espacios Disponibles',                 'frontpage',        'context');
