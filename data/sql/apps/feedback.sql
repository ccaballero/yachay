
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
/* Registro de privilegios para el paquete                                    */
/*============================================================================*/
INSERT INTO `privilege`
(`description`, `package`, `label`)
VALUES
('Ver sugerencias',                 'feedback', 'list'),
('Marcar sugerencias solucionadas', 'feedback', 'resolv'),
('Marcar sugerencias interesantes', 'feedback', 'mark'),
('Eliminar sugerencias inútiles',   'feedback', 'delete');

/*============================================================================*/
/* Registro de rutas para el paquete                                          */
/*============================================================================*/
INSERT INTO `route`
(`label`, `type`, `parent`, `route`, `mapping`, `module`, `controller`, `action`)
VALUES
('Lista de sugerencias',         'list',   'base', 'feedback_list',           'feedback',                 'feedback', 'index',   'index'),
('Administrador de sugerencias', 'list',   'base', 'feedback_manager',        'feedback/manager',         'feedback', 'manager', 'index'),
('Nueva sugerencia',             'view',   'base', 'feedback_new',            'feedback/new',             'feedback', 'manager', 'new'),
('Sugerencia: $entry',           'view',   'base', 'feedback_entry_view',     'feedback/:entry',          'feedback', 'entry',   'view'),
('Editar: $entry',               'view',   'base', 'feedback_entry_edit',     'feedback/:entry/edit',     'feedback', 'entry',   'edit'),
('',                             'action', 'base', 'feedback_entry_resolv',   'feedback/:entry/resolv',   'feedback', 'entry',   'resolv'),
('',                             'action', 'base', 'feedback_entry_unresolv', 'feedback/:entry/unresolv', 'feedback', 'entry',   'unresolv'),
('',                             'action', 'base', 'feedback_entry_mark',     'feedback/:entry/mark',     'feedback', 'entry',   'mark'),
('',                             'action', 'base', 'feedback_entry_unmark',   'feedback/:entry/unmark',   'feedback', 'entry',   'unmark'),
('',                             'action', 'base', 'feedback_entry_delete',   'feedback/:entry/delete',   'feedback', 'entry',   'delete'),
('',                             'action', 'base', 'feedback_entry_drop',     'feedback/:entry/drop',     'feedback', 'entry',   'drop');

INSERT INTO `route_privilege`
(`route`, `package`, `privilege`)
VALUES
('feedback_list', 'feedback', 'list'),
('feedback_manager', 'feedback', 'resolv'),
('feedback_manager', 'feedback', 'mark'),
('feedback_manager', 'feedback', 'delete');

