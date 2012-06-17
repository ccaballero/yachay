
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
(`label`, `url`, `type`, `tsregister`, `description`)
VALUES
('files', 'files', 'application', UNIX_TIMESTAMP(), 'Modulo de gestion de archivos');

/*============================================================================*/
/* Registro de paginas para el paquete                                        */
/*============================================================================*/
INSERT INTO `page`
(`label`, `title`, `menuable`, `package`, `controller`, `action`, `privilege`, `route`)
VALUES
('Nuevo archivo',      'Nuevo archivo', TRUE,  'files', 'manager', 'new',  '', 'files_new'),
('Visor de archivos',  '',              FALSE, 'files', 'file',    'view', '', 'files_file_view'),
('Editor de archivos', '',              FALSE, 'files', 'file',    'edit', '', 'files_file_edit');
