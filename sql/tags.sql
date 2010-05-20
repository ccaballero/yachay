
/*====================================================================================================================*/
/* Tablas necesarias para el modulo de etiquetas                                                                      */
/*====================================================================================================================*/

DROP TABLE IF EXISTS `tag`;
CREATE TABLE `tag` (
    `ident`             int unsigned                                                NOT NULL auto_increment,
    `label`             varchar(64)                                                 NOT NULL,
    `weigth`            int unsigned                                                NOT NULL DEFAULT 1,
    `tsregister`        timestamp                                                   NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`ident`),
    UNIQUE INDEX (`label`)
) DEFAULT CHARACTER SET UTF8;

DROP TABLE IF EXISTS `tag_resource`;
CREATE TABLE `tag_resource` (
    `tag`               int unsigned                                                NOT NULL,
    `resource`          int unsigned                                                NOT NULL,
    PRIMARY KEY (`tag`, `resource`),
    INDEX (`tag`),
    FOREIGN KEY (`tag`)          REFERENCES `tag`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT,
    INDEX (`resource`),
    FOREIGN KEY (`resource`)      REFERENCES `resource`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT
) DEFAULT CHARACTER SET UTF8;

/*====================================================================================================================*/
/* Registro del modulo                                                                                                */
/*====================================================================================================================*/
INSERT INTO `module`
(`label`,          `url`,              `type`,        `tsregister`,       `description`)
VALUES
('tags',           'tags',             'automagic',   UNIX_TIMESTAMP(),   'Modulo manejador de las etiquetas en todos los recursos disponibles del sistema');

/*====================================================================================================================*/
/* Registro de paginas para el modulo                                                                                 */
/*====================================================================================================================*/
INSERT INTO `page`
(`label`,                         `title`,            `menuable`,    `module`,           `controller`,  `action`,           `privilege`,             `route`)
VALUES
('Nube de etiquetas',             'Etiquetas',        TRUE,          'tags',             'index',       'index',            'list',                  'tags_list');

/*====================================================================================================================*/
/* Registro de privilegios para el modulo                                                                             */
/*====================================================================================================================
INSERT INTO `privilege`
(`category`,  `label`,                                                         `module`,           `privilege`,        `delegate`)
VALUES
(7,           'Ver nube de etiquetas',                                         'tags',             'list',             FALSE);
*/