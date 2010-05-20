
/*====================================================================================================================*/
/* Registro de inserciones para el modulo de autentificacion                                                          */
/*====================================================================================================================*/


/*====================================================================================================================*/
/* Tablas requeridas para el registro de peticiones de nueva contraseña                                               */
/*====================================================================================================================*/

DROP TABLE IF EXISTS `login_forgot`;
CREATE TABLE `login_forgot` (
    `ident`             int unsigned                                                NOT NULL auto_increment,
    `user`              int unsigned                                                NOT NULL,
    `password`          varchar(64)                                                 NOT NULL,
    `tsregister`        int unsigned                                                NOT NULL,
    `tstimeout`         int unsigned                                                NOT NULL,
    PRIMARY KEY (`ident`),
    UNIQUE INDEX (`user`),
    FOREIGN KEY (`user`)          REFERENCES `user`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT
) DEFAULT CHARACTER SET UTF8;

/*====================================================================================================================*/
/* Registro del modulo                                                                                                */
/*====================================================================================================================*/
INSERT INTO `module`
(`label`,          `url`,              `type`,        `tsregister`,       `description`)
VALUES
('login',          'login',            'platform',    UNIX_TIMESTAMP(),   'Modulo manejador de acceso de los usuarios');

/*====================================================================================================================*/
/* Registro de paginas para el modulo                                                                                 */
/*====================================================================================================================*/
INSERT INTO `page`
(`label`,                         `title`,            `menuable`,    `module`,           `controller`,  `action`,           `privilege`,             `route`)
VALUES
('Ingresar al sistema',           'Ingresar',         TRUE,          'login',            'index',       'in',               'in',                    'login_in'),
('Salir del sistema',             'Salir',            TRUE,          'login',            'index',       'out',              'out',                   'login_out'),
('Olvide mi contraseña',          'Contraseña',       TRUE,          'login',            'forgot',      'index',            'forgot',                'login_forgot');
