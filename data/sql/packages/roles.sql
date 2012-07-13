
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
(`label`, `url`, `type`, `dependency`, `tsregister`, `description`)
VALUES
('roles', 'roles', 'middle', 'privileges', UNIX_TIMESTAMP(), 'Modulo manejador de los roles de los usuarios');

/*============================================================================*/
/* Registro de paginas para el paquete                                        */
/*============================================================================*/
INSERT INTO `page`
(`label`, `title`, `menuable`, `package`, `controller`, `action`, `privilege`, `route`)
VALUES
('Lista de roles',         'Roles',         TRUE,  'roles', 'index',   'index', 'list',              'roles_list'),
('Administrador de roles', 'Roles',         TRUE,  'roles', 'manager', 'index', 'new|assign|delete', 'roles_manager'),
('Nuevo rol',              'Nuevo rol',     TRUE,  'roles', 'manager', 'new',   'new',               'roles_new'),
('Asignacion usuario/rol', 'Asig. Rol/Us.', TRUE,  'roles', 'assign',  'index', 'assign',            'roles_assign'),
('Vista de un rol',        '',              FALSE, 'roles', 'role',    'view',  '',                  'roles_role_view'),
('Edicion de un rol',      '',              FALSE, 'roles', 'role',    'edit',  '',                  'roles_role_edit');

/*============================================================================*/
/* Registro de privilegios para el paquete                                    */
/*============================================================================*/
INSERT INTO `privilege`
(`label`, `package`, `privilege`)
VALUES
('Listar los roles disponibles',            'roles', 'list'),
('Crear nuevos roles de usuarios',          'roles', 'new'),
('Asignar roles a usuarios',                'roles', 'assign'),
('Ver las caracteristicas de los roles',    'roles', 'view'),
('Editar las caracteristicas de los roles', 'roles', 'edit'),
('Eliminar roles',                          'roles', 'delete');
