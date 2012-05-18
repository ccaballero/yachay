
/*====================================================================================================================*/
/* Tablas requeridas para el registro de modulos                                                                      */
/*====================================================================================================================*/

DROP TABLE IF EXISTS `module`;
CREATE TABLE `module` (
    `ident`             int unsigned                                                NOT NULL auto_increment,
    `label`             varchar(64)                                                 NOT NULL,
    `url`               varchar(64)                                                 NOT NULL,
    `status`            enum('active', 'inactive')                                  NOT NULL DEFAULT 'active',
    `type`              enum('platform', 'middleware', 'application', 'utility')    NOT NULL,
    `description`       text                                                        NOT NULL DEFAULT '',
    `tsregister`        int unsigned                                                NOT NULL,
    PRIMARY KEY (`ident`),
    UNIQUE INDEX (`label`),
    UNIQUE INDEX (`url`)
) DEFAULT CHARACTER SET UTF8;

/*====================================================================================================================*/
/* Registro del modulo                                                                                                */
/*====================================================================================================================*/
INSERT INTO `module`
(`label`,          `url`,              `type`,        `tsregister`,       `description`)
VALUES
('modules',        'modules',          'platform',    UNIX_TIMESTAMP(),   'Modulo registro de los modulos del sistema');

/*====================================================================================================================*/
/* Registro de paginas para el modulo                                                                                 */
/*====================================================================================================================*/
INSERT INTO `page`
(`label`,                         `title`,            `menuable`,    `module`,           `controller`,  `action`,           `privilege`,             `route`)
VALUES
('Lista de modulos',              'Modulos',          TRUE,          'modules',          'index',       'index',            'list',                  'modules_list'),
('Administrador de modulos',      'Modulos',          TRUE,          'modules',          'manager',     'index',            'new|lock',              'modules_manager'),
('Vista de un modulo',            '',                 FALSE,         'modules',          'module',      'view',             '',                      'modules_module_view');

/*====================================================================================================================*/
/* Registro de privilegios para el modulo                                                                             */
/*====================================================================================================================*/
INSERT INTO `privilege`
(`label`,                                                         `module`,           `privilege`)
VALUES
('Listar los modulos disponibles',                                'modules',          'list'),
('Activar/desactivar modulos',                                    'modules',          'lock'),
('Ver las caracteristicas de los modulos',                        'modules',          'view');
