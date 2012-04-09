
/*====================================================================================================================*/
/* Tablas necesarias para el manejo de comentarios de todos los recursos                                              */
/*====================================================================================================================*/

DROP TABLE IF EXISTS `rating`;
CREATE TABLE `rating` (
    `resource`          int unsigned                                                NOT NULL,
    `author`            int unsigned                                                NOT NULL,
    `rating`            boolean                                                     NOT NULL,
    PRIMARY KEY (`resource`, `author`),
    INDEX (`resource`),
    FOREIGN KEY (`resource`)      REFERENCES `resource`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT,
    INDEX (`author`),
    FOREIGN KEY (`author`)        REFERENCES `user`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT
) DEFAULT CHARACTER SET UTF8;

/*====================================================================================================================*/
/* Registro del modulo                                                                                                */
/*====================================================================================================================*/
INSERT INTO `module`
(`label`,          `url`,              `type`,        `tsregister`,       `description`)
VALUES
('ratings',        'ratings',          'application', UNIX_TIMESTAMP(),   'Modulo manejador de las puntuaciones en todos los recursos disponibles del sistema');

/*====================================================================================================================*/
/* Registro de privilegios para el modulo                                                                             */
/*====================================================================================================================*/
INSERT INTO `privilege`
(`label`,                                                         `module`,           `privilege`)
VALUES
('Calificar un recurso',                                          'ratings',          'new');
