
/*====================================================================================================================*/
/* Tablas requeridas para el registro de usuarios                                                                     */
/*====================================================================================================================*/

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
    `ident`             int unsigned                                                NOT NULL auto_increment,
    `role`              int unsigned                                                NOT NULL,
    `code`              varchar(16)                                                 NOT NULL DEFAULT '',
    `label`             varchar(64)                                                 NOT NULL,
    `url`               varchar(128)                                                NOT NULL,
    `password`          varchar(64)                                                 NOT NULL,
    `email`             varchar(64)                                                 NULL,
    `status`            enum('active', 'inactive')                                  NOT NULL DEFAULT 'active',
    `formalname`        varchar(128)                                                NOT NULL DEFAULT '',
    `surname`           varchar(128)                                                NOT NULL DEFAULT '',
    `name`              varchar(128)                                                NOT NULL DEFAULT '',
    `avatar`            boolean                                                     NOT NULL DEFAULT FALSE,
    `birthdate`         date                                                        NULL,
    `career`            int unsigned                                                NOT NULL DEFAULT 0,
    `phone`             varchar(64)                                                 NOT NULL DEFAULT '',
    `cellphone`         varchar(64)                                                 NOT NULL DEFAULT '',
    `hobbies`           text                                                        NOT NULL DEFAULT '',
    `description`       text                                                        NOT NULL DEFAULT '',
    `sign`              varchar(128)                                                NOT NULL DEFAULT '',
    `activity`          int unsigned                                                NOT NULL DEFAULT 0,
    `participation`     int unsigned                                                NOT NULL DEFAULT 0,
    `sociability`       int unsigned                                                NOT NULL DEFAULT 0,
    `popularity`        int unsigned                                                NOT NULL DEFAULT 0,
    `knowledge`         int unsigned                                                NOT NULL DEFAULT 0,
    `template`          varchar(64)                                                 NOT NULL DEFAULT 'webarte',
    `tsregister`        int unsigned                                                NOT NULL,
    `tslastlogin`       int unsigned                                                NOT NULL DEFAULT 0,
    PRIMARY KEY (`ident`),
    INDEX (`role`),
    FOREIGN KEY (`role`)          REFERENCES `role`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT,
    UNIQUE INDEX (`label`),
    UNIQUE INDEX (`url`),
    UNIQUE INDEX (`email`)
) DEFAULT CHARACTER SET UTF8;

DROP TABLE IF EXISTS `user_resource`;
CREATE TABLE `user_resource` (
    `user`              int unsigned                                                NOT NULL,
    `resource`          int unsigned                                                NOT NULL,
    PRIMARY KEY (`user`, `resource`),
    INDEX (`user`),
    FOREIGN KEY (`user`)          REFERENCES `user`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT,
    INDEX (`resource`),
    FOREIGN KEY (`resource`)      REFERENCES `resource`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT
) DEFAULT CHARACTER SET UTF8;

/*====================================================================================================================*/
/* Registro del modulo                                                                                                */
/*====================================================================================================================*/
INSERT INTO `module`
(`label`,          `url`,              `type`,        `tsregister`,       `description`)
VALUES
('users',          'users',            'platform',    UNIX_TIMESTAMP(),   'Modulo manejador de los usuarios');

/*====================================================================================================================*/
/* Registro de paginas para el modulo                                                                                 */
/*====================================================================================================================*/
INSERT INTO `page`
(`label`,                         `title`,            `menuable`,    `module`,           `controller`,  `action`,           `privilege`,             `route`)
VALUES
('Lista de usuarios',             'Usuarios',         TRUE,          'users',            'index',       'index',            'list',                  'users_list'),
('Administrador de usuarios',     'Usuarios',         TRUE,          'users',            'manager',     'index',            'new|lock|delete',       'users_manager'),
('Nuevo usuario',                 'Nuevo usuario',    TRUE,          'users',            'manager',     'new',              'new',                   'users_new'),
('Importar usuarios',             'Imp. usuarios',    TRUE,          'users',            'manager',     'import',           'import',                'users_import'),
('Exportar usuarios',             'Exp. usuarios',    TRUE,          'users',            'manager',     'export',           'export',                'users_export'),
('Vista de un usuario',           '',                 FALSE,         'users',            'user',        'view',             '',                      'users_user_view'),
('Edicion de un usuario',         '',                 FALSE,         'users',            'user',        'edit',             '',                      'users_user_edit');

/*====================================================================================================================*/
/* Registro de privilegios para el modulo                                                                             */
/*====================================================================================================================*/
INSERT INTO `privilege`
(`label`,                                                         `module`,           `privilege`)
VALUES
('Listar los usuarios disponibles',                               'users',            'list'),
('Crear nuevos usuarios',                                         'users',            'new'),
('Importar usuarios',                                             'users',            'import'),
('Exportar usuarios',                                             'users',            'export'),
('Ver las caracteristicas de los usuarios',                       'users',            'view'),
('Editar las caracteristicas de los usuarios',                    'users',            'edit'),
('Activar/desactivar usuarios',                                   'users',            'lock'),
('Eliminar usuarios',                                             'users',            'delete');
