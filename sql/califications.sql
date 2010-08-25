
/*====================================================================================================================*/
/* Tablas necesarias para el registro de las calificaciones                                                           */
/*====================================================================================================================*/

DROP TABLE IF EXISTS `calification`;
CREATE TABLE `calification` (
    `user`              int unsigned                                                NOT NULL,
    `group`             int unsigned                                                NOT NULL,
    `evaluation`        int unsigned                                                NOT NULL,
    `test`              int unsigned                                                NOT NULL,
    `calification`      int unsigned                                                NOT NULL DEFAULT 0,
    PRIMARY KEY (`user`, `group`, `evaluation`, `test`),
    INDEX (`user`, `group`),
    FOREIGN KEY (`user`, `group`) REFERENCES `group_user`(`user`, `group`) ON UPDATE CASCADE ON DELETE RESTRICT,
    INDEX (`evaluation`, `test`),
    FOREIGN KEY (`evaluation`, `test`) REFERENCES `evaluation_test`(`evaluation`, `ident`) ON UPDATE CASCADE ON DELETE RESTRICT
) DEFAULT CHARACTER SET UTF8;

/*====================================================================================================================*/
/* Registro del modulo                                                                                                */
/*====================================================================================================================*/
INSERT INTO `module`
(`label`,          `url`,              `type`,        `tsregister`,       `description`)
VALUES
('califications',  'califications',    'middleware',  UNIX_TIMESTAMP(),   'Modulo manejador de las calificaciones de los estudiantes del sistema');

/*====================================================================================================================*/
/* Registro de paginas para el modulo                                                                                 */
/*====================================================================================================================*/
INSERT INTO `page`
(`label`,                         `title`, `menuable`, `module`,        `controller`,  `action`,           `privilege`,             `route`)
VALUES
('Gestor de calificaciones',      '',      FALSE,      'califications', 'manager',     'index',            '',                      'califications_manager'),
('Importar calificaciones',       '',      FALSE,      'califications', 'manager',     'import',           '',                      'califications_import'),
('Exportar calificaciones',       '',      FALSE,      'califications', 'manager',     'export',           '',                      'califications_export'),
('Ver calificaciones',            '',      FALSE,      'califications', 'index',       'index',            '',                      'califications_view');

/*====================================================================================================================*/
/* Registro de widgets para el modulo                                                                                 */
/*====================================================================================================================*/
INSERT INTO `widget`
(`label`,                              `title`,                                `module`,           `script`)
VALUES
('Ver Calificaciones',                 'Ver Calificaciones',                   'califications',    'califications.php');
