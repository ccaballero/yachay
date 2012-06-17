
/*============================================================================*/
/* Registro de inserciones para el paquete de autentificacion                 */
/*============================================================================*/

/*============================================================================*/
/* Tablas requeridas para el registro de peticiones de nueva contraseña       */
/*============================================================================*/
DROP TABLE IF EXISTS `login_forgot`;
CREATE TABLE `login_forgot` (
    `ident`      int unsigned NOT NULL auto_increment,
    `user`       int unsigned NOT NULL,
    `password`   varchar(64)  NOT NULL,
    `tsregister` int unsigned NOT NULL,
    `tstimeout`  int unsigned NOT NULL,
    PRIMARY KEY (`ident`),
    UNIQUE INDEX (`user`),
    FOREIGN KEY (`user`) REFERENCES `user`(`ident`) ON UPDATE CASCADE ON DELETE RESTRICT
) DEFAULT CHARACTER SET UTF8;

/*============================================================================*/
/* Registro del paquete                                                       */
/*============================================================================*/
INSERT INTO `package`
(`label`, `url`, `type`, `tsregister`, `description`)
VALUES
('login', 'login', 'platform', UNIX_TIMESTAMP(), 'Modulo manejador de acceso de los usuarios');

/*============================================================================*/
/* Registro de paginas para el paquete                                        */
/*============================================================================*/
INSERT INTO `page`
(`label`, `title`, `menuable`, `package`, `controller`, `action`, `privilege`, `route`)
VALUES
('Ingresar al sistema',  'Ingresar',   TRUE, 'login', 'index',  'in',    'in',     'login_in'),
('Olvide mi contraseña', 'Contraseña', TRUE, 'login', 'forgot', 'index', 'forgot', 'login_forgot');
