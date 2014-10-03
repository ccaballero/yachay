
/*============================================================================*/
/* Tablas necesarias para el registro de comunidades                          */
/*============================================================================*/
DROP TABLE IF EXISTS `community`;
CREATE TABLE `community` (
    `ident`       int unsigned          NOT NULL auto_increment,
    `author`      int unsigned          NOT NULL DEFAULT 1,
    `label`       varchar(64)           NOT NULL,
    `url`         varchar(64)           NOT NULL,
    `mode`        enum('open', 'close') NOT NULL DEFAULT 'open',
    `members`     int unsigned          NOT NULL DEFAULT 1,
    `petitions`   int unsigned          NOT NULL DEFAULT 0,
    `description` text                  NOT NULL DEFAULT '',
    `tsregister`  int unsigned          NOT NULL,
    PRIMARY KEY (`ident`),
    INDEX (`author`),
    FOREIGN KEY (`author`) REFERENCES `user`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT,
    UNIQUE INDEX (`label`),
    UNIQUE INDEX (`url`)
) DEFAULT CHARACTER SET UTF8;

DROP TABLE IF EXISTS `community_user`;
CREATE TABLE `community_user` (
    `community`  int unsigned                NOT NULL,
    `user`       int unsigned                NOT NULL,
    `type`       enum('moderator', 'member') NOT NULL DEFAULT 'member',
    `status`     enum('active', 'inactive')  NOT NULL DEFAULT 'inactive',
    `tsregister` int unsigned                NOT NULL,
    PRIMARY KEY (`community`, `user`),
    INDEX (`community`),
    FOREIGN KEY (`community`) REFERENCES `community`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT,
    INDEX (`user`),
    FOREIGN KEY (`user`) REFERENCES `user`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT
) DEFAULT CHARACTER SET UTF8;

DROP TABLE IF EXISTS `community_petition`;
CREATE TABLE `community_petition` (
    `community`  int unsigned NOT NULL,
    `user`       int unsigned NOT NULL,
    `tsregister` int unsigned NOT NULL,
    PRIMARY KEY (`community`, `user`),
    INDEX (`community`),
    FOREIGN KEY (`community`) REFERENCES `community`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT,
    INDEX (`user`),
    FOREIGN KEY (`user`) REFERENCES `user`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT
) DEFAULT CHARACTER SET UTF8;

/*============================================================================*/
/* Registro del paquete                                                       */
/*============================================================================*/
INSERT INTO `package`
(`label`, `url`, `type`, `parent`, `tsregister`, `description`)
VALUES
('communities', 'communities', 'middle', 'spaces', UNIX_TIMESTAMP(), 'Modulo manejador de las comunidades');

/*============================================================================*/
/* Registro de privilegios para el paquete                                    */
/*============================================================================*/
INSERT INTO `privilege`
(`description`, `package`, `label`)
VALUES
('Listar las comunidades disponibles',       'communities', 'list'),
('Crear e ingresar comunidades',             'communities', 'enter'),
('Ver las caracteristicas de una comunidad', 'communities', 'view');

/*============================================================================*/
/* Registro de rutas para el paquete                                          */
/*============================================================================*/
INSERT INTO `route`
(`label`, `type`, `parent`, `route`, `mapping`, `module`, `controller`, `action`)
VALUES
('Lista de comunidades',         'list',   'base',                           'communities_list',                                 'communities',                                   'communities', 'index',     'index'),
('Administrador de comunidades', 'list',   'communities_list',               'communities_manager',                              'communities/manager',                           'communities', 'manager',   'index'),
('Nueva comunidad',              'view',   'communities_manager',            'communities_new',                                  'communities/new',                               'communities', 'manager',   'new'),
('Comunidad: $community',        'view',   'communities_manager',            'communities_community_view',                       'communities/:community',                        'communities', 'community', 'view'),
('Editar: $community',           'view',   'communities_community_view',     'communities_community_edit',                       'communities/:community/edit',                   'communities', 'community', 'edit'),
('',                             'action', 'communities_community_view',     'communities_community_join',                       'communities/:community/join',                   'communities', 'assign',    'join'),
('',                             'action', 'communities_community_view',     'communities_community_leave',                      'communities/:community/leave',                  'communities', 'assign',    'leave'),
('',                             'action', 'communities_community_view',     'communities_community_delete',                     'communities/:community/delete',                 'communities', 'community', 'delete'),
('Integrantes: $community',      'view',   'communities_community_view',     'communities_community_assign',                     'communities/:community/assign',                 'communities', 'assign',    'index'),
('',                             'action', 'communities_community_assign',   'communities_community_assign_member_lock',         'communities/:community/assign/:user/lock',      'communities', 'member',    'lock'),
('',                             'action', 'communities_community_assign',   'communities_community_assign_member_unlock',       'communities/:community/assign/:user/unlock',    'communities', 'member',    'unlock'),
('',                             'action', 'communities_community_assign',   'communities_community_assign_member_delete',       'communities/:community/assign/:user/delete',    'communities', 'member',    'delete'),
('Peticiones: $community',       'view',   'communities_community_view',     'communities_community_petition',                   'communities/:community/petition',               'communities', 'petition',  'index'),
('',                             'action', 'communities_community_petition', 'communities_community_petition_applicant_accept',  'communities/:community/petition/:user/accept',  'communities', 'applicant', 'accept'),
('',                             'action', 'communities_community_petition', 'communities_community_petition_applicant_decline', 'communities/:community/petition/:user/decline', 'communities', 'applicant', 'decline');

INSERT INTO `route_privilege`
(`route`, `package`, `privilege`)
VALUES
('communities_list', 'communities', 'list'),
('communities_manager', 'communities', 'enter'),
('communities_new', 'communities', 'enter');
