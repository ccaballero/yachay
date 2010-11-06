
/*====================================================================================================================*/
/* Tablas necesarias para el registro de materias                                                                     */
/*====================================================================================================================*/

DROP TABLE IF EXISTS `subject`;
CREATE TABLE `subject` (
    `ident`             int unsigned                                                NOT NULL auto_increment,
    `gestion`           int unsigned                                                NOT NULL,
    `author`            int unsigned                                                NOT NULL DEFAULT 1,
    `moderator`         int unsigned                                                NOT NULL,
    `code`              varchar(16)                                                 NOT NULL,
    `label`             varchar(64)                                                 NOT NULL,
    `url`               varchar(64)                                                 NOT NULL,
    `status`            enum('active', 'inactive')                                  NOT NULL DEFAULT 'inactive',
    `visibility`        enum('public', 'register', 'private')                       NOT NULL DEFAULT 'private',
    `description`       text                                                        NOT NULL DEFAULT '',
    `tsregister`        int unsigned                                                NOT NULL,
    PRIMARY KEY (`ident`, `gestion`),
    UNIQUE INDEX (`ident`),
    INDEX (`gestion`),
    FOREIGN KEY (`gestion`)       REFERENCES `gestion`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT,
    INDEX (`author`),
    FOREIGN KEY (`author`)        REFERENCES `user`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT,
    INDEX (`moderator`),
    FOREIGN KEY (`moderator`)     REFERENCES `user`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT,
    UNIQUE INDEX (`gestion`, `code`),
    UNIQUE INDEX (`gestion`, `label`),
    UNIQUE INDEX (`gestion`, `url`)
) DEFAULT CHARACTER SET UTF8;

DROP TABLE IF EXISTS `subject_user`;
CREATE TABLE `subject_user` (
    `subject`           int unsigned                                                NOT NULL,
    `user`              int unsigned                                                NOT NULL,
    `type`              enum('teacher', 'auxiliar', 'student', 'guest')             NOT NULL,
    `status`            enum('active', 'inactive')                                  NOT NULL DEFAULT 'inactive',
    `tsregister`        int unsigned                                                NOT NULL,
    PRIMARY KEY (`subject`, `user`),
    INDEX (`subject`),
    FOREIGN KEY (`subject`)       REFERENCES `subject`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT,
    INDEX (`user`),
    FOREIGN KEY (`user`)          REFERENCES `user`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT
) DEFAULT CHARACTER SET UTF8;

DROP TABLE IF EXISTS `subject_resource`;
CREATE TABLE `subject_resource` (
    `subject`           int unsigned                                                NOT NULL,
    `resource`          int unsigned                                                NOT NULL,
    PRIMARY KEY (`subject`, `resource`),
    INDEX (`subject`),
    FOREIGN KEY (`subject`)       REFERENCES `subject`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT,
    INDEX (`resource`),
    FOREIGN KEY (`resource`)      REFERENCES `resource`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT
) DEFAULT CHARACTER SET UTF8;

/*====================================================================================================================*/
/* Registro del modulo                                                                                                */
/*====================================================================================================================*/
INSERT INTO `module`
(`label`,          `url`,              `type`,        `tsregister`,       `description`)
VALUES
('subjects',       'subjects',         'middleware',  UNIX_TIMESTAMP(),   'Modulo manejador de las materias');

/*====================================================================================================================*/
/* Registro de paginas para el modulo                                                                                 */
/*====================================================================================================================*/
INSERT INTO `page`
(`label`,                            `title`,            `menuable`,    `module`,           `controller`,  `action`,           `privilege`,             `route`)
VALUES
('Lista de materias',                'Materias',         TRUE,          'subjects',         'index',       'index',            'list',                  'subjects_list'),
('Administrador de materias',        'Materias',         TRUE,          'subjects',         'manager',     'index',            'new|lock|delete',       'subjects_manager'),
('Nueva materia',                    'Nueva materia',    TRUE,          'subjects',         'manager',     'new',              'new',                   'subjects_new'),
('Importar materias',                'Imp. materias',    TRUE,          'subjects',         'manager',     'import',           'import',                'subjects_import'),
('Exportar materias',                'Exp. materias',    TRUE,          'subjects',         'manager',     'export',           'export',                'subjects_export'),
('Vista de una materia',             '',                 FALSE,         'subjects',         'subject',     'view',             '',                      'subjects_subject_view'),
('Edicion de una materia',           '',                 FALSE,         'subjects',         'subject',     'edit',             '',                      'subjects_subject_edit'),
('Miembros de una materia',          '',                 FALSE,         'subjects',         'assign',      'index',            '',                      'subjects_subject_assign'),
('Agregar miembros a una materia',   '',                 FALSE,         'subjects',         'assign',      'new',              '',                      'subjects_subject_assign_new'),
('Importar miembros a una materia',  '',                 FALSE,         'subjects',         'assign',      'import',           '',                      'subjects_subject_assign_import'),
('Exportar miembros de una materia', '',                 FALSE,         'subjects',         'assign',      'export',           '',                      'subjects_subject_assign_export');

/*====================================================================================================================*/
/* Registro de privilegios para el modulo                                                                             */
/*====================================================================================================================*/
INSERT INTO `privilege`
(`label`,                                                         `module`,           `privilege`)
VALUES
('Listar las materias disponibles',                               'subjects',         'list'),
('Crear nuevas materias',                                         'subjects',         'new'),
('Importar materias',                                             'subjects',         'import'),
('Exportar materias',                                             'subjects',         'export'),
('Ver las caracteristicas de una materia',                        'subjects',         'view'),
('Editar las caracteristicas de una materia',                     'subjects',         'edit'),
('Activar/desactivar materias',                                   'subjects',         'lock'),
('Eliminar materias',                                             'subjects',         'delete'),
('Ser moderador de materias',                                     'subjects',         'moderate'),
('Ser docente de materias',                                       'subjects',         'teach'),
('Ser auxiliar de materias',                                      'subjects',         'helper'),
('Ser estudiante de materias',                                    'subjects',         'study'),
('Ser visitante de materias',                                     'subjects',         'participate');
