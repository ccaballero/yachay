
/*============================================================================*/
/* Tablas para el manejo de grupos en materias                                */
/*============================================================================*/

DROP TABLE IF EXISTS `group`;
CREATE TABLE `group` (
    `ident`       int unsigned               NOT NULL auto_increment,
    `subject`     int unsigned               NOT NULL,
    `author`      int unsigned               NOT NULL DEFAULT 1,
    `teacher`     int unsigned               NOT NULL,
    `evaluation`  int unsigned               NOT NULL,
    `label`       varchar(64)                NOT NULL,
    `url`         varchar(64)                NOT NULL,
    `status`      enum('active', 'inactive') NOT NULL DEFAULT 'inactive',
    `description` text                       NOT NULL DEFAULT '',
    `tsregister`  int unsigned               NOT NULL,
    PRIMARY KEY (`ident`, `subject`),
    UNIQUE INDEX (`ident`),
    INDEX (`subject`),
    FOREIGN KEY (`subject`) REFERENCES `subject`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT,
    INDEX (`author`),
    FOREIGN KEY (`author`) REFERENCES `user`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT,
    INDEX (`teacher`),
    FOREIGN KEY (`teacher`) REFERENCES `user`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT,
    INDEX (`evaluation`),
    FOREIGN KEY (`evaluation`) REFERENCES `evaluation`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT,
    UNIQUE INDEX (`subject`, `label`),
    UNIQUE INDEX (`subject`, `url`)
) DEFAULT CHARACTER SET UTF8;

DROP TABLE IF EXISTS `group_user`;
CREATE TABLE `group_user` (
    `group`      int unsigned                         NOT NULL,
    `user`       int unsigned                         NOT NULL,
    `type`       enum('auxiliar', 'student', 'guest') NOT NULL,
    `status`     enum('active', 'inactive')          NOT NULL DEFAULT 'active',
    `tsregister` int unsigned                         NOT NULL,
    PRIMARY KEY (`group`, `user`),
    INDEX (`group`),
    FOREIGN KEY (`group`) REFERENCES `group`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT,
    INDEX (`user`),
    FOREIGN KEY (`user`) REFERENCES `user`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT
) DEFAULT CHARACTER SET UTF8;

DROP TABLE IF EXISTS `group_resource`;
CREATE TABLE `group_resource` (
    `group`    int unsigned NOT NULL,
    `resource` int unsigned NOT NULL,
    PRIMARY KEY (`group`, `resource`),
    INDEX (`group`),
    FOREIGN KEY (`group`) REFERENCES `group`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT,
    INDEX (`resource`),
    FOREIGN KEY (`resource`) REFERENCES `resource`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT
) DEFAULT CHARACTER SET UTF8;

/*============================================================================*/
/* Registro del paquete                                                       */
/*============================================================================*/
INSERT INTO `package`
(`label`, `url`, `type`, `parent`, `tsregister`, `description`)
VALUES
('groups', 'groups', 'middle', 'subjects', UNIX_TIMESTAMP(), 'Modulo manejador de los grupos para las materias');

/*============================================================================*/
/* Registro de rutas para el paquete                                          */
/*============================================================================*/
INSERT INTO `route`
(`label`, `type`, `parent`, `route`, `mapping`, `module`, `controller`, `action`)
VALUES
('Lista de grupos',                 'list',   'base',                'groups_list',                       'groups',                                              'groups', 'index',   'index'),
('Administrador de grupos',         'list',   'groups_list',         'groups_manager',                    'subjects/:subject/groups/manager',                    'groups', 'manager', 'index'),
('Nuevo grupo',                     'view',   'groups_manager',      'groups_new',                        'subjects/:subject/groups/new',                        'groups', 'manager', 'new'),
('',                                'action', 'groups_manager',      'groups_lock',                       'subjects/:subject/groups/lock',                       'groups', 'manager', 'lock'),
('',                                'action', 'groups_manager',      'groups_unlock',                     'subjects/:subject/groups/unlock',                     'groups', 'manager', 'unlock'),
('',                                'action', 'groups_manager',      'groups_delete',                     'subjects/:subject/groups/delete',                     'groups', 'manager', 'delete'),
('Grupo: $group',                   'view',   'groups_manager',      'groups_group_view',                 'subjects/:subject/groups/:group',                     'groups', 'group',   'view'),
('Editar: $group',                  'view',   'groups_group_view',   'groups_group_edit',                 'subjects/:subject/groups/:group/edit',                'groups', 'group',   'edit'),
('Calificaciones: $group',          'view',   'groups_group_view',   'groups_group_calification',         'subjects/:subject/groups/:group/calification',        'groups', 'group',   'calification'),
('',                                'action', 'groups_group_view',   'groups_group_lock',                 'subjects/:subject/groups/:group/lock',                'groups', 'group',   'lock'),
('',                                'action', 'groups_group_view',   'groups_group_unlock',               'subjects/:subject/groups/:group/unlock',              'groups', 'group',   'unlock'),
('',                                'action', 'groups_group_view',   'groups_group_delete',               'subjects/:subject/groups/:group/delete',              'groups', 'group',   'delete'),
('Integrantes: $group',             'view',   'groups_group_view',   'groups_group_assign',               'subjects/:subject/groups/:group/assign',              'groups', 'assign',  'index'),
('Agregar integrantes a un grupo',  'view',   'groups_group_assign', 'groups_group_assign_new',           'subjects/:subject/groups/:group/assign/new',          'groups', 'assign',  'new'),
('Importar integrantes a un grupo', 'view',   'groups_group_assign', 'groups_group_assign_import',        'subjects/:subject/groups/:group/assign/import',       'groups', 'assign',  'import'),
('Exportar integrantes a un grupo', 'view',   'groups_group_assign', 'groups_group_assign_export',        'subjects/:subject/groups/:group/assign/export',       'groups', 'assign',  'export'),
('',                                'action', 'groups_group_assign', 'groups_group_assign_lock',          'subjects/:subject/groups/:group/assign/lock',         'groups', 'assign',  'lock'),
('',                                'action', 'groups_group_assign', 'groups_group_assign_unlock',        'subjects/:subject/groups/:group/assign/unlock',       'groups', 'assign',  'unlock'),
('',                                'action', 'groups_group_assign', 'groups_group_assign_delete',        'subjects/:subject/groups/:group/assign/delete',       'groups', 'assign',  'delete'),
('',                                'action', 'groups_group_assign', 'groups_group_assign_member_lock',   'subjects/:subject/groups/:group/assign/:user/lock',   'groups', 'member',  'lock'),
('',                                'action', 'groups_group_assign', 'groups_group_assign_member_unlock', 'subjects/:subject/groups/:group/assign/:user/unlock', 'groups', 'member',  'unlock'),
('',                                'action', 'groups_group_assign', 'groups_group_assign_member_delete', 'subjects/:subject/groups/:group/assign/:user/delete', 'groups', 'member',  'delete');
