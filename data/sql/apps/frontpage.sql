
/*============================================================================*/
/* Registro de recursos para la pagina principal                              */
/*============================================================================*/

/*============================================================================*/
/* Registro del paquete                                                       */
/*============================================================================*/
-- INSERT INTO `package`
-- (`label`, `url`, `type`, `parent`, `tsregister`, `description`)
-- VALUES
-- ('base', 'base', 'middle', 'spaces', UNIX_TIMESTAMP(), 'Modulo manejador de la pagina de inicio');

/*============================================================================*/
/* Registro de paginas para el paquete                                        */
/*============================================================================*/
INSERT INTO `page`
(`label`, `title`, `menuable`, `package`, `controller`, `action`, `route`)
VALUES
('Pagina inicial',         'Inicio',          TRUE,  'base', 'index',  'visitor',     'base_visitor'),
('Pagina de usuario',      '',                FALSE, 'base', 'index',  'user',        'base_user'),
('Pagina 404',             '',                FALSE, 'base', 'error',  'error',       'default'),
('Colabora',               'Desarrollo',      TRUE,  'base', 'static', 'development', 'base_development'),
('Terminos de uso',        'Terminos de uso', TRUE,  'base', 'static', 'terms',       'base_terms'),
('Politica de privacidad', 'Privacidad',      TRUE,  'base', 'static', 'privacy',     'base_privacy');

/*============================================================================*/
/* Registro de widgets para el paquete                                        */
/*============================================================================*/
INSERT INTO `widget`
(`label`, `title`, `package`, `script`)
VALUES
('Espacios Disponibles', 'Espacios Disponibles', 'base', 'context');
