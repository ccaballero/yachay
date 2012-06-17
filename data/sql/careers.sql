
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
(`label`, `url`, `type`, `tsregister`, `description`)
VALUES
('careers', 'careers', 'middleware', UNIX_TIMESTAMP(), 'Modulo manejador de las las carreras');

/*============================================================================*/
/* Registro de paginas para el paquete                                        */
/*============================================================================*/
INSERT INTO `page`
(`label`, `title`, `menuable`, `package`, `controller`, `action`, `privilege`, `route`)
VALUES
('Lista de carreras',         'Carreras',      TRUE,  'careers', 'index',   'index', 'list',       'careers_list'),
('Administrador de carreras', 'Carreras',      TRUE,  'careers', 'manager', 'index', 'new|delete', 'careers_manager'),
('Nueva carrera',             'Nueva carrera', TRUE,  'careers', 'manager', 'new',   'new',        'careers_new'),
('Vista de una carrera',      '',              FALSE, 'careers', 'career',  'view',  '',           'careers_career_view'),
('Edicion de una carrera',    '',              FALSE, 'careers', 'career',  'edit',  '',           'careers_career_edit');

/*============================================================================*/
/* Registro de privilegios para el paquete                                    */
/*============================================================================*/
INSERT INTO `privilege`
(`label`, `package`, `privilege`)
VALUES
('Listar las carreras disponibles',          'careers', 'list'),
('Crear nueva carrera',                      'careers', 'new'),
('Eliminar carreras',                        'careers', 'delete'),
('Ver las caracteristicas de una carrera',   'careers', 'view'),
('Editar las caracteristicas de un carrera', 'careers', 'edit');
