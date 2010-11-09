
/*====================================================================================================================*/
/* Tablas necesarias para el modulo de templates                                                                      */
/*====================================================================================================================*/

DROP TABLE IF EXISTS `template`;
CREATE TABLE `template` (
    `ident`             int unsigned                                                NOT NULL auto_increment,
    `label`             varchar(64)                                                 NOT NULL,
    `parent`            varchar(64)                                                 NOT NULL DEFAULT '',
    `description`       text                                                        NOT NULL DEFAULT '',
    `doctype`           varchar(32)                                                 NOT NULL,
    `properties`        text                                                        NOT NULL,
    `tsregister`        int unsigned                                                NOT NULL,
    PRIMARY KEY (`ident`),
    UNIQUE INDEX (`label`)
) DEFAULT CHARACTER SET UTF8;

/*====================================================================================================================*/
/* Registro del modulo                                                                                                */
/*====================================================================================================================*/
INSERT INTO `module`
(`label`,          `url`,              `type`,        `tsregister`,       `description`)
VALUES
('templates',      'templates',        'utility',     UNIX_TIMESTAMP(),   'Modulo manejador de las plantillas web del sistema');

/*====================================================================================================================*/
/* Registro de paginas para el modulo                                                                                 */
/*====================================================================================================================*/
INSERT INTO `page`
(`label`,                         `title`,            `menuable`,    `module`,           `controller`,  `action`,           `privilege`,             `route`)
VALUES
('Lista de temas',                'Temas',            TRUE,          'templates',        'index',       'index',            'list',                  'templates_list'),
('Propiedades del tema',          '',                 FALSE,         'templates',        'template',    'properties',       'switch',                'templates_template_properties');

/*====================================================================================================================*/
/* Registro de privilegios para el modulo                                                                             */
/*====================================================================================================================*/
INSERT INTO `privilege`
(`label`,                                                         `module`,           `privilege`)
VALUES
('Cambiar la plantilla',                                          'templates',        'switch'),
('Personalizar la plantilla',                                     'templates',        'configure');
