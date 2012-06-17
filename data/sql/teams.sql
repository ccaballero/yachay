
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

DROP TABLE IF EXISTS `team_resource`;
CREATE TABLE `team_resource` (
    `team`     int unsigned NOT NULL,
    `resource` int unsigned NOT NULL,
    PRIMARY KEY (`team`, `resource`),
    INDEX (`team`),
    FOREIGN KEY (`team`) REFERENCES `team`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT,
    INDEX (`resource`),
    FOREIGN KEY (`resource`) REFERENCES `resource`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT
) DEFAULT CHARACTER SET UTF8;

/*============================================================================*/
/* Registro del paquete                                                       */
/*============================================================================*/
INSERT INTO `package`
(`label`, `url`, `type`, `tsregister`, `description`)
VALUES
('teams', 'teams', 'middleware', UNIX_TIMESTAMP(), 'Modulo manejador de los equipos de trabajo de los usuarios');

/*============================================================================*/
/* Registro de paginas para el paquete                                        */
/*============================================================================*/
INSERT INTO `page`
(`label`, `title`, `menuable`, `package`, `controller`, `action`, `privilege`, `route`)
VALUES
('Administrador de equipos',         '', FALSE, 'teams', 'manager', 'index', '', 'teams_manager'),
('Nuevo equipo',                     '', FALSE, 'teams', 'manager', 'new',   '', 'teams_new'),
('Vista de un equipo',               '', FALSE, 'teams', 'team',    'view',  '', 'teams_team_view'),
('Edicion de un equipo',             '', FALSE, 'teams', 'team',    'edit',  '', 'teams_team_edit'),
('Asignacion de miembros a equipos', '', FALSE, 'teams', 'assign',  'index', '', 'teams_assign');
