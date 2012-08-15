
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
/* Registro de privilegios para el paquete                                    */
/*============================================================================*/
INSERT INTO `privilege`
(`description`, `package`, `label`)
VALUES
('Listar las gestiones disponibles',      'gestions', 'list'),
('Crear una gestion',                     'gestions', 'new'),
('Definir la gestion actual',             'gestions', 'active'),
('Eliminar una gestion',                  'gestions', 'delete'),
('Ver las caracteristicas de la gestion', 'gestions', 'view');

/*============================================================================*/
/* Registro de rutas para el paquete                                          */
/*============================================================================*/
INSERT INTO `route`
(`label`, `type`, `parent`, `route`, `mapping`, `module`, `controller`, `action`)
VALUES
('Lista de gestiones',         'list',   'base',                  'gestions_list',            'gestions',                   'gestions', 'index',   'index'),
('Administrador de gestiones', 'list',   'gestions_list',         'gestions_manager',         'gestions/manager',           'gestions', 'manager', 'index'),
('Nueva gestion',              'view',   'gestions_manager',      'gestions_new' ,            'gestions/new',               'gestions', 'manager', 'new'),
('Gestion: $gestion',          'list',   'gestions_manager',      'gestions_gestion_view',    'gestions/:gestion',          'gestions', 'gestion', 'view'),
('',                           'action', 'gestions_gestion_view', 'gestions_gestion_active',  'gestions/:gestion/active',   'gestions', 'gestion', 'active'),
('Subject: $subject',          'list',   'gestions_gestion_view', 'gestions_gestion_subject', 'gestions/:gestion/:subject', 'subjects', 'subject', 'view'),
('',                           'action', 'gestions_gestion_view', 'gestions_gestion_delete',  'gestions/:gestion/delete',   'gestions', 'gestion', 'delete');

INSERT INTO `route_privilege`
(`route`, `package`, `privilege`)
VALUES
('gestions_list', 'gestions', 'list'),
('gestions_manager', 'gestions', 'new'),
('gestions_manager', 'gestions', 'active'),
('gestions_manager', 'gestions', 'delete'),
('gestions_new', 'gestions', 'new');
