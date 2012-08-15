
/*============================================================================*/
/* Tablas necesarias para la descripcion de carreras                          */
/*============================================================================*/
DROP TABLE IF EXISTS `career`;
CREATE TABLE `career` (
    `ident`       int unsigned NOT NULL auto_increment,
    `label`       varchar(64)  NOT NULL,
    `url`         varchar(64)  NOT NULL,
    `description` text         NOT NULL DEFAULT '',
    `tsregister`  int unsigned NOT NULL,
    PRIMARY KEY (`ident`),
    UNIQUE INDEX (`label`),
    UNIQUE INDEX (`url`)
) DEFAULT CHARACTER SET UTF8;

DROP TABLE IF EXISTS `career_subject`;
CREATE TABLE `career_subject` (
    `career`  int unsigned NOT NULL,
    `subject` int unsigned NOT NULL,
    `gestion` int unsigned NOT NULL,
    PRIMARY KEY (`career`, `subject`),
    INDEX (`career`),
    FOREIGN KEY (`career`) REFERENCES `career`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT,
    INDEX (`subject`),
    FOREIGN KEY (`subject`) REFERENCES `subject`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT
) DEFAULT CHARACTER SET UTF8;

DROP TABLE IF EXISTS `career_resource`;
CREATE TABLE `career_resource` (
    `career`   int unsigned NOT NULL,
    `resource` int unsigned NOT NULL,
    PRIMARY KEY (`career`, `resource`),
    INDEX (`career`),
    FOREIGN KEY (`career`) REFERENCES `career`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT,
    INDEX (`resource`),
    FOREIGN KEY (`resource`) REFERENCES `resource`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT
) DEFAULT CHARACTER SET UTF8;

/*============================================================================*/
/* Registro del paquete                                                       */
/*============================================================================*/
INSERT INTO `package`
(`label`, `url`, `type`, `parent`, `tsregister`, `description`)
VALUES
('careers', 'careers', 'middle', 'spaces', UNIX_TIMESTAMP(), 'Modulo manejador de las las carreras');

/*============================================================================*/
/* Registro de privilegios para el paquete                                    */
/*============================================================================*/
INSERT INTO `privilege`
(`description`, `package`, `label`)
VALUES
('Listar las carreras disponibles',          'careers', 'list'),
('Crear nueva carrera',                      'careers', 'new'),
('Eliminar carreras',                        'careers', 'delete'),
('Ver las caracteristicas de una carrera',   'careers', 'view'),
('Editar las caracteristicas de un carrera', 'careers', 'edit');

/*============================================================================*/
/* Registro de rutas para el paquete                                          */
/*============================================================================*/
INSERT INTO `route`
(`label`, `type`, `parent`, `route`, `mapping`, `module`, `controller`, `action`)
VALUES
('Lista de carreras',         'list',   'base',                'careers_list',          'careers',                'careers', 'index',   'index'),
('Administrador de carreras', 'list',   'careers_list',        'careers_manager',       'careers/manager',        'careers', 'manager', 'index'),
('Nueva carrera',             'view',   'careers_manager',     'careers_new',           'careers/new',            'careers', 'manager', 'new'),
('Carrera: $career',          'view',   'careers_manager',     'careers_career_view',   'careers/:career',        'careers', 'career',  'view'),
('Editar: $career',           'view',   'careers_career_view', 'careers_career_edit',   'careers/:career/edit',   'careers', 'career',  'edit'),
('',                          'action', 'careers_career_view', 'careers_career_delete', 'careers/:career/delete', 'careers', 'career',  'delete');

INSERT INTO `route_privilege`
(`route`, `package`, `privilege`)
VALUES
('careers_list',    'careers', 'list'),
('careers_manager', 'careers', 'new'),
('careers_manager', 'careers', 'delete'),
('careers_new',     'careers', 'new');
