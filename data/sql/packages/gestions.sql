
/*============================================================================*/
/* Tablas necesarias para el registro de periodos academicos                  */
/*============================================================================*/

DROP TABLE IF EXISTS `gestion`;
CREATE TABLE `gestion` (
    `ident`      int unsigned               NOT NULL auto_increment,
    `label`      varchar(64)                NOT NULL,
    `url`        varchar(64)                NOT NULL,
    `status`     enum('active', 'inactive') NOT NULL DEFAULT 'inactive',
    `tsregister` int unsigned               NOT NULL,
    PRIMARY KEY (`ident`),
    UNIQUE INDEX (`label`),
    UNIQUE INDEX (`url`)
) DEFAULT CHARACTER SET UTF8;

/*============================================================================*/
/* Registro del paquete                                                       */
/*============================================================================*/
INSERT INTO `package`
(`label`, `url`, `type`, `parent`, `tsregister`, `description`)
VALUES
('gestions', 'gestions', 'middle', 'spaces', UNIX_TIMESTAMP(), 'Modulo guia de informacion para el manejo de periodos academicos');

/*============================================================================*/
/* Registro de paginas para el paquete                                        */
/*============================================================================*/
INSERT INTO `page`
(`label`, `title`, `menuable`, `package`, `controller`, `action`, `privilege`, `route`)
VALUES
('Lista de gestiones',          'Gestiones',     TRUE,  'gestions', 'index',   'index', 'list',              'gestions_list'),
('Administrador de gestiones',  'Gestiones',     TRUE,  'gestions', 'manager', 'index', 'new|active|delete', 'gestions_manager'),
('Nueva gestion',               'Nueva gestion', TRUE,  'gestions', 'manager', 'new',   'new',               'gestions_new'),
('Vista de un gestion',         '',              FALSE, 'gestions', 'gestion', 'view',  '',                  'gestions_gestion_view'),
('Vista de materia en gestion', '',              FALSE, 'subjects', 'subject', 'view',  '',                  'gestions_gestion_subject');

/*============================================================================*/
/* Registro de privilegios para el paquete                                    */
/*============================================================================*/
INSERT INTO `privilege`
(`label`, `package`, `privilege`)
VALUES
('Listar las gestiones disponibles',      'gestions', 'list'),
('Crear una gestion',                     'gestions', 'new'),
('Definir la gestion actual',             'gestions', 'active'),
('Eliminar una gestion',                  'gestions', 'delete'),
('Ver las caracteristicas de la gestion', 'gestions', 'view');
