
/*====================================================================================================================*/
/* Tablas necesarias para el registro de manejadores de widgets                                                       */
/*====================================================================================================================*/

DROP TABLE IF EXISTS `widget`;
CREATE TABLE `widget` (
    `ident`             int unsigned                                                NOT NULL auto_increment,
    `label`             varchar(64)                                                 NOT NULL,
    `title`             varchar(32)                                                 NOT NULL,
    `module`            varchar(32)                                                 NOT NULL,
    `script`            varchar(32)                                                 NOT NULL,
    PRIMARY KEY (`ident`),
    UNIQUE INDEX (`module`, `script`)
) DEFAULT CHARACTER SET UTF8;

DROP TABLE IF EXISTS `widget_page`;
CREATE TABLE `widget_page` (
    `page`              int unsigned                                                NOT NULL,
    `widget`            int unsigned                                                NOT NULL,
    `position`          enum('1', '2', '3', '4')                                    NOT NULL DEFAULT '1',
    PRIMARY KEY (`page`, `widget`, `position`),
    INDEX (`page`),
    FOREIGN KEY (`page`)          REFERENCES `page`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT,
    INDEX (`widget`),
    FOREIGN KEY (`widget`)        REFERENCES `widget`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT
) DEFAULT CHARACTER SET UTF8;

/*====================================================================================================================*/
/* Registro del modulo                                                                                                */
/*====================================================================================================================*/
INSERT INTO `module`
(`label`,          `url`,              `type`,        `tsregister`,       `description`)
VALUES
('widgets',        'widgets',          'platform',    UNIX_TIMESTAMP(),   'Modulo de configuracion para los widgets de las paginas');

/*====================================================================================================================*/
/* Registro de paginas para el modulo                                                                                 */
/*====================================================================================================================*/
INSERT INTO `page`
(`label`,                         `title`,            `menuable`,    `module`,           `controller`,  `action`,           `privilege`,             `route`)
VALUES
('Lista de widgets',              'Widgets',          TRUE,          'widgets',          'index',       'index',            'list',                  'widgets_list'),
('Administrador de widgets',      'Widgets',          TRUE,          'widgets',          'manager',     'index',            'manage',                'widgets_manager');

/*====================================================================================================================*/
/* Registro de privilegios para el modulo                                                                             */
/*====================================================================================================================*/
INSERT INTO `privilege`
(`label`,                                                         `module`,           `privilege`)
VALUES
('Listar la configuracion de los widgets por pagina',             'widgets',          'list'),
('Configuracion de las widgets por pagina',                       'widgets',          'manage');
