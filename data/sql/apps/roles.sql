
/*============================================================================*/
/* Tablas necesarias para el paquete de roles                                 */
/*============================================================================*/
DROP TABLE IF EXISTS `role`;
CREATE TABLE `role` (
    `ident`       int unsigned NOT NULL auto_increment,
    `label`       varchar(64)  NOT NULL,
    `url`         varchar(64)  NOT NULL,
    `description` text         NOT NULL DEFAULT '',
    `tsregister`  int unsigned NOT NULL,
    PRIMARY KEY (`ident`),
    UNIQUE INDEX (`label`),
    UNIQUE INDEX (`url`)
) DEFAULT CHARACTER SET UTF8;

DROP TABLE IF EXISTS `role_privilege`;
CREATE TABLE `role_privilege` (
    `role`      int unsigned NOT NULL,
    `privilege` int unsigned NOT NULL,
    PRIMARY KEY (`role`, `privilege`),
    INDEX (`role`),
    FOREIGN KEY (`role`) REFERENCES `role`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT,
    INDEX (`privilege`),
    FOREIGN KEY (`privilege`) REFERENCES `privilege`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT
) DEFAULT CHARACTER SET UTF8;

/*============================================================================*/
/* Registro del paquete                                                       */
/*============================================================================*/
INSERT INTO `package`
(`label`, `url`, `type`, `parent`, `tsregister`, `description`)
VALUES
('roles', 'roles', 'middle', 'privileges', UNIX_TIMESTAMP(), 'Modulo manejador de los roles de los usuarios');

/*============================================================================*/
/* Registro de privilegios para el paquete                                    */
/*============================================================================*/
INSERT INTO `privilege`
(`description`, `package`, `label`)
VALUES
('Listar los roles disponibles',            'roles', 'list'),
('Crear nuevos roles de usuarios',          'roles', 'new'),
('Asignar roles a usuarios',                'roles', 'assign'),
('Ver las caracteristicas de los roles',    'roles', 'view'),
('Editar las caracteristicas de los roles', 'roles', 'edit'),
('Eliminar roles',                          'roles', 'delete');

/*============================================================================*/
/* Registro de rutas para el paquete                                          */
/*============================================================================*/
INSERT INTO `route`
(`label`, `type`, `parent`, `route`, `mapping`, `module`, `controller`, `action`)
VALUES
('Lista de roles',         'list',   'base',            'roles_list',        'roles',              'roles', 'index',   'index'),
('Administrador de roles', 'list',   'roles_list',      'roles_manager',     'roles/manager',      'roles', 'manager', 'index'),
('Nuevo rol',              'view',   'roles_manager',   'roles_new',         'roles/new',          'roles', 'manager', 'new'),
('Asignación usuario/rol', 'view',   'roles_manager',   'roles_assign',      'roles/assign',       'roles', 'assign',  'index'),
('Rol: $rol',              'view',   'roles_manager',   'roles_role_view',   'roles/:role',        'roles', 'role',    'view'),
('Editar: $rol',           'action', 'roles_role_view', 'roles_role_edit',   'roles/:role/edit',   'roles', 'role',    'edit'),
('',                       'action', 'roles_role_view', 'roles_role_delete', 'roles/:role/delete', 'roles', 'role',    'delete');

INSERT INTO `route_privilege`
(`route`, `package`, `privilege`)
VALUES
('roles_list', 'roles', 'list'),
('roles_manager', 'roles', 'new'),
('roles_manager', 'roles', 'assign'),
('roles_manager', 'roles', 'delete'),
('roles_new', 'roles', 'new'),
('roles_assing', 'roles', 'assign');
