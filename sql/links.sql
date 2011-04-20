
/*====================================================================================================================*/
/* Tablas necesarias para el modulo de links                                                                          */
/*====================================================================================================================*/

DROP TABLE IF EXISTS `link`;
CREATE TABLE `link` (
    `resource`          int unsigned                                                NOT NULL,
    `link`              varchar(256)                                                NOT NULL,
    `description`       text                                                        NOT NULL DEFAULT '',
    `priority`          boolean	                                                    NOT NULL DEFAULT FALSE,
    PRIMARY KEY (`resource`),
    INDEX (`resource`),
    FOREIGN KEY (`resource`)      REFERENCES `resource`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT
) DEFAULT CHARACTER SET UTF8;

/*====================================================================================================================*/
/* Registro del modulo                                                                                                */
/*====================================================================================================================*/
INSERT INTO `module`
(`label`,          `url`,              `type`,        `tsregister`,       `description`)
VALUES
('links',          'links',            'application', UNIX_TIMESTAMP(),   'Modulo de gestion de enlaces');

/*====================================================================================================================*/
/* Registro de paginas para el modulo                                                                                 */
/*====================================================================================================================*/
INSERT INTO `page`
(`label`,                         `title`,            `menuable`,    `module`,           `controller`,  `action`,           `privilege`,             `route`)
VALUES
('Nuevo enlace',                  'Nuevo enlace',     TRUE,          'links',            'manager',     'new',              '',                      'links_new'),
('Visor de enlaces',              '',                 FALSE,         'links',            'link',        'view',             '',                      'links_link_view'),
('Editor de enlaces',             '',                 FALSE,         'links',            'link',        'edit',             '',                      'links_link_edit');
