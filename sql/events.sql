
/*====================================================================================================================*/
/* Tablas necesarias para el modulo de eventos                                                                        */
/*====================================================================================================================*/

DROP TABLE IF EXISTS `event`;
CREATE TABLE `event` (
    `resource`          int unsigned                                                NOT NULL,
    `label`             varchar(64)                                                 NOT NULL,
    `place`             varchar(256)                                                NOT NULL DEFAULT '',
    `message`           varchar(512)                                                NOT NULL DEFAULT '',
    `event`             int unsigned   						    NOT NULL,
    `duration`	        int unsigned    					    NOT NULL DEFAULT 0,
    `priority`          boolean                                                     NOT NULL DEFAULT FALSE,
    PRIMARY KEY (`resource`),
    INDEX (`resource`),
    FOREIGN KEY (`resource`)      REFERENCES `resource`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT
) DEFAULT CHARACTER SET UTF8;

/*DROP TABLE IF EXISTS `event_confirmation`;
CREATE TABLE `event_confirmation` (
    `user`              int unsigned                                                NOT NULL,
    `event`             int unsigned                                                NOT NULL,
    `accept`            boolean                                                     NOT NULL DEFAULT FALSE,
    PRIMARY KEY (`user`, `event`),
    INDEX (`user`),
    FOREIGN KEY (`user`)          REFERENCES `user`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT,
    INDEX (`event`),
    FOREIGN KEY (`event`)         REFERENCES `event`(`resource`) ON UPDATE CASCADE ON DELETE RESTRICT
) DEFAULT CHARACTER SET UTF8;*/

/*====================================================================================================================*/
/* Registro del modulo                                                                                                */
/*====================================================================================================================*/
INSERT INTO `module`
(`label`,          `url`,              `type`,        `tsregister`,       `description`)
VALUES
('events',         'events',           'application', UNIX_TIMESTAMP(),   'Modulo de gestion de calendarios y eventos');

/*====================================================================================================================*/
/* Registro de paginas para el modulo                                                                                 */
/*====================================================================================================================*/
INSERT INTO `page`
(`label`,                         `title`,            `menuable`,    `module`,           `controller`,  `action`,           `privilege`,             `route`)
VALUES
('Nuevo evento',                  'Nuevo evento',     TRUE,          'events',           'manager',     'new',              '',                      'events_new'),
('Visor de eventos',              '',                 FALSE,         'events',           'event',       'view',             '',                      'events_event_view'),
('Editor de eventos',             '',                 FALSE,         'events',           'event',       'edit',             '',                      'events_event_edit');

