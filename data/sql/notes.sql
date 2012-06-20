
/*============================================================================*/
/* Tablas necesarias para el paquete de notes                                 */
/*============================================================================*/

DROP TABLE IF EXISTS `note`;
CREATE TABLE `note` (
    `resource` int unsigned NOT NULL,
    `note`     text         NOT NULL,
    `priority` boolean	    NOT NULL DEFAULT FALSE,
    PRIMARY KEY (`resource`),
    INDEX (`resource`),
    FOREIGN KEY (`resource`) REFERENCES `resource`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT
) DEFAULT CHARACTER SET UTF8;

/*============================================================================*/
/* Registro del paquete                                                       */
/*============================================================================*/
INSERT INTO `package`
(`label`, `url`, `type`, `dependency`, `tsregister`, `description`)
VALUES
('notes', 'notes', 'app', 'resources', UNIX_TIMESTAMP(), 'Modulo de gestion de notas de texto');

/*============================================================================*/
/* Registro de paginas para el paquete                                        */
/*============================================================================*/
INSERT INTO `page`
(`label`, `title`, `menuable`, `package`, `controller`, `action`, `privilege`, `route`)
VALUES
('Nueva nota',      'Nueva nota', TRUE,  'notes', 'manager', 'new',  '', 'notes_new'),
('Visor de notas',  '',           FALSE, 'notes', 'note',    'view', '', 'notes_note_view'),
('Editor de notas', '',           FALSE, 'notes', 'note',    'edit', '', 'notes_note_edit');