
/*====================================================================================================================*/
/* Tablas necesarias para el registro de invitaciones                                                                 */
/*====================================================================================================================*/

DROP TABLE IF EXISTS `invitation`;
CREATE TABLE `invitation` (
    `ident`             int unsigned                                                NOT NULL auto_increment,
    `author`            int unsigned                                                NOT NULL,
    `email`             varchar(64)                                                 NOT NULL,
    `accepted`          boolean                                                     NOT NULL DEFAULT FALSE,
    `description`       text                                                        NOT NULL DEFAULT '',
    `tsregister`        timestamp                                                   NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`ident`, `author`),
    UNIQUE INDEX (`ident`),
    INDEX (`author`),
    FOREIGN KEY (`author`)        REFERENCES `user`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT,
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
('Lista de invitaciones',         'Invitaciones',     TRUE,          'invitations',      'index',       'index',            'list',                  'invitations_list'),
('Administrador de invitaciones', 'Invitaciones',     TRUE,          'invitations',      'manager',     'index',            'new|delete',            'invitations_manager'),
('Nueva invitacion de acceso',    'Nueva Invitacion', TRUE,          'invitations',      'manager',     'new',              'new',                   'invitations_new'),
('Vista de una invitacion',       '',                 FALSE,         'invitations',      'invitation',  'view',             '',                      'invitations_invitation_view');

/*====================================================================================================================*/
/* Registro de privilegios para el modulo                                                                             */
/*====================================================================================================================*
INSERT INTO `privilege`
(`category`,  `label`,                                                         `module`,           `privilege`,        `delegate`)
VALUES
(2,           'Listar invitaciones pendientes',                                'invitations',      'list',             TRUE),
(2,           'Crear invitacion de acceso',                                    'invitations',      'new',              TRUE),
(2,           'Ver invitacion pendiente',                                      'invitations',      'view',             TRUE),
(2,           'Cancelar invitacion pendiente',                                 'invitations',      'delete',           TRUE);
*/