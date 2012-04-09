
/*====================================================================================================================*/
/* Tablas necesarias para el registro de invitaciones                                                                 */
/*====================================================================================================================*/

DROP TABLE IF EXISTS `invitation`;
CREATE TABLE `invitation` (
    `ident`             int unsigned                                                NOT NULL auto_increment,
    `code`              varchar(128)                                                NOT NULL,
    `author`            int unsigned                                                NOT NULL,
    `email`             varchar(64)                                                 NOT NULL,
    `accepted`          boolean                                                     NOT NULL DEFAULT FALSE,
    `message`           text                                                        NOT NULL DEFAULT '',
    `tsregister`        int unsigned                                                NOT NULL,
    PRIMARY KEY (`ident`),
    INDEX (`author`),
    FOREIGN KEY (`author`)        REFERENCES `user`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT,
    UNIQUE INDEX (`code`),
    UNIQUE INDEX (`email`)
) DEFAULT CHARACTER SET UTF8;

/*====================================================================================================================*/
/* Registro del modulo                                                                                                */
/*====================================================================================================================*/
INSERT INTO `module`
(`label`,          `url`,              `type`,        `tsregister`,       `description`)
VALUES
('invitations',    'invitations',      'application',  UNIX_TIMESTAMP(),   'Modulo utilidad para el manejo de invitaciones');

/*====================================================================================================================*/
/* Registro de paginas para el modulo                                                                                 */
/*====================================================================================================================*/
INSERT INTO `page`
(`label`,                         `title`,            `menuable`,    `module`,           `controller`,  `action`,           `privilege`,             `route`)
VALUES
('Administrador de invitaciones', 'Invitaciones',     TRUE,          'invitations',      'manager',     'index',            'invite',                'invitations_manager'),
('Nueva invitacion de acceso',    'Nueva Invitacion', TRUE,          'invitations',      'manager',     'new',              'invite',                'invitations_new'),
('Registro de usuario',           '',                 FALSE,         'invitations',      'invitation',  'proceed',          '',                      'invitations_invitation_proceed');

/*====================================================================================================================*/
/* Registro de privilegios para el modulo                                                                             */
/*====================================================================================================================*/
INSERT INTO `privilege`
(`label`,                                                         `module`,           `privilege`)
VALUES
('Enviar invitaciones',                                           'invitations',      'invite');
