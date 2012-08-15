
/*============================================================================*/
/* Tablas para el registrar recursos compartidos en grupos                    */
/*============================================================================*/

DROP TABLE IF EXISTS `groupset`;
CREATE TABLE `groupset` (
    `ident`      int unsigned NOT NULL auto_increment,
    `author`     int unsigned NOT NULL,
    `gestion`    int unsigned NOT NULL,
    `label`      varchar(64)  NOT NULL,
    `tsregister` int unsigned NOT NULL,
    PRIMARY KEY (`ident`, `author`),
    INDEX (`author`),
    FOREIGN KEY (`author`) REFERENCES `user`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT,
    INDEX (`gestion`),
    FOREIGN KEY (`gestion`) REFERENCES `gestion`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT
) DEFAULT CHARACTER SET UTF8;

DROP TABLE IF EXISTS `groupset_group`;
CREATE TABLE `groupset_group` (
    `groupset` int unsigned NOT NULL,
    `group`    int unsigned NOT NULL,
    PRIMARY KEY (`groupset`, `group`),
    INDEX (`groupset`),
    FOREIGN KEY (`groupset`) REFERENCES `groupset`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT,
    INDEX (`group`),
    FOREIGN KEY (`group`) REFERENCES `group`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT
) DEFAULT CHARACTER SET UTF8;

/*============================================================================*/
/* Registro del paquete                                                       */
/*============================================================================*/
INSERT INTO `package`
(`label`, `url`, `type`, `parent`, `tsregister`, `description`)
VALUES
('groupsets', 'groupsets', 'middle', 'groups', UNIX_TIMESTAMP(), 'Modulo manejador de las agrupaciones de los grupos');

/*============================================================================*/
/* Registro de privilegios para el paquete                                    */
/*============================================================================*/
INSERT INTO `privilege`
(`description`, `package`, `label`)
VALUES
('Crear conjuntos de materias', 'groupsets', 'new');

/*============================================================================*/
/* Registro de rutas para el paquete                                          */
/*============================================================================*/
INSERT INTO `route`
(`label`, `type`, `parent`, `route`, `mapping`, `module`, `controller`, `action`)
VALUES
('Administrador de conjuntos', 'list',   'base',                    'groupsets_manager',         'groupsets/manager',          'groupsets', 'manager',  'index'),
('Nuevo conjunto',             'view',   'groupsets_manager',       'groupsets_new',             'groupsets/new',              'groupsets', 'manager',  'new'),
('',                           'action', 'groupsets_manager',       'groupsets_delete',          'groupsets/delete',           'groupsets', 'manager',  'delete'),
('Vista de un conjunto',       'view',   'groupsets_manager',       'groupsets_groupset_view',   'groupsets/:groupset',        'groupsets', 'groupset', 'view'),
('Edicion de un conjunto',     'view',   'groupsets_groupset_view', 'groupsets_groupset_edit',   'groupsets/:groupset/edit',   'groupsets', 'groupset', 'edit'),
('',                           'action', 'groupsets_groupset_view', 'groupsets_groupset_delete', 'groupsets/:groupset/delete', 'groupsets', 'groupset', 'delete');

INSERT INTO `route_privilege`
(`route`, `package`, `privilege`)
VALUES
('groupsets_new', 'groupsets', 'new');
