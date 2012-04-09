
/*====================================================================================================================*/
/* Registro del modulo                                                                                                */
/*====================================================================================================================*/
INSERT INTO `module`
(`label`,          `url`,              `type`,        `tsregister`,       `description`)
VALUES
('pages',          'pages',            'platform',    UNIX_TIMESTAMP(),   'Modulo de informacion para las paginas registradas');

/*====================================================================================================================*/
/* Registro de paginas para el modulo                                                                                 */
/*====================================================================================================================*/
INSERT INTO `page`
(`label`,                         `title`,            `menuable`,    `module`,           `controller`,  `action`,           `privilege`,             `route`)
VALUES
('Lista de paginas',              'Paginas',          TRUE,          'pages',            'index',       'index',            'list',                  'pages_list'),
('Administrador de paginas',      'Paginas',          TRUE,          'pages',            'manager',     'index',            'manage',                'pages_manager');

/*====================================================================================================================*/
/* Registro de privilegios para el modulo                                                                             */
/*====================================================================================================================*/
INSERT INTO `privilege`
(`label`,                                                         `module`,           `privilege`)
VALUES
('Listar las paginas disponibles',                                'pages',            'list'),
('Configurar los menus del sistema',                              'pages',            'manage');
