
/*============================================================================*/
/* Registro de recursos para la pagina principal                              */
/*============================================================================*/

/*============================================================================*/
/* Registro del paquete                                                       */
/*============================================================================*/
INSERT INTO `package`
(`label`, `url`, `type`, `dependency`, `tsregister`, `description`)
VALUES
('base', 'base', 'middle', 'spaces', UNIX_TIMESTAMP(), 'Modulo manejador de la pagina de inicio');

/*============================================================================*/
/* Registro de paginas para el paquete                                        */
/*============================================================================*/
INSERT INTO `page`
(`label`, `title`, `menuable`, `package`, `controller`, `action`, `route`)
VALUES
('Pagina inicial',         'Inicio',          TRUE,  'frontpage', 'index',  'visitor',     'frontpage_visitor'),
('Pagina de usuario',      '',                FALSE, 'frontpage', 'index',  'user',        'frontpage_user'),
('Pagina 404',             '',                FALSE, 'frontpage', 'error',  'error',       'default'),
('Colabora',               'Desarrollo',      TRUE,  'frontpage', 'static', 'development', 'frontpage_development'),
('Terminos de uso',        'Terminos de uso', TRUE,  'frontpage', 'static', 'terms',       'frontpage_terms'),
('Politica de privacidad', 'Privacidad',      TRUE,  'frontpage', 'static', 'privacy',     'frontpage_privacy');

/*============================================================================*/
/* Registro de widgets para el paquete                                        */
/*============================================================================*/
INSERT INTO `widget`
(`label`, `title`, `package`, `script`)
VALUES
('Espacios Disponibles', 'Espacios Disponibles', 'base', 'context');
