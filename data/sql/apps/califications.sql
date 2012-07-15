
/*============================================================================*/
/* Tablas necesarias para el registro de las calificaciones                   */
/*============================================================================*/

DROP TABLE IF EXISTS `calification`;
CREATE TABLE `calification` (
    `user`         int unsigned  NOT NULL,
    `group`        int unsigned  NOT NULL,
    `evaluation`   int unsigned  NOT NULL,
    `test`         int unsigned  NOT NULL,
    `calification` decimal(2, 2) NOT NULL DEFAULT 0,
    PRIMARY KEY (`user`, `group`, `evaluation`, `test`),
    INDEX (`user`, `group`),
    FOREIGN KEY (`user`, `group`) REFERENCES `group_user`(`user`, `group`) ON UPDATE CASCADE ON DELETE RESTRICT,
    INDEX (`evaluation`, `test`),
    FOREIGN KEY (`evaluation`, `test`) REFERENCES `evaluation_test`(`evaluation`, `ident`) ON UPDATE CASCADE ON DELETE RESTRICT
) DEFAULT CHARACTER SET UTF8;

/*============================================================================*/
/* Registro del paquete                                                       */
/*============================================================================*/
INSERT INTO `package`
(`label`, `url`, `type`, `parent`, `tsregister`, `description`)
VALUES
('califications', 'califications', 'app', 'evaluations', UNIX_TIMESTAMP(), 'Modulo manejador de las calificaciones de los estudiantes del sistema');

/*============================================================================*/
/* Registro de paginas para el paquete                                        */
/*============================================================================*/
INSERT INTO `page`
(`label`, `title`, `menuable`, `package`, `controller`, `action`, `privilege`, `route`)
VALUES
('Gestor de calificaciones', '', FALSE, 'califications', 'manager', 'index',  '', 'califications_manager'),
('Importar calificaciones',  '', FALSE, 'califications', 'manager', 'import', '', 'califications_import'),
('Exportar calificaciones',  '', FALSE, 'califications', 'manager', 'export', '', 'califications_export'),
('Ver calificaciones',       '', FALSE, 'califications', 'index',   'index',  '', 'califications_view');

/*============================================================================*/
/* Registro de widgets para el paquete                                        */
/*============================================================================*/
INSERT INTO `widget`
(`label`, `title`, `package`, `script`)
VALUES
('Ver Calificaciones', 'Ver Calificaciones', 'califications', 'califications');
