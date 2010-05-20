
/*====================================================================================================================*/
/* Tablas necesarias para el registro de manejadores de region                                                        */
/*====================================================================================================================*/

DROP TABLE IF EXISTS `region`;
CREATE TABLE `region` (
    `ident`             int unsigned                                                NOT NULL auto_increment,
    `label`             varchar(16)                                                 NOT NULL,
    `module`            varchar(32)                                                 NOT NULL,
    `script`            varchar(32)                                                 NOT NULL,
    `region`            enum('toolbar', 'search', 'menubar', 'footer')              NOT NULL,
    PRIMARY KEY (`ident`),
    UNIQUE INDEX (`module`, `script`)
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

/*====================================================================================================================*/
/* Registro del modulo                                                                                                */
/*====================================================================================================================*/
INSERT INTO `module`
(`label`,          `url`,              `type`,        `tsregister`,       `description`)
VALUES
('regions',        'regions',          'platform',    UNIX_TIMESTAMP(),   'Modulo de configuracion para las regiones por pagina');

/*====================================================================================================================*/
/* Registro de paginas para el modulo                                                                                 */
/*====================================================================================================================*/
INSERT INTO `page`
(`label`,                         `title`,            `menuable`,    `module`,           `controller`,  `action`,           `privilege`,             `route`)
VALUES
('Lista de regiones',             'Regiones',         TRUE,          'regions',          'index',       'index',            'list',                  'regions_list'),
('Administrador de regiones',     'Regiones',         TRUE,          'regions',          'manager',     'index',            'manage',                'regions_manager');

/*====================================================================================================================*/
/* Registro de privilegios para el modulo                                                                             */
/*====================================================================================================================*/
INSERT INTO `privilege`
(`label`,                                                         `module`,           `privilege`)
VALUES
('Listar la configuracion de las regiones por pagina',            'regions',          'list'),
('Configuracion de las regiones por pagina',                      'regions',          'manage');
