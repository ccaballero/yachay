
/*============================================================================*/
/* Tablas necesarias para el manejo de los criterios de evaluación            */
/*============================================================================*/
DROP TABLE IF EXISTS `evaluation`;
CREATE TABLE `evaluation` (
    `ident`       int unsigned              NOT NULL auto_increment,
    `author`      int unsigned              NOT NULL,
    `label`       varchar(64)               NOT NULL,
    `description` text                      NOT NULL DEFAULT '',
    `access`      enum('public', 'private') NOT NULL DEFAULT 'public',
    `tsregister`  int unsigned              NOT NULL,
    `useful`      boolean                   NOT NULL DEFAULT FALSE,
    PRIMARY KEY (`ident`, `author`),
    INDEX (`author`),
    FOREIGN KEY (`author`) REFERENCES `user`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT,
    UNIQUE INDEX (`author`, `label`)
) DEFAULT CHARACTER SET UTF8;

DROP TABLE IF EXISTS `evaluation_test`;
CREATE TABLE `evaluation_test` (
    `ident`       int unsigned NOT NULL auto_increment,
    `evaluation`  int unsigned NOT NULL,
    `label`       varchar(64)  NOT NULL,
    `key`         varchar(4)   NOT NULL,
    `minimumnote` int unsigned NOT NULL DEFAULT 0,
    `defaultnote` int unsigned NOT NULL DEFAULT 0,
    `maximumnote` int unsigned NOT NULL DEFAULT 100,
    `formula`     text         NULL,
    `order`       int unsigned NOT NULL DEFAULT 1,
    PRIMARY KEY (`ident`, `evaluation`),
    INDEX (`evaluation`),
    FOREIGN KEY (`evaluation`) REFERENCES `evaluation`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT,
    UNIQUE INDEX (`evaluation`, `label`),
    UNIQUE INDEX (`evaluation`, `key`)
) DEFAULT CHARACTER SET UTF8;

DROP TABLE IF EXISTS `evaluation_test_value`;
CREATE TABLE `evaluation_test_value` (
    `ident`      int unsigned NOT NULL auto_increment,
    `evaluation` int unsigned NOT NULL,
    `test`       int unsigned NOT NULL,
    `label`      varchar(64)  NOT NULL,
    `value`      int unsigned NOT NULL,
    PRIMARY KEY (`evaluation`, `test`, `ident`),
    INDEX (`evaluation`, `test`),
    FOREIGN KEY (`evaluation`, `test`) REFERENCES `evaluation_test`(`evaluation`, `ident`) ON UPDATE CASCADE ON DELETE RESTRICT,
    UNIQUE INDEX (`evaluation`, `test`, `label`),
    UNIQUE INDEX (`evaluation`, `test`, `value`)
) DEFAULT CHARACTER SET UTF8;

/*============================================================================*/
/* Registro del paquete                                                       */
/*============================================================================*/
INSERT INTO `package`
(`label`, `url`, `type`, `parent`, `tsregister`, `description`)
VALUES
('evaluations', 'evaluations', 'app', 'groups', UNIX_TIMESTAMP(), 'Modulo manejador de los criterios del sistema');

/*============================================================================*/
/* Registro de rutas para el paquete                                          */
/*============================================================================*/
INSERT INTO `route`
(`label`, `type`, `parent`, `route`, `mapping`, `module`, `controller`, `action`)
VALUES
('Nueva evaluación',                         '', '', 'evaluations_new',                          'evaluations/new',                             'evaluations', 'manager',    'new'),
('Evaluador de formulas',                    '', '', 'evaluations_sandbox',                      'evaluations/sandbox',                         'evaluations', 'manager',    'sandbox'),
('Vista de una evaluación',                  '', '', 'evaluations_evaluation_view',              'evaluations/:evaluation',                     'evaluations', 'evaluation', 'view'),
('Agregar calificación a un criterio',       '', '', 'evaluations_evaluation_test_add',          'evaluations/:evaluation/add',                 'evaluations', 'test',       'add'),
('Edición de una evaluación',                '', '', 'evaluations_evaluation_edit',              'evaluations/:evaluation/edit',                'evaluations', 'evaluation', 'edit'),
('',                                         '', '', 'evaluations_evaluation_delete',            'evaluations/:evaluation/delete',              'evaluations', 'evaluation', 'delete'),
('Configuración de criterios de evaluación', '', '', 'evaluations_evaluation_test_config',       'evaluations/:evaluation/:test',               'evaluations', 'test',       'config'),
('',                                         '', '', 'evaluations_evaluation_test_delete',       'evaluations/:evaluation/:test/delete',        'evaluations', 'test',       'delete'),
('',                                         '', '', 'evaluations_evaluation_test_value_delete', 'evaluations/:evaluation/:test/:value/delete', 'evaluations', 'test',       'value');
