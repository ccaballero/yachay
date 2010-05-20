
/*====================================================================================================================*/
/* Tablas para el manejo de grupos en materias                                                                        */
/*====================================================================================================================*/

DROP TABLE IF EXISTS `group`;
CREATE TABLE `group` (
    `ident`             int unsigned                                                NOT NULL auto_increment,
    `subject`           int unsigned                                                NOT NULL,
    `author`            int unsigned                                                NOT NULL DEFAULT 1,
    `teacher`           int unsigned                                                NOT NULL,
    `evaluation`        int unsigned                                                NOT NULL,
    `label`             varchar(64)                                                 NOT NULL,
    `url`               varchar(64)                                                 NOT NULL,
    `status`            enum('active', 'inactive')                                  NOT NULL DEFAULT 'inactive',
    `description`       text                                                        NOT NULL DEFAULT '',
    `tsregister`        int unsigned                                                NOT NULL,
    PRIMARY KEY (`ident`, `subject`),
    UNIQUE INDEX (`ident`),
    INDEX (`subject`),
    FOREIGN KEY (`subject`)       REFERENCES `subject`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT,
    INDEX (`author`),
    FOREIGN KEY (`author`)        REFERENCES `user`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT,
    INDEX (`teacher`),
    FOREIGN KEY (`teacher`)       REFERENCES `user`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT,
    INDEX (`evaluation`),
    FOREIGN KEY (`evaluation`)    REFERENCES `evaluation`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT,
    UNIQUE INDEX (`subject`, `label`),
    UNIQUE INDEX (`subject`, `url`)
) DEFAULT CHARACTER SET UTF8;

DROP TABLE IF EXISTS `group_user`;
CREATE TABLE `group_user` (
    `group`             int unsigned                                                NOT NULL,
    `user`              int unsigned                                                NOT NULL,
    `type`              enum('auxiliar', 'student', 'guest')                        NOT NULL,
    `status`            enum('active',  'inactive')                                 NOT NULL DEFAULT 'inactive',
    `tsregister`        int unsigned                                                NOT NULL,
    PRIMARY KEY (`group`, `user`),
    INDEX (`group`),
    FOREIGN KEY (`group`)         REFERENCES `group`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT,
    INDEX (`user`),
    FOREIGN KEY (`user`)          REFERENCES `user`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT
) DEFAULT CHARACTER SET UTF8;

DROP TABLE IF EXISTS `group_resource`;
CREATE TABLE `group_resource` (
    `group`             int unsigned                                                NOT NULL,
    `resource`          int unsigned                                                NOT NULL,
    PRIMARY KEY (`group`, `resource`),
    INDEX (`group`),
    FOREIGN KEY (`group`)         REFERENCES `group`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT,
    INDEX (`resource`),
    FOREIGN KEY (`resource`)      REFERENCES `resource`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT
) DEFAULT CHARACTER SET UTF8;

/*====================================================================================================================*/
/* Registro del modulo                                                                                                */
/*====================================================================================================================*/
INSERT INTO `module`
(`label`,          `url`,              `type`,        `tsregister`,       `description`)
VALUES
('groups',         'groups',           'middleware',  UNIX_TIMESTAMP(),   'Modulo manejador de los grupos para las materias');

/*====================================================================================================================*/
/* Registro de paginas para el modulo                                                                                 */
/*====================================================================================================================*/
INSERT INTO `page`
(`label`,                         `title`,            `menuable`,    `module`,           `controller`,  `action`,           `privilege`,             `route`)
VALUES
('Lista de grupos',               '',                 FALSE,         'groups',           'index',       'index',            '',                      'groups_list'),
('Administrador de grupos',       '',                 FALSE,         'groups',           'manager',     'index',            '',                      'groups_manager'),
('Nuevo grupo',                   '',                 FALSE,         'groups',           'manager',     'new',              '',                      'groups_new'),
('Vista de un grupo',             '',                 FALSE,         'groups',           'group',       'view',             '',                      'groups_group_view'),
('Edicion de un grupo',           '',                 FALSE,         'groups',           'group',       'edit',             '',                      'groups_group_edit'),
('Miembros de un grupo',          '',                 FALSE,         'groups',           'assign',      'index',            '',                      'groups_group_assign'),
('Agregar miembros a un grupo',   '',                 FALSE,         'groups',           'assign',      'new',              '',                      'groups_group_assign_new'),
('Importar miembros a grupo',     '',                 FALSE,         'groups',           'assign',      'import',           '',                      'groups_group_assign_import'),
('Exportar miembros de grupo',    '',                 FALSE,         'groups',           'assign',      'export',           '',                      'groups_group_assign_export');
