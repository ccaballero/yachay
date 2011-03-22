
/*====================================================================================================================*/
/* Tablas necesarias para el modulo de videos                                                                         */
/*====================================================================================================================*/

DROP TABLE IF EXISTS `video`;
CREATE TABLE `video` (
    `resource`          int unsigned                                                NOT NULL,
    `description`       text                                                        NOT NULL DEFAULT '',
    `proportion`        varchar(8)                                                  NOT NULL DEFAULT '1:1',
    `size`              int unsigned                                                NOT NULL,
    `filename`          varchar(64)                                                 NOT NULL,
    `viewers`           int unsigned                                                NOT NULL DEFAULT 0,
    `priority`          boolean                                                     NOT NULL DEFAULT FALSE,
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
('videos',         'videos',           'application', UNIX_TIMESTAMP(),   'Modulo de gestion de videos online');

/*====================================================================================================================*/
/* Registro de paginas para el modulo                                                                                 */
/*====================================================================================================================*/
INSERT INTO `page`
(`label`,                         `title`,            `menuable`,    `module`,           `controller`,  `action`,           `privilege`,             `route`)
VALUES
('Nuevo video',                   'Nuevo video',      TRUE,          'videos',           'manager',     'new',              '',                      'videos_new'),
('Visor de videos',               '',                 FALSE,         'videos',           'video',       'view',             '',                      'videos_video_view'),
('Editor de videos',              '',                 FALSE,         'videos',           'video',       'edit',             '',                      'videos_video_edit');

/*====================================================================================================================*/
/* Registro de privilegios para el modulo                                                                             */
/*====================================================================================================================*/
INSERT INTO `privilege`
(`label`,                                                         `module`,           `privilege`)
VALUES
('Subir videos',                                                  'videos',           'upload');
