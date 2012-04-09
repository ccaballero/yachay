/*====================================================================================================================*/
/* Registro del modulo                                                                                                */
/*====================================================================================================================*/
INSERT INTO `module`
(`label`,          `url`,              `type`,        `tsregister`,       `description`)
VALUES
('widgets',        'widgets',          'platform',    UNIX_TIMESTAMP(),   'Modulo de configuracion para los widgets de las paginas');

/*====================================================================================================================*/
/* Registro de paginas para el modulo                                                                                 */
/*====================================================================================================================*/
INSERT INTO `page`
(`label`,                         `title`,            `menuable`,    `module`,           `controller`,  `action`,           `privilege`,             `route`)
VALUES
('Lista de widgets',              'Widgets',          TRUE,          'widgets',          'index',       'index',            'list',                  'widgets_list'),
('Administrador de widgets',      'Widgets',          TRUE,          'widgets',          'manager',     'index',            'manage',                'widgets_manager');

/*====================================================================================================================*/
/* Registro de privilegios para el modulo                                                                             */
/*====================================================================================================================*/
INSERT INTO `privilege`
(`label`,                                                         `module`,           `privilege`)
VALUES
('Listar la configuracion de los widgets por pagina',             'widgets',          'list'),
('Configuracion de las widgets por pagina',                       'widgets',          'manage');
