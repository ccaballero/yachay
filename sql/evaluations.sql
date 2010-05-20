
/*====================================================================================================================*/
/* Tablas necesarias para el manejo de los criterios de evaluación de los docentes                                    */
/*====================================================================================================================*/

DROP TABLE IF EXISTS `evaluation`;
CREATE TABLE `evaluation` (
    `ident`             int unsigned                                                NOT NULL auto_increment,
    `author`            int unsigned                                                NOT NULL,
    `label`             varchar(64)                                                 NOT NULL,
    `description`       text                                                        NOT NULL DEFAULT '',
    `access`            enum('public', 'private')                                   NOT NULL DEFAULT 'public',
    `tsregister`        int unsigned                                                NOT NULL,
    `useful`            boolean                                                     NOT NULL DEFAULT FALSE,
    PRIMARY KEY (`ident`, `author`),
    INDEX (`author`),
    FOREIGN KEY (`author`)        REFERENCES `user`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT,
    UNIQUE INDEX (`author`, `label`)
) DEFAULT CHARACTER SET UTF8;

DROP TABLE IF EXISTS `evaluation_test`;
CREATE TABLE `evaluation_test` (
    `ident`             int unsigned                                                NOT NULL auto_increment,
    `evaluation`        int unsigned                                                NOT NULL,
    `label`             varchar(64)                                                 NOT NULL,
    `key`               varchar(4)                                                  NOT NULL,
    `minimumnote`       int unsigned                                                NOT NULL DEFAULT 0,
    `defaultnote`       int unsigned                                                NOT NULL DEFAULT 0,
    `maximumnote`       int unsigned                                                NOT NULL DEFAULT 100,
    `formula`           text                                                        NULL,
    `order`             int unsigned                                                NOT NULL DEFAULT 1,
    PRIMARY KEY (`ident`, `evaluation`),
    INDEX (`evaluation`),
    FOREIGN KEY (`evaluation`)    REFERENCES `evaluation`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT,
    UNIQUE INDEX (`evaluation`, `label`),
    UNIQUE INDEX (`evaluation`, `key`)
) DEFAULT CHARACTER SET UTF8;

DROP TABLE IF EXISTS `evaluation_test_value`;
CREATE TABLE `evaluation_test_value` (
    `ident`             int unsigned                                                NOT NULL auto_increment,
    `evaluation`        int unsigned                                                NOT NULL,
    `test`              int unsigned                                                NOT NULL,
    `label`             varchar(64)                                                 NOT NULL,
    `value`             int unsigned                                                NOT NULL,
    PRIMARY KEY (`evaluation`, `test`, `ident`),
    INDEX (`evaluation`, `test`),
    FOREIGN KEY (`evaluation`, `test`) REFERENCES `evaluation_test`(`evaluation`, `ident`) ON UPDATE CASCADE ON DELETE RESTRICT,
    UNIQUE INDEX (`evaluation`, `test`, `label`),
    UNIQUE INDEX (`evaluation`, `test`, `value`)
) DEFAULT CHARACTER SET UTF8;

/*====================================================================================================================*/
/* Registro del modulo                                                                                                */
/*====================================================================================================================*/
INSERT INTO `module`
(`label`,          `url`,              `type`,        `tsregister`,       `description`)
VALUES
('evaluations',    'evaluations',      'application', UNIX_TIMESTAMP(),   'Modulo manejador de los criterios del sistema');

/*====================================================================================================================*/
/* Registro de paginas para el modulo                                                                                 */
/*====================================================================================================================*/
INSERT INTO `page`
(`label`,                         `title`,            `menuable`,    `module`,           `controller`,  `action`,           `privilege`,             `route`)
VALUES
('Nueva evaluacion',              'Nueva evaluacion', TRUE,          'evaluations',      'manager',     'new',              '',                      'evaluations_new'),
('Vista de una evaluacion',       '',                 FALSE,         'evaluations',      'evaluation',  'view',             '',                      'evaluations_evaluation_view'),
('Edicion de una evaluacion',     '',                 FALSE,         'evaluations',      'evaluation',  'edit',             '',                      'evaluations_evaluation_edit'),
('Agregar calificacion a un criterio', '',            FALSE,         'evaluations',      'test',        'add',              '',                      'evaluations_evaluation_test_add'),
('Configuracion de criterios de evaluacion', '',      FALSE,         'evaluations',      'test',
'config',           '',                      'evaluations_evaluation_test_config');

