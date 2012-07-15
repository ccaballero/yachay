
/*============================================================================*/
/* Tablas necesarias para el paquete de sugerencias                           */
/*============================================================================*/
DROP TABLE IF EXISTS `feedback`;
CREATE TABLE `feedback` (
    `resource`    int unsigned NOT NULL,
    `description` text         NOT NULL,
    `resolved`    boolean      NOT NULL DEFAULT FALSE,
    `mark`        boolean      NOT NULL DEFAULT FALSE,
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
('feedback', 'feedback', 'app', 'notes', UNIX_TIMESTAMP(), 'Modulo de registro de sugerencias del sistema');

/*============================================================================*/
/* Registro de paginas para el paquete                                        */
/*============================================================================*/
INSERT INTO `page`
(`label`, `title`, `menuable`, `package`, `controller`, `action`, `privilege`, `route`)
VALUES
('Lista de sugerencias',         'Sugerencias',      TRUE,  'feedback', 'index',   'index', 'list',               'feedback_list'),
('Administrador de sugerencias', 'Sugerencias',      TRUE,  'feedback', 'manager', 'index', 'resolv|mark|delete', 'feedback_manager'),
('Nueva sugerencia',             'Nueva Sugerencia', TRUE,  'feedback', 'manager', 'new',   '',                   'feedback_new'),
('Visor de sugerencias',         '',                 FALSE, 'feedback', 'entry',   'view',  '',                   'feedback_entry_view'),
('Editor de sugerencias',        '',                 FALSE, 'feedback', 'entry',   'edit',  '',                   'feedback_entry_edit');

/*============================================================================*/
/* Registro de privilegios para el paquete                                    */
/*============================================================================*/
INSERT INTO `privilege`
(`label`, `package`, `privilege`)
VALUES
('Ver sugerencias',                 'feedback', 'list'),
('Marcar sugerencias solucionadas', 'feedback', 'resolv'),
('Marcar sugerencias interesantes', 'feedback', 'mark'),
('Eliminar sugerencias inutiles',   'feedback', 'delete');
