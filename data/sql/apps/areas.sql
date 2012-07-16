
/*============================================================================*/
/* Tablas necesarias para la categorización de las materias                   */
/*============================================================================*/
DROP TABLE IF EXISTS `area`;
CREATE TABLE `area` (
    `ident`       int unsigned NOT NULL auto_increment,
    `label`       varchar(64)  NOT NULL,
    `url`         varchar(64)  NOT NULL,
    `description` text         NOT NULL DEFAULT '',
    `tsregister`  int unsigned NOT NULL,
    PRIMARY KEY (`ident`),
    UNIQUE INDEX (`label`),
    UNIQUE INDEX (`url`)
) DEFAULT CHARACTER SET UTF8;

DROP TABLE IF EXISTS `area_subject`;
CREATE TABLE `area_subject` (
    `area`    int unsigned NOT NULL,
    `subject` int unsigned NOT NULL,
    `gestion` int unsigned NOT NULL,
    PRIMARY KEY (`area`, `subject`),
    INDEX (`area`),
    FOREIGN KEY (`area`) REFERENCES `area`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT,
    INDEX (`subject`),
    FOREIGN KEY (`subject`) REFERENCES `subject`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT
) DEFAULT CHARACTER SET UTF8;

DROP TABLE IF EXISTS `area_resource`;
CREATE TABLE `area_resource` (
    `area`     int unsigned NOT NULL,
    `resource` int unsigned NOT NULL,
    PRIMARY KEY (`area`, `resource`),
    INDEX (`area`),
    FOREIGN KEY (`area`) REFERENCES `area`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT,
    INDEX (`resource`),
    FOREIGN KEY (`resource`) REFERENCES `resource`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT
) DEFAULT CHARACTER SET UTF8;

/*============================================================================*/
/* Registro del paquete                                                       */
/*============================================================================*/
INSERT INTO `package`
(`label`, `url`, `type`, `parent`, `tsregister`, `description`)
VALUES
('areas', 'areas', 'app', 'spaces', UNIX_TIMESTAMP(), 'Modulo manejador de las las areas de agrupacion de las materias');

/*============================================================================*/
/* Registro de privilegios para el paquete                                    */
/*============================================================================*/
INSERT INTO `privilege`
(`description`, `package`, `label`)
VALUES
('Listar las areas disponibles',          'areas', 'list'),
('Crear nueva area',                      'areas', 'new'),
('Eliminar areas',                        'areas', 'delete'),
('Ver las caracteristicas de un area',    'areas', 'view'),
('Editar las caracteristicas de un area', 'areas', 'edit');

/*============================================================================*/
/* Registro de paginas para el paquete                                        */
/*============================================================================*/
INSERT INTO `page`
(`label`, `title`, `menuable`, `package`, `controller`, `action`, `privilege`, `route`)
VALUES
('Lista de areas',         'Areas',      TRUE,  'areas', 'index',   'index', 'list',       'areas_list'),
('Administrador de areas', 'Areas',      TRUE,  'areas', 'manager', 'index', 'new|delete', 'areas_manager'),
('Nueva area',             'Nueva area', TRUE,  'areas', 'manager', 'new',   'new',        'areas_new'),
('Vista de un area',       '',           FALSE, 'areas', 'area',    'view',  '',           'areas_area_view'),
('Edicion de un area',     '',           FALSE, 'areas', 'area',    'edit',  '',           'areas_area_edit');
