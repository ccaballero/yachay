
/*====================================================================================================================*/
/* Tablas necesarias para el modulo de themes                                                                         */
/*====================================================================================================================*/

DROP TABLE IF EXISTS `theme`;
CREATE TABLE `theme` (
    `ident`             int unsigned                                                NOT NULL auto_increment,
    `label`             varchar(64)                                                 NOT NULL,
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
('themes',         'themes',           'utility',     UNIX_TIMESTAMP(),   'Modulo manejador de las plantillas web de los usuarios');

/*====================================================================================================================*/
/* Registro de paginas para el modulo                                                                                 */
/*====================================================================================================================*/
INSERT INTO `page`
(`label`,                         `title`,            `menuable`,    `module`,           `controller`,  `action`,           `privilege`,             `route`)
VALUES
('Lista de temas',                'Temas',            TRUE,          'themes',           'index',       'index',            'list',                  'themes_list'),
('Propiedades del tema',          '',                 FALSE,         'themes',           'theme',       'properties',       'switch',                'themes_theme_properties');

/*====================================================================================================================*/
/* Registro de privilegios para el modulo                                                                             */
/*====================================================================================================================*/
INSERT INTO `privilege`
(`label`,                                                         `module`,           `privilege`)
VALUES
('Listar las plantillas disponibles',                             'themes',           'list'),
('Cambiar la plantilla',                                          'themes',           'switch');
