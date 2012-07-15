
/*============================================================================*/
/* Registro de tablas imprescindibles para el manejo del sistema              */
/*============================================================================*/

/*============================================================================*/
/* Tablas requeridas para el registro de paquetes                             */
/*============================================================================*/

DROP TABLE IF EXISTS `package`;
CREATE TABLE `package` (
    `ident`       int unsigned                          NOT NULL auto_increment,
    `label`       varchar(64)                           NOT NULL,
    `url`         varchar(64)                           NOT NULL,
    `status`      enum('active', 'inactive')            NOT NULL DEFAULT 'active',
    `type`        enum('base', 'middle', 'app', 'util') NOT NULL,
    `description` text                                  NOT NULL DEFAULT '',
    `tsregister`  int unsigned                          NOT NULL,
    `parent`      varchar(64)                           NULL,
    PRIMARY KEY (`ident`),
    INDEX (`label`),
    UNIQUE INDEX (`url`),
    INDEX (`parent`),
    FOREIGN KEY (`parent`) REFERENCES `package`(`url`) ON UPDATE CASCADE ON DELETE RESTRICT
) DEFAULT CHARACTER SET UTF8;

/*============================================================================*/
/* Tabla necesaria para el manejo de paginas en el sistema                    */
/*============================================================================*/

DROP TABLE IF EXISTS `page`;
CREATE TABLE `page` (
    `ident`             int unsigned                                                NOT NULL auto_increment,
    `label`             varchar(64)                                                 NOT NULL,
    `title`             varchar(16)                                                 NOT NULL,
    `package`           varchar(32)                                                 NOT NULL,
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
    UNIQUE INDEX (`route`)
) DEFAULT CHARACTER SET UTF8;

/*============================================================================*/
/* Tablas necesarias para el registro de privilegios                          */
/*============================================================================*/

DROP TABLE IF EXISTS `privilege`;
CREATE TABLE `privilege` (
    `ident`             int unsigned                                                NOT NULL auto_increment,
    `label`             varchar(64)                                                 NOT NULL,
    `package`           varchar(32)                                                 NOT NULL,
    `privilege`         varchar(256)                                                NOT NULL,
    PRIMARY KEY (`ident`),
    UNIQUE INDEX (`label`),
    UNIQUE INDEX (`package`, `privilege`)
) DEFAULT CHARACTER SET UTF8;

/*============================================================================*/
/* Tablas necesarias para el registro de manejadores de region                */
/*============================================================================*/

DROP TABLE IF EXISTS `region`;
CREATE TABLE `region` (
    `ident`             int unsigned                                                NOT NULL auto_increment,
    `label`             varchar(16)                                                 NOT NULL,
    `package`           varchar(32)                                                 NOT NULL,
    `script`            varchar(32)                                                 NOT NULL,
    `region`            enum('toolbar', 'search', 'menubar', 'footer')              NOT NULL,
    PRIMARY KEY (`ident`),
    UNIQUE INDEX (`package`, `script`)
) DEFAULT CHARACTER SET UTF8;

DROP TABLE IF EXISTS `region_page`;
CREATE TABLE `region_page` (
    `page`              int unsigned                                                NOT NULL,
    `region`            int unsigned                                                NOT NULL,
    PRIMARY KEY (`page`, `region`),
    INDEX (page),
    FOREIGN KEY (page)            REFERENCES page(ident) ON UPDATE CASCADE ON DELETE RESTRICT,
    INDEX (region),
    FOREIGN KEY (region)          REFERENCES region(ident) ON UPDATE CASCADE ON DELETE RESTRICT
) DEFAULT CHARACTER SET UTF8;

/*============================================================================*/
/* Tablas necesarias para el registro de manejadores de widgets               */
/*============================================================================*/

DROP TABLE IF EXISTS `widget`;
CREATE TABLE `widget` (
    `ident`             int unsigned                                                NOT NULL auto_increment,
    `label`             varchar(64)                                                 NOT NULL,
    `title`             varchar(32)                                                 NOT NULL,
    `package`           varchar(32)                                                 NOT NULL,
    `script`            varchar(32)                                                 NOT NULL,
    PRIMARY KEY (`ident`),
    UNIQUE INDEX (`package`, `script`)
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

/*============================================================================*/
/* Registro del paquete                                                       */
/*============================================================================*/
INSERT INTO `package`
(`ident`, `label`, `url`, `type`, `parent`, `tsregister`, `description`)
VALUES
(1, 'base', 'base', 'base', NULL, UNIX_TIMESTAMP(), 'Paquete gestor de pagina principal');
