
/*====================================================================================================================*/
/* Registro de tablas imprescindibles para el manejo del sistema                                                      */
/*====================================================================================================================*/

/*====================================================================================================================*/
/* Tabla necesaria para el manejo de paginas en el sistema                                                            */
/*====================================================================================================================*/

DROP TABLE IF EXISTS `page`;
CREATE TABLE `page` (
    `ident`             int unsigned                                                NOT NULL auto_increment,
    `label`             varchar(64)                                                 NOT NULL,
    `title`             varchar(16)                                                 NOT NULL,
    `module`            varchar(32)                                                 NOT NULL,
    `controller`        varchar(64)                                                 NOT NULL,
    `action`            varchar(64)                                                 NOT NULL,
    `route`             varchar(64)                                                 NOT NULL,
    `privilege`         varchar(256)                                                NOT NULL DEFAULT '',
    `menuable`          boolean                                                     NOT NULL DEFAULT FALSE,
    `menutype`          enum('', 'menubar', 'secondary', 'footer')                  NOT NULL DEFAULT '',
    `menuparent`        int unsigned                                                NOT NULL DEFAULT 0,
    `menuorder`         int unsigned                                                NOT NULL DEFAULT 0,
    PRIMARY KEY (`ident`),
    UNIQUE INDEX (`label`),
    UNIQUE INDEX (`module`, `controller`, `action`),
    UNIQUE INDEX (`route`)
) DEFAULT CHARACTER SET UTF8;

/*====================================================================================================================*/
/* Tablas necesarias para el registro de privilegios                                                                  */
/*====================================================================================================================*/

DROP TABLE IF EXISTS `privilege`;
CREATE TABLE `privilege` (
    `ident`             int unsigned                                                NOT NULL auto_increment,
    `label`             varchar(64)                                                 NOT NULL,
    `module`            varchar(32)                                                 NOT NULL,
    `privilege`         varchar(256)                                                NOT NULL,
    PRIMARY KEY (`ident`),
    UNIQUE INDEX (`label`),
    UNIQUE INDEX (`module`, `privilege`)
) DEFAULT CHARACTER SET UTF8;
