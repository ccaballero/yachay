
/*====================================================================================================================*/
/* Tablas requeridas para la utilidad de busqueda en el sistema                                                       */
/*====================================================================================================================*/

DROP TABLE IF EXISTS `search`;
CREATE TABLE `search` (
    `ident`             int unsigned                                                NOT NULL auto_increment,
    `module`            int unsigned                                                NOT NULL,
    `label`             varchar(64)                                                 NOT NULL,
    `url`               varchar(64)                                                 NOT NULL,
    `tsregister`        timestamp                                                   NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`ident`)
) DEFAULT CHARACTER SET UTF8;

/*====================================================================================================================*/
/* Registro del modulo                                                                                                */
/*====================================================================================================================*/
INSERT INTO `module`
(`label`,          `url`,              `type`,        `tsregister`,       `description`)
VALUES
('search',         'search',           'application', UNIX_TIMESTAMP(),   'Modulo de Busqueda');

/*====================================================================================================================*/
/* Registro de regiones para el modulo                                                                                */
/*====================================================================================================================*/
INSERT INTO `region`
(`label`,          `module`,           `script`,           `region`)
VALUES
('Basica',         'search',           'search.php',       'search');

/*====================================================================================================================*/
/* Registro de paginas para el modulo                                                                                 */
/*====================================================================================================================*/
INSERT INTO `page`
(`label`,                         `title`,            `menuable`,    `module`,           `controller`,  `action`,           `privilege`,             `route`)
VALUES
('Busqueda',                      'Busqueda',         TRUE,          'search',           'index',       'index',            'list',                      'search_list');

/*====================================================================================================================*/
/* Registro de privilegios para el modulo                                                                             */
/*====================================================================================================================
INSERT INTO `privilege`
(`category`,  `label`,                                                         `module`,           `privilege`,        `delegate`)
VALUES
(7,           'Buscar elementos en el sistema',                                'search',           'list',             FALSE);*/
