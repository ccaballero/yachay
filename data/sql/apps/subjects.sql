
/*============================================================================*/
/* Tablas necesarias para el registro de materias                             */
/*============================================================================*/
DROP TABLE IF EXISTS `subject`;
CREATE TABLE `subject` (
    `ident`       int unsigned                          NOT NULL auto_increment,
    `gestion`     int unsigned                          NOT NULL,
    `author`      int unsigned                          NOT NULL DEFAULT 1,
    `moderator`   int unsigned                          NOT NULL,
    `code`        varchar(16)                           NOT NULL,
    `label`       varchar(64)                           NOT NULL,
    `url`         varchar(64)                           NOT NULL,
    `status`      enum('active', 'inactive')            NOT NULL DEFAULT 'inactive',
    `visibility`  enum('public', 'register', 'private') NOT NULL DEFAULT 'private',
    `description` text                                  NOT NULL DEFAULT '',
    `tsregister`  int unsigned                          NOT NULL,
    PRIMARY KEY (`ident`, `gestion`),
    UNIQUE INDEX (`ident`),
    INDEX (`gestion`),
    FOREIGN KEY (`gestion`) REFERENCES `gestion`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT,
    INDEX (`author`),
    FOREIGN KEY (`author`) REFERENCES `user`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT,
    INDEX (`moderator`),
    FOREIGN KEY (`moderator`) REFERENCES `user`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT,
    UNIQUE INDEX (`gestion`, `code`),
    UNIQUE INDEX (`gestion`, `label`),
    UNIQUE INDEX (`gestion`, `url`)
) DEFAULT CHARACTER SET UTF8;

DROP TABLE IF EXISTS `subject_user`;
CREATE TABLE `subject_user` (
    `subject`    int unsigned                                    NOT NULL,
    `user`       int unsigned                                    NOT NULL,
    `type`       enum('teacher', 'auxiliar', 'student', 'guest') NOT NULL,
    `status`     enum('active', 'inactive')                      NOT NULL DEFAULT 'active',
    `tsregister` int unsigned                                    NOT NULL,
    PRIMARY KEY (`subject`, `user`),
    INDEX (`subject`),
    FOREIGN KEY (`subject`) REFERENCES `subject`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT,
    INDEX (`user`),
    FOREIGN KEY (`user`) REFERENCES `user`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT
) DEFAULT CHARACTER SET UTF8;

DROP TABLE IF EXISTS `subject_resource`;
CREATE TABLE `subject_resource` (
    `subject`  int unsigned NOT NULL,
    `resource` int unsigned NOT NULL,
    PRIMARY KEY (`subject`, `resource`),
    INDEX (`subject`),
    FOREIGN KEY (`subject`) REFERENCES `subject`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT,
    INDEX (`resource`),
    FOREIGN KEY (`resource`) REFERENCES `resource`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT
) DEFAULT CHARACTER SET UTF8;

/*============================================================================*/
/* Registro del paquete                                                       */
/*============================================================================*/
INSERT INTO `package`
(`label`, `url`, `type`, `parent`, `tsregister`, `description`)
VALUES
('subjects', 'subjects', 'middle', 'gestions', UNIX_TIMESTAMP(), 'Modulo manejador de las materias');

/*============================================================================*/
/* Registro de privilegios para el paquete                                    */
/*============================================================================*/
INSERT INTO `privilege`
(`description`, `package`, `label`)
VALUES
('Listar las materias disponibles',           'subjects', 'list'),
('Crear nuevas materias',                     'subjects', 'new'),
('Importar materias',                         'subjects', 'import'),
('Exportar materias',                         'subjects', 'export'),
('Ver las caracteristicas de una materia',    'subjects', 'view'),
('Editar las caracteristicas de una materia', 'subjects', 'edit'),
('Activar/desactivar materias',               'subjects', 'lock'),
('Eliminar materias',                         'subjects', 'delete'),
('Ser moderador de materias',                 'subjects', 'moderate'),
('Ser docente de materias',                   'subjects', 'teach'),
('Ser auxiliar de materias',                  'subjects', 'helper'),
('Ser estudiante de materias',                'subjects', 'study'),
('Ser visitante de materias',                 'subjects', 'participate');

/*============================================================================*/
/* Registro de paginas para el paquete                                        */
/*============================================================================*/
INSERT INTO `page`
(`label`, `title`, `menuable`, `package`, `controller`, `action`, `privilege`, `route`)
VALUES
('Lista de materias',                'Materias',      TRUE,  'subjects', 'index',   'index',  'list',            'subjects_list'),
('Administrador de materias',        'Materias',      TRUE,  'subjects', 'manager', 'index',  'new|lock|delete', 'subjects_manager'),
('Nueva materia',                    'Nueva materia', TRUE,  'subjects', 'manager', 'new',    'new',             'subjects_new'),
('Importar materias',                'Imp. materias', TRUE,  'subjects', 'manager', 'import', 'import',          'subjects_import'),
('Exportar materias',                'Exp. materias', TRUE,  'subjects', 'manager', 'export', 'export',          'subjects_export'),
('Vista de una materia',             '',              FALSE, 'subjects', 'subject', 'view',   '',                'subjects_subject_view'),
('Edicion de una materia',           '',              FALSE, 'subjects', 'subject', 'edit',   '',                'subjects_subject_edit'),
('Miembros de una materia',          '',              FALSE, 'subjects', 'assign',  'index',  '',                'subjects_subject_assign'),
('Agregar miembros a una materia',   '',              FALSE, 'subjects', 'assign',  'new',    '',                'subjects_subject_assign_new'),
('Importar miembros a una materia',  '',              FALSE, 'subjects', 'assign',  'import', '',                'subjects_subject_assign_import'),
('Exportar miembros de una materia', '',              FALSE, 'subjects', 'assign',  'export', '',                'subjects_subject_assign_export');

/*============================================================================*/
/* Registro de rutas para el paquete                                          */
/*============================================================================*/
INSERT INTO `route`
(`label`, `type`, `parent`, `route`, `mapping`, `module`, `controller`, `action`)
VALUES
('Lista de materias',         'list',   'base',                    'subjects_list',                         'subjects',                              'subjects', 'index',   'index'),
('Administrador de materias', 'list',   'subjects_list',           'subjects_manager',                      'subjects/manager',                      'subjects', 'manager', 'index'),
('Nueva materia',             'view',   'subjects_manager',        'subjects_new' ,                         'subjects/new',                          'subjects', 'manager', 'new'),
('',                          'action', 'subjects_manager',        'subjects_lock',                         'subjects/lock',                         'subjects', 'manager', 'lock'),
('',                          'action', 'subjects_manager',        'subjects_unlock',                       'subjects/unlock',                       'subjects', 'manager', 'unlock'),
('Importar materias',         'view',   'subjects_manager',        'subjects_import',                       'subjects/import',                       'subjects', 'manager', 'import'),
('Exportar materias',         'view',   'subjects_manager',        'subjects_export',                       'subjects/export',                       'subjects', 'manager', 'export'),
('',                          'action', 'subjects_manager',        'subjects_delete',                       'subjects/delete',                       'subjects', 'manager', 'delete'),
('Materia: $subject',         'view',   'subjects_manager',        'subjects_subject_view',                 'subjects/:subject/',                    'subjects', 'subject', 'view'),
('Editar: $subject',          'view',   'subjects_subject_view',   'subjects_subject_edit',                 'subjects/:subject/edit',                'subjects', 'subject', 'edit'),
('',                          'action', 'subjects_subject_view',   'subjects_subject_lock',                 'subjects/:subject/lock',                'subjects', 'subject', 'lock'),
('',                          'action', 'subjects_subject_view',   'subjects_subject_unlock',               'subjects/:subject/unlock',              'subjects', 'subject', 'unlock'),
('',                          'action', 'subjects_subject_view',   'subjects_subject_delete',               'subjects/:subject/delete',              'subjects', 'subject', 'delete'),
('Integrantes: $subject',     'list',   'subjects_subject_view',   'subjects_subject_assign',               'subjects/:subject/assign',              'subjects', 'assign',  'index'),
('Agregar integrantes',       'view',   'subjects_subject_assign', 'subjects_subject_assign_new',           'subjects/:subject/assign/new',          'subjects', 'assign',  'new'),
('',                          'action', 'subjects_subject_assign', 'subjects_subject_assign_lock',          'subjects/:subject/assign/lock',         'subjects', 'assign',  'lock'),
('',                          'action', 'subjects_subject_assign', 'subjects_subject_assign_unlock',        'subjects/:subject/assign/unlock',       'subjects', 'assign',  'unlock'),
('Importar integrantes',      'view',   'subjects_subject_assign', 'subjects_subject_assign_import',        'subjects/:subject/assign/import',       'subjects', 'assign',  'import'),
('Exportar integrantes',      'view',   'subjects_subject_assign', 'subjects_subject_assign_export',        'subjects/:subject/assign/export',       'subjects', 'assign',  'export'),
('',                          'action', 'subjects_subject_assign', 'subjects_subject_assign_delete',        'subjects/:subject/assign/delete',       'subjects', 'assign',  'delete'),
('',                          'action', 'subjects_subject_assign', 'subjects_subject_assign_member_lock',   'subjects/:subject/assign/:user/lock',   'subjects', 'member',  'lock'),
('',                          'action', 'subjects_subject_assign', 'subjects_subject_assign_member_unlock', 'subjects/:subject/assign/:user/unlock', 'subjects', 'member',  'unlock'),
('',                          'action', 'subjects_subject_assign', 'subjects_subject_assign_member_delete', 'subjects/:subject/assign/:user/delete', 'subjects', 'member',  'delete');
