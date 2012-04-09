
/*====================================================================================================================*/
/* Registro del modulo                                                                                                */
/*====================================================================================================================*/
INSERT INTO `module`
(`label`,          `url`,              `type`,        `tsregister`,       `description`)
VALUES
('profile',        'profile',          'utility',     UNIX_TIMESTAMP(),   'Modulo para la visualizacion de los datos del usuario');

/*====================================================================================================================*/
/* Registro de paginas para el modulo                                                                                 */
/*====================================================================================================================*/
INSERT INTO `page`
(`label`,                         `title`,            `menuable`,    `module`,           `controller`,  `action`,           `privilege`,             `route`)
VALUES
('Perfil de usuario',             '',                 FALSE,         'profile',          'index',       'view',             '',                      'profile_view'),
('Editar perfil de usuario',      '',                 FALSE,         'profile',          'index',       'edit',             '',                      'profile_edit');
