
/*============================================================================*/
/* Tablas necesarias para el paquete de templates                             */
/*============================================================================*/
DROP TABLE IF EXISTS `template`;
CREATE TABLE `template` (
    `ident`          int unsigned NOT NULL auto_increment,
    `label`          varchar(64)  NOT NULL,
    `parent`         varchar(64)  NOT NULL DEFAULT '',
    `description`    text         NOT NULL DEFAULT '',
    `doctype`        varchar(32)  NOT NULL,
    `css_properties` text         NOT NULL,
    `tsregister`     int unsigned NOT NULL,
    PRIMARY KEY (`ident`),
    UNIQUE INDEX (`label`)
) DEFAULT CHARACTER SET UTF8;

DROP TABLE IF EXISTS `template_user`;
CREATE TABLE `template_user` (
    `template`       int unsigned NOT NULL,
    `user`           int unsigned NOT NULL,
    `css_properties` text         NOT NULL,
    PRIMARY KEY (`template`, `user`),
    INDEX (`template`),
    FOREIGN KEY (`template`) REFERENCES `template`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT,
    INDEX (`user`),
    FOREIGN KEY (`user`) REFERENCES `user`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT
) DEFAULT CHARACTER SET UTF8;

/*============================================================================*/
/* Registro del paquete                                                       */
/*============================================================================*/
INSERT INTO `package`
(`label`, `url`, `type`, `tsregister`, `description`)
VALUES
('templates', 'templates', 'platform', UNIX_TIMESTAMP(), 'Modulo manejador de las plantillas web del sistema');

/*============================================================================*/
/* Registro de paginas para el paquete                                        */
/*============================================================================*/
INSERT INTO `page`
(`label`, `title`, `menuable`, `package`, `controller`, `action`, `privilege`, `route`)
VALUES
('Lista de temas',       'Temas', TRUE,  'templates', 'index',    'index', 'switch',    'templates_list'),
('Propiedades del tema', '',      FALSE, 'templates', 'template', 'view',  'configure', 'templates_template_view');

/*============================================================================*/
/* Registro de privilegios para el paquete                                    */
/*============================================================================*/
INSERT INTO `privilege`
(`label`, `package`, `privilege`)
VALUES
('Cambiar la plantilla', 'templates', 'switch'),
('Personalizar la plantilla', 'templates', 'configure');
