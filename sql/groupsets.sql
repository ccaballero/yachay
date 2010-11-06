
/*====================================================================================================================*/
/* Tablas para el registrar recursos compartidos en grupos                                                            */
/*====================================================================================================================*/

DROP TABLE IF EXISTS `groupset`;
CREATE TABLE `groupset` (
    `ident`             int unsigned                                                NOT NULL auto_increment,
    `author`            int unsigned                                                NOT NULL,
    `gestion`           int unsigned                                                NOT NULL,
    `label`             varchar(64)                                                 NOT NULL,
    `tsregister`        int unsigned                                                NOT NULL,
    PRIMARY KEY (`ident`, `author`),
    INDEX (`author`),
    FOREIGN KEY (`author`)        REFERENCES `user`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT,
    INDEX (`gestion`),
    FOREIGN KEY (`gestion`)       REFERENCES `gestion`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT
) DEFAULT CHARACTER SET UTF8;

DROP TABLE IF EXISTS `groupset_group`;
CREATE TABLE `groupset_group` (
    `groupset`          int unsigned                                                NOT NULL,
    `group`             int unsigned                                                NOT NULL,
    PRIMARY KEY (`groupset`, `group`),
    INDEX (`groupset`),
    FOREIGN KEY (`groupset`)      REFERENCES `groupset`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT,
    INDEX (`group`),
    FOREIGN KEY (`group`)         REFERENCES `group`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT
) DEFAULT CHARACTER SET UTF8;

/*====================================================================================================================*/
/* Registro del modulo                                                                                                */
/*====================================================================================================================*/
INSERT INTO `module`
(`label`,          `url`,              `type`,        `tsregister`,       `description`)
VALUES
('groupsets',      'groupsets',        'middleware',  UNIX_TIMESTAMP(),   'Modulo manejador de las agrupaciones de los grupos');

/*====================================================================================================================*/
/* Registro de paginas para el modulo                                                                                 */
/*====================================================================================================================*/
INSERT INTO `page`
(`label`,                         `title`,            `menuable`,    `module`,           `controller`,  `action`,           `privilege`,             `route`)
VALUES
('Administrador de conjuntos',    '',                 FALSE,         'groupsets',        'manager',     'index',            '',                      'groupsets_manager'),
('Nuevo conjunto',                '',                 FALSE,         'groupsets',        'manager',     'new',              'new',                   'groupsets_new'),
('Vista de un conjunto',          '',                 FALSE,         'groupsets',        'groupset',    'view',             '',                      'groupsets_groupset_view'),
('Edicion de un conjunto',        '',                 FALSE,         'groupsets',        'groupset',    'edit',             '',                      'groupsets_groupset_edit');
