
/*============================================================================*/
/* Tablas requeridas para el registro de usuarios                             */
/*============================================================================*/
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
    `ident`         int unsigned               NOT NULL auto_increment,
    `role`          int unsigned               NOT NULL,
    `code`          varchar(16)                NOT NULL DEFAULT '',
    `label`         varchar(64)                NOT NULL,
    `url`           varchar(128)               NOT NULL,
    `password`      varchar(64)                NOT NULL,
    `email`         varchar(64)                NULL,
    `status`        enum('active', 'inactive') NOT NULL DEFAULT 'active',
    `formalname`    varchar(128)               NOT NULL DEFAULT '',
    `surname`       varchar(128)               NOT NULL DEFAULT '',
    `name`          varchar(128)               NOT NULL DEFAULT '',
    `avatar`        boolean                    NOT NULL DEFAULT false,
    `birthdate`     date                       NULL,
    `career`        int unsigned               NOT NULL DEFAULT 0,
    `phone`         varchar(64)                NOT NULL DEFAULT '',
    `cellphone`     varchar(64)                NOT NULL DEFAULT '',
    `hobbies`       text                       NOT NULL DEFAULT '',
    `description`   text                       NOT NULL DEFAULT '',
    `sign`          varchar(128)               NOT NULL DEFAULT '',
    `activity`      int unsigned               NOT NULL DEFAULT 0,
    `participation` int unsigned               NOT NULL DEFAULT 0,
    `sociability`   int unsigned               NOT NULL DEFAULT 0,
    `popularity`    int unsigned               NOT NULL DEFAULT 0,
    `knowledge`     int unsigned               NOT NULL DEFAULT 0,
    `template`      varchar(64)                NOT NULL DEFAULT 'webarte',
    `spaces`        text                       NULL,
    `newsletter`    text                       NULL,
    `tsregister`    int unsigned               NOT NULL,
    `tslastlogin`   int unsigned               NOT NULL DEFAULT 0,
    PRIMARY KEY (`ident`),
    INDEX (`role`),
    FOREIGN KEY (`role`) REFERENCES `role`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT,
    UNIQUE INDEX (`label`),
    UNIQUE INDEX (`url`),
    UNIQUE INDEX (`email`)
) DEFAULT CHARACTER SET UTF8;

/*============================================================================*/
/* Registro del paquete                                                       */
/*============================================================================*/
INSERT INTO `package`
(`label`, `url`, `type`, `parent`, `tsregister`, `description`)
VALUES
('users', 'users', 'middle', 'roles', UNIX_TIMESTAMP(), 'Modulo manejador de los usuarios');

/*============================================================================*/
/* Registro de privilegios para el paquete                                    */
/*============================================================================*/
INSERT INTO `privilege`
(`description`, `package`, `label`)
VALUES
('Listar los usuarios disponibles',            'users', 'list'),
('Crear nuevos usuarios',                      'users', 'new'),
('Importar usuarios',                          'users', 'import'),
('Exportar usuarios',                          'users', 'export'),
('Ver las caracteristicas de los usuarios',    'users', 'view'),
('Editar las caracteristicas de los usuarios', 'users', 'edit'),
('Activar/desactivar usuarios',                'users', 'lock'),
('Eliminar usuarios',                          'users', 'delete');

/*============================================================================*/
/* Registro de rutas para el paquete                                          */
/*============================================================================*/
INSERT INTO `route`
(`label`, `type`, `parent`, `route`, `mapping`, `module`, `controller`, `action`)
VALUES
('Lista de usuarios',         'list',   'base',            'users_list',        'users',              'users', 'index',   'index'),
('Administrador de usuarios', 'list',   'users_list',      'users_manager',     'users/manager',      'users', 'manager', 'index'),
('Nuevo usuario',             'view',   'users_manager',   'users_new',         'users/new',          'users', 'manager', 'new'),
('Importar usuarios',         'view',   'users_manager',   'users_import',      'users/import',       'users', 'manager', 'import'),
('Exportar usuarios',         'view',   'users_manager',   'users_export',      'users/export',       'users', 'manager', 'export'),
('',                          'action', 'users_manager',   'users_lock',        'users/lock',         'users', 'manager', 'lock'),
('',                          'action', 'users_manager',   'users_unlock',      'users/unlock',       'users', 'manager', 'unlock'),
('',                          'action', 'users_manager',   'users_delete',      'users/delete',       'users', 'manager', 'delete'),
('Usuario: $user',            'view',   'users_manager',   'users_user_view',   'users/:user',        'users', 'user',    'view'),
('Editar: $user',             'view',   'users_user_view', 'users_user_edit',   'users/:user/edit',   'users', 'user',    'edit'),
('',                          'action', 'users_user_view', 'users_user_lock',   'users/:user/lock',   'users', 'user',    'lock'),
('',                          'action', 'users_user_view', 'users_user_unlock', 'users/:user/unlock', 'users', 'user',    'unlock'),
('',                          'action', 'users_user_view', 'users_user_delete', 'users/:user/delete', 'users', 'user',    'delete');

INSERT INTO `route_privilege`
(`route`, `package`, `privilege`)
VALUES
('users_list',    'users', 'list'),
('users_manager', 'users', 'new'),
('users_manager', 'users', 'lock'),
('users_manager', 'users', 'delete'),
('users_new',     'users', 'new'),
('users_import',  'users', 'import'),
('users_export',  'users', 'export');
