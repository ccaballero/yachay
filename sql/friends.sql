
/*====================================================================================================================*/
/* Tablas necesarias para el modulo de friends                                                                        */
/*====================================================================================================================*/

DROP TABLE IF EXISTS `friend`;
CREATE TABLE `friend` (
    `user`            int unsigned                                                  NOT NULL,
    `friend`          int unsigned                                                  NOT NULL,
    `tsregister`      int unsigned                                                  NOT NULL,
    PRIMARY KEY (`user`, `friend`),
    INDEX (`user`),
    FOREIGN KEY (`user`)        REFERENCES `user`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT,
    INDEX (`friend`),
    FOREIGN KEY (`friend`)      REFERENCES `user`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT
) DEFAULT CHARACTER SET UTF8;

/*====================================================================================================================*/
/* Registro del modulo                                                                                                */
/*====================================================================================================================*/
INSERT INTO `module`
(`label`,          `url`,              `type`,        `tsregister`,       `description`)
VALUES
('friends',        'friends',          'middleware',  UNIX_TIMESTAMP(),   'Modulo de conecciones entre usuarios');

/*====================================================================================================================*/
/* Registro de paginas para el modulo                                                                                 */
/*====================================================================================================================*/
INSERT INTO `page`
(`label`,                         `title`,            `menuable`,    `module`,           `controller`,  `action`,           `privilege`,             `route`)
VALUES
('Lista de contactos',           'Contactos',         TRUE,          'friends',          'index',     'index',            '',                      'friends_list');

/*====================================================================================================================*/
/* Registro de privilegios para el modulo                                                                             */
/*====================================================================================================================*/
INSERT INTO `privilege`
(`label`,                                                         `module`,           `privilege`)
VALUES
('Agregar contactos',                                             'friends',          'contact');

/*====================================================================================================================*/
/* Registro de widgets para el modulo                                                                                 */
/*====================================================================================================================*/
INSERT INTO `widget`
(`label`,                              `title`,                                `module`,           `script`)
VALUES
('Lista de contactos',                 'Contactos',                            'friends',          'contacts.php');
