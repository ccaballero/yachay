
/*============================================================================*/
/* Tablas necesarias para el paquete de eventos                               */
/*============================================================================*/

DROP TABLE IF EXISTS `event`;
CREATE TABLE `event` (
    `resource` int unsigned NOT NULL,
    `label`    varchar(64)  NOT NULL,
    `place`    varchar(256) NOT NULL DEFAULT '',
    `message`  varchar(512) NOT NULL DEFAULT '',
    `event`    int unsigned NOT NULL,
    `duration` int unsigned NOT NULL DEFAULT 0,
    `priority` boolean      NOT NULL DEFAULT FALSE,
    PRIMARY KEY (`resource`),
    INDEX (`resource`),
    FOREIGN KEY (`resource`) REFERENCES `resource`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT
) DEFAULT CHARACTER SET UTF8;

/*============================================================================*/
/* Registro del paquete                                                       */
/*============================================================================*/
INSERT INTO `package`
(`label`, `url`, `type`, `parent`, `tsregister`, `description`)
VALUES
('events', 'events', 'app', 'resources', UNIX_TIMESTAMP(), 'Modulo de gestion de calendarios y eventos');

/*============================================================================*/
/* Registro de rutas para el paquete                                          */
/*============================================================================*/
INSERT INTO `route`
(`label`, `type`, `parent`, `route`, `mapping`, `module`, `controller`, `action`)
VALUES
('Nuevo evento',      'view',   'resources_list',    'events_new',          'events/new',           'events', 'manager', 'new'),
('Visor de eventos',  'view',   'resources_list',    'events_event_view',   'events/:event',        'events', 'event',   'view'),
('Editor de eventos', 'view',   'events_event_view', 'events_event_edit',   'events/:event/edit',   'events', 'event',   'edit'),
('',                  'action', 'events_event_view', 'events_event_delete', 'events/:event/delete', 'events', 'event',   'delete'),
('',                  'action', 'events_event_view', 'events_event_drop',   'events/:event/drop',   'events', 'event',   'drop');
