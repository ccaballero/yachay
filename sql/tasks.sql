
/*====================================================================================================================*/
/* Tablas necesarias para el envio de los tareas a los miembros de un grupo                                           */
/*====================================================================================================================*/

DROP TABLE IF EXISTS `task`;
CREATE TABLE `task` (
    `ident`             int unsigned                                                NOT NULL auto_increment,
    `author`            int unsigned                                                NOT NULL,
    `group`             int unsigned                                                NOT NULL,
    `task`              text                                                        NOT NULL DEFAULT '',
    `priority`          boolean                                                     NOT NULL DEFAULT FALSE,
    `description`       text                                                        NOT NULL DEFAULT '',
    `attachment`        boolean                                                     NOT NULL DEFAULT FALSE,
    `size`              int unsigned                                                NOT NULL DEFAULT 0,
    `mime`              varchar(64)                                                 NOT NULL DEFAULT '',
    `tstimein`          int unsigned                                                NOT NULL,
    `tstimeout`         int unsigned                                                NOT NULL,
    `tsregister`        int unsigned                                                NOT NULL,
    PRIMARY KEY (`ident`, `author`, `group`),
    INDEX (`author`),
    FOREIGN KEY (`author`)        REFERENCES `user`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT,
    INDEX (`group`),
    FOREIGN KEY (`group`)         REFERENCES `group`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT
) DEFAULT CHARACTER SET UTF8;

DROP TABLE IF EXISTS `task_response`;
CREATE TABLE `task_response` (
    `ident`             int unsigned                                                NOT NULL auto_increment,
    `author`            int unsigned                                                NOT NULL,
    `task`              int unsigned                                                NOT NULL,
    `response`          text                                                        NOT NULL DEFAULT '',
    `attachment`        boolean                                              	    NOT NULL DEFAULT FALSE,
    `size`              int unsigned                                                NOT NULL DEFAULT 0,
    `mime`              varchar(64)                                                 NOT NULL DEFAULT '',
    `tsregister`        int unsigned                                                NOT NULL,
    PRIMARY KEY (`ident`, `author`, `task`),
    INDEX (`author`),
    FOREIGN KEY (`author`)        REFERENCES `user`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT,
    INDEX (`task`),
    FOREIGN KEY (`task`)          REFERENCES `task`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT,
) DEFAULT CHARACTER SET UTF8;

/*====================================================================================================================*/
/* Registro del modulo                                                                                                */
/*====================================================================================================================*/
INSERT INTO `module`
(`label`,          `url`,              `type`,        `tsregister`,       `description`)
VALUES
('tasks',          'tasks',            'application', UNIX_TIMESTAMP(),   'Modulo para la definicion de tareas en grupos');

/*====================================================================================================================*/
/* Registro de paginas para el modulo                                                                                 */
/*====================================================================================================================*/
INSERT INTO `page`
(`label`,                         `title`,            `menuable`,    `module`,           `controller`,  `action`,           `privilege`,             `route`)
VALUES
('Nueva tarea',                   'Nueva tarea',      TRUE,          'tasks',            'manager',     'new',              '',                      'tasks_new'),
('Visor de tareas',               '',                 FALSE,         'tasks',            'task',        'view',             '',                      'tasks_task_view'),
('Editor de tareas',              '',                 FALSE,         'tasks',            'task',        'edit',             '',                      'tasks_task_edit');
