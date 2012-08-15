
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
(`label`, `url`, `type`, `parent`, `tsregister`, `description`)
VALUES
('login', 'login', 'middle', 'users', UNIX_TIMESTAMP(), 'Modulo manejador de acceso de los usuarios');

/*============================================================================*/
/* Registro de rutas para el paquete                                          */
/*============================================================================*/
INSERT INTO `route`
(`label`, `type`, `parent`, `route`, `mapping`, `module`, `controller`, `action`)
VALUES
('Ingresar al sistema',  'view',   'base', 'login_in',     'login',  'login', 'index',  'in'),
('',                     'action', 'base', 'login_out',    'logout', 'login', 'index',  'out'),
('Olvide mi contraseña', 'view',   'base', 'login_forgot', 'forgot', 'login', 'forgot', 'index');

INSERT INTO `route_privilege`
(`route`, `package`, `privilege`)
VALUES
('login_in',     'login', 'in'),
('login_forgot', 'login', 'forgot');
