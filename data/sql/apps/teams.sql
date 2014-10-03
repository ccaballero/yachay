
/*============================================================================*/
/* Tablas necesarias para la conformación y registro de equipos               */
/*============================================================================*/
DROP TABLE IF EXISTS `team`;
CREATE TABLE `team` (
    `ident`       int unsigned               NOT NULL auto_increment,
    `group`       int unsigned               NOT NULL,
    `author`      int unsigned               NOT NULL DEFAULT 1,
    `label`       varchar(64)                NOT NULL,
    `url`         varchar(64)                NOT NULL,
    `status`      enum('active', 'inactive') NOT NULL DEFAULT 'active',
    `description` text                       NOT NULL DEFAULT '',
    `tsregister`  int unsigned               NOT NULL,
    PRIMARY KEY (`ident`, `group`),
    UNIQUE INDEX (`ident`),
    INDEX (`group`),
    FOREIGN KEY (`group`) REFERENCES `group`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT,
    INDEX (`author`),
    FOREIGN KEY (`author`) REFERENCES `user`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT,
    UNIQUE INDEX (`group`, `label`),
    UNIQUE INDEX (`group`, `url`)
) DEFAULT CHARACTER SET UTF8;

DROP TABLE IF EXISTS `team_user`;
CREATE TABLE `team_user` (
    `team`       int unsigned NOT NULL,
    `user`       int unsigned NOT NULL,
    `tsregister` int unsigned NOT NULL,
    PRIMARY KEY (`team`, `user`),
    INDEX (`team`),
    FOREIGN KEY (`team`) REFERENCES `team`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT,
    INDEX (`user`),
    FOREIGN KEY (`user`) REFERENCES `user`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT
) DEFAULT CHARACTER SET UTF8;

/*============================================================================*/
/* Registro del paquete                                                       */
/*============================================================================*/
INSERT INTO `package`
(`label`, `url`, `type`, `parent`, `tsregister`, `description`)
VALUES
('teams', 'teams', 'middle', 'groups', UNIX_TIMESTAMP(), 'Modulo manejador de los equipos de trabajo de los usuarios');

/*============================================================================*/
/* Registro de rutas para el paquete                                          */
/*============================================================================*/
INSERT INTO `route`
(`label`, `type`, `parent`, `route`, `mapping`, `module`, `controller`, `action`)
VALUES
('Administrador de equipos',            'list',   'groups_group_view', 'teams_manager',            'subjects/:subject/groups/:group/teams/manager',            'teams', 'manager', 'index'),
('Nuevo equipo',                        'view',   'teams_manager',     'teams_new',                'subjects/:subject/groups/:group/teams/new',                'teams', 'manager', 'new'),
('Asignación de integrantes a equipos', 'view',   'teams_manager',     'teams_assign',             'subjects/:subject/groups/:group/teams/assign',             'teams', 'assign',  'index'),
('',                                    'action', 'teams_manager',     'teams_lock',               'subjects/:subject/groups/:group/teams/lock',               'teams', 'manager', 'lock'),
('',                                    'action', 'teams_manager',     'teams_unlock',             'subjects/:subject/groups/:group/teams/unlock',             'teams', 'manager', 'unlock'),
('',                                    'action', 'teams_manager',     'teams_delete',             'subjects/:subject/groups/:group/teams/delete',             'teams', 'manager', 'delete'),
('Equipo: $team',                       'view',   'teams_manager',     'teams_team_view',          'subjects/:subject/groups/:group/teams/:team',              'teams', 'team',    'view'),
('Edicion: $team',                      'view',   'teams_team_view',   'teams_team_edit',          'subjects/:subject/groups/:group/teams/:team/edit',         'teams', 'team',    'edit'),
('',                                    'action', 'teams_team_view',   'teams_team_lock',          'subjects/:subject/groups/:group/teams/:team/lock',         'teams', 'team',    'lock'),
('',                                    'action', 'teams_team_view',   'teams_team_unlock',        'subjects/:subject/groups/:group/teams/:team/unlock',       'teams', 'team',    'unlock'),
('',                                    'action', 'teams_team_view',   'teams_team_delete',        'subjects/:subject/groups/:group/teams/:team/delete',       'teams', 'team',    'delete'),
('',                                    'action', 'teams_team_view',   'teams_team_member_delete', 'subjects/:subject/groups/:group/teams/:team/:user/delete', 'teams', 'member',  'delete');
