
/*====================================================================================================================*/
/* Registro del modulo                                                                                                */
/*====================================================================================================================*/
INSERT INTO `module`
(`label`,          `url`,              `type`,        `tsregister`,       `description`)
VALUES
('regions',        'regions',          'platform',    UNIX_TIMESTAMP(),   'Modulo de configuracion para las regiones por pagina');

/*====================================================================================================================*/
/* Registro de paginas para el modulo                                                                                 */
/*====================================================================================================================*/
INSERT INTO `page`
(`label`,                         `title`,            `menuable`,    `module`,           `controller`,  `action`,           `privilege`,             `route`)
VALUES
('Lista de regiones',             'Regiones',         TRUE,          'regions',          'index',       'index',            'list',                  'regions_list'),
('Administrador de regiones',     'Regiones',         TRUE,          'regions',          'manager',     'index',            'manage',                'regions_manager');

/*====================================================================================================================*/
/* Registro de privilegios para el modulo                                                                             */
/*====================================================================================================================*/
INSERT INTO `privilege`
(`label`,                                                         `module`,           `privilege`)
VALUES
('Listar la configuracion de las regiones por pagina',            'regions',          'list'),
('Configuracion de las regiones por pagina',                      'regions',          'manage');
