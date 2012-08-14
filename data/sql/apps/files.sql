
/*============================================================================*/
/* Tablas necesarias para el paquete de archivos                              */
/*============================================================================*/
DROP TABLE IF EXISTS `file`;
CREATE TABLE `file` (
    `resource`    int unsigned NOT NULL,
    `description` text         NOT NULL DEFAULT '',
    `size`        int unsigned NOT NULL,
    `mime`        varchar(64)  NOT NULL,
    `filename`    varchar(64)  NOT NULL,
    `downloads`   int unsigned NOT NULL DEFAULT 0,
    `priority`    boolean      NOT NULL DEFAULT FALSE,
    PRIMARY KEY (`resource`),
    INDEX (`resource`),
    FOREIGN KEY (`resource`) REFERENCES `resource`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT
) DEFAULT CHARACTER SET UTF8;

/*============================================================================*/
/* Registro del paquete                                                       */
/*============================================================================*/
INSERT INTO `package`
(`label`, `url`, `type`, `parent`, `tsregister`, `description`)
VALUES
('files', 'files', 'app', 'resources', UNIX_TIMESTAMP(), 'Modulo de gestion de archivos');

/*============================================================================*/
/* Registro de paginas para el paquete                                        */
/*============================================================================*/
-- INSERT INTO `page`
-- (`label`, `title`, `menuable`, `package`, `controller`, `action`, `privilege`, `route`)
-- VALUES
-- ('Nuevo archivo',      'Nuevo archivo', TRUE,  'files', 'manager', 'new',  '', 'files_new'),
-- ('Visor de archivos',  '',              FALSE, 'files', 'file',    'view', '', 'files_file_view'),
-- ('Editor de archivos', '',              FALSE, 'files', 'file',    'edit', '', 'files_file_edit');

/*============================================================================*/
/* Registro de rutas para el paquete                                          */
/*============================================================================*/
INSERT INTO `route`
(`label`, `type`, `parent`, `route`, `mapping`, `module`, `controller`, `action`)
VALUES
('Nuevo archivo',      'view',   'resources_list',  'files_new',           'files/new',            'files', 'manager', 'new'),
('Visor de archivos',  'view',   'resources_list',  'files_file_view',     'files/:file',          'files', 'file',    'view'),
('Editor de archivos', 'view',   'files_file_view', 'files_file_edit',     'files/:file/edit',     'files', 'file',    'edit'),
('',                   'action', 'files_file_view', 'files_file_download', 'files/:file/download', 'files', 'file',    'download'),
('',                   'action', 'files_file_view', 'files_file_delete',   'files/:file/delete',   'files', 'file',    'delete'),
('',                   'action', 'files_file_view', 'files_file_drop',     'files/:file/drop',     'files', 'file',    'drop');

