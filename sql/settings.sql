
/*====================================================================================================================*/
/* Registro del modulo                                                                                                */
/*====================================================================================================================*/
INSERT INTO `module`
(`label`,          `url`,              `type`,        `tsregister`,       `description`)
VALUES
('settings',       'settings',         'utility',     UNIX_TIMESTAMP(),   'Modulo para la configuracion de usuario en el sistema');

/*====================================================================================================================*/
/* Registro de paginas para el modulo                                                                                 */
/*====================================================================================================================*/
INSERT INTO `page`
(`label`,                         `title`,            `menuable`,    `module`,           `controller`,  `action`,           `privilege`,             `route`)
VALUES
('Preferencias de usuario',       '',                 FALSE,         'settings',         'index',       'index',            '',                      'settings');
