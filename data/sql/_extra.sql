
/*============================================================================*/
/* Conecciones adicionales para la habilitacion de los menus                  */
/*============================================================================*/
UPDATE `page` SET `menutype` = 'menubar', `menuorder` = 1 WHERE `route` = 'base_visitor';
UPDATE `page` SET `menutype` = 'menubar', `menuorder` = 2 WHERE `route` = 'users_list';
UPDATE `page` SET `menutype` = 'menubar', `menuorder` = 3 WHERE `route` = 'friends_friends';
UPDATE `page` SET `menutype` = 'menubar', `menuorder` = 4 WHERE `route` = 'gestions_list';
UPDATE `page` SET `menutype` = 'menubar', `menuorder` = 5 WHERE `route` = 'careers_list';
UPDATE `page` SET `menutype` = 'menubar', `menuorder` = 6 WHERE `route` = 'areas_list';
UPDATE `page` SET `menutype` = 'menubar', `menuorder` = 7 WHERE `route` = 'subjects_list';
UPDATE `page` SET `menutype` = 'menubar', `menuorder` = 8 WHERE `route` = 'communities_list';

UPDATE `page` SET `menutype` = 'footer', `menuorder` =  1 WHERE `route` = 'packages_list';
UPDATE `page` SET `menutype` = 'footer', `menuorder` =  2 WHERE `route` = 'pages_list';
UPDATE `page` SET `menutype` = 'footer', `menuorder` =  3 WHERE `route` = 'widgets_list';
UPDATE `page` SET `menutype` = 'footer', `menuorder` =  4 WHERE `route` = 'roles_list';
UPDATE `page` SET `menutype` = 'footer', `menuorder` =  5 WHERE `route` = 'resources_list';
UPDATE `page` SET `menutype` = 'footer', `menuorder` =  6 WHERE `route` = 'templates_list';
UPDATE `page` SET `menutype` = 'footer', `menuorder` =  7 WHERE `route` = 'tags_list';
UPDATE `page` SET `menutype` = 'footer', `menuorder` =  8 WHERE `route` = 'analytics_list';
UPDATE `page` SET `menutype` = 'footer', `menuorder` =  9 WHERE `route` = 'feedback_list';
UPDATE `page` SET `menutype` = 'footer', `menuorder` = 10 WHERE `route` = 'base_development';
UPDATE `page` SET `menutype` = 'footer', `menuorder` = 11 WHERE `route` = 'base_terms';
UPDATE `page` SET `menutype` = 'footer', `menuorder` = 12 WHERE `route` = 'base_privacy';

/*============================================================================*/
/* Conecciones adicionales para la habilitacion de los widgets                */
/*============================================================================*/
INSERT INTO `widget_page`
(`page`, `widget`, `position`)
VALUES
/*============================================================================*/
/* Inserciones extra para el paquete MENUS                                    */
/*============================================================================*/
/* Pagina principal anonima */
( 1, 5, 2), /* Calificaciones */
( 1, 1, 3), /* Espacios */
( 1, 2, 4), /* Links */

/* Pagina principal de usuario */
( 2, 4, 1), /* Recursos */
( 2, 5, 2), /* Calificaciones */
( 2, 1, 3), /* Espacios */
( 2, 3, 4), /* Contactos */

/* USERS */
( 27, 1, 3),
( 27, 4, 1),

/* PROFILE */
( 29, 1, 3),
( 29, 4, 1),

/* SUBJECTS */
( 48, 1, 3),
( 48, 4, 1),
( 50, 1, 3),
( 50, 4, 1),

/* AREAS */
( 57, 1, 3),
( 57, 4, 1),

/* CAREERS */
( 62, 1, 3),
( 62, 4, 1),

/* GROUPS */
( 67, 1, 3),
( 67, 4, 1),
( 70, 1, 3),
( 70, 4, 1),

/* TEAMS */
( 76, 1, 3),
( 76, 4, 1),

/* COMMUNITIES */
( 82, 1, 3),
( 82, 4, 1),
( 84, 1, 3),
( 84, 4, 1),

/* SETS */
( 86, 1, 3),
( 86, 4, 1),
( 87, 1, 3),
( 87, 4, 1),
( 88, 1, 3),
( 88, 4, 1),

/* RESOURCES */
( 90, 1, 3),
( 90, 4, 1),
( 91, 1, 3),
( 91, 4, 1),

/* NOTES */
( 92, 1, 3),
( 92, 4, 1),
( 93, 1, 3),
( 93, 4, 1),
( 94, 1, 3),
( 94, 4, 1),

/* LINKS */
( 95, 1, 3),
( 95, 4, 1),
( 96, 1, 3),
( 96, 4, 1),
( 97, 1, 3),
( 97, 4, 1),

/* FILES */
( 98, 1, 3),
( 98, 4, 1),
( 99, 1, 3),
( 99, 4, 1),
(100, 1, 3),
(100, 4, 1),

/* EVENTS */
(101, 1, 3),
(101, 4, 1),
(102, 1, 3),
(102, 4, 1),
(103, 1, 3),
(103, 4, 1),

/* PHOTOS */
(104, 1, 3),
(104, 4, 1),
(105, 1, 3),
(105, 4, 1),
(106, 1, 3),
(106, 4, 1),

/* VIDEOS */
(107, 1, 3),
(107, 4, 1),
(108, 1, 3),
(108, 4, 1),
(109, 1, 3),
(109, 4, 1),

/* EVALUATIONS */
(110, 1, 3),
(110, 4, 1),
(111, 1, 3),
(111, 4, 1),
(112, 1, 3),
(112, 4, 1),

/* CALIFICATIONS */
(119, 5, 3),

/* FEEDBACK */
(123, 1, 3),
(123, 4, 1),
(124, 1, 3),
(124, 4, 1),
(125, 1, 3),
(125, 4, 1),
(126, 1, 3),
(126, 4, 1),
(127, 1, 3),
(127, 4, 1);

/*============================================================================*/
/* Insercion de roles del sistema                                             */
/*============================================================================*/
INSERT INTO `role`
(`label`, `url`, `tsregister`, `description`)
VALUES
('Visitante',     'visitante',     UNIX_TIMESTAMP(), 'Usuario no registrado en el sistema.'),
('Invitado',      'invitado',      UNIX_TIMESTAMP(), 'Usuario invitado por un docente para la colaboración en un curso.'),
('Estudiante',    'estudiante',    UNIX_TIMESTAMP(), 'Usuario inscrito y registrado en un curso.'),
('Auxiliar',      'auxiliar',      UNIX_TIMESTAMP(), 'Usuario encargado del apoyo a la enseñanza de un curso.'),
('Docente',       'docente',       UNIX_TIMESTAMP(), 'Usuario encargado de la administración de un curso.'),
('Moderador',     'moderador',     UNIX_TIMESTAMP(), 'Usuario encargado de la administración de una materia.'),
('Desarrollador', 'desarrollador', UNIX_TIMESTAMP(), 'Usuario encargado de el desarrollo del sistema.'),
('Administrador', 'administrador', UNIX_TIMESTAMP(), 'Usuario encargado de la administración del sistema.');

INSERT INTO `role_privilege`
(`role`, `privilege`)
VALUES
/*============================================================================*/
/* Inserciones extra para el paquete MODULES                                  */
/*============================================================================*/
( 8, 1), ( 8, 2), ( 8, 3),
( 7, 1), ( 7, 2), ( 7, 3),
( 6, 1),          ( 6, 3),
( 5, 1),          ( 5, 3),
/*============================================================================*/
/* Inserciones extra para el paquete PAGES                                    */
/*============================================================================*/
( 8, 4), ( 8, 5),
( 7, 4), ( 7, 5),
( 6, 4), ( 6, 5),
/*============================================================================*/
/* Inserciones extra para el paquete WIDGETS                                  */
/*============================================================================*/
( 8, 6), ( 8, 7),
( 7, 6), ( 7, 7),
( 6, 6), ( 6, 7),
/*============================================================================*/
/* Inserciones extra para el paquete ROLES                                    */
/*============================================================================*/
( 8, 8), ( 8, 9), ( 8,10), ( 8,11), ( 8,12), ( 8,13),
( 7, 8),                   ( 7,11),
( 6, 8),                   ( 6,11),
/*============================================================================*/
/* Inserciones extra para el paquete USERS                                    */
/*============================================================================*/
( 8,14), ( 8,15), ( 8,16), ( 8,17), ( 8,18), ( 8,19), ( 8,20), ( 8,21),
( 7,14),                            ( 7,18),          ( 7,20),
( 6,14), ( 6,15), ( 6,16), ( 6,17), ( 6,18), ( 6,19), ( 6,20),
( 5,14), ( 5,15), ( 5,16), ( 5,17), ( 5,18), ( 5,19),
( 4,14),                            ( 4,18),
( 3,14),                            ( 3,18),
( 2,14),                            ( 2,18),
( 1,14),                            ( 1,18),
/*============================================================================*/
/* Inserciones extra para el paquete FRIENDS                                  */
/*============================================================================*/
( 8,22),
( 7,22),
( 6,22),
( 5,22),
( 4,22),
( 3,22),
( 2,22),
/*============================================================================*/
/* Inserciones extra para el paquete INVITATIONS                              */
/*============================================================================*/
( 8,23),
( 7,23),
( 6,23),
( 5,23),
( 4,23),
( 3,23),
/*============================================================================*/
/* Inserciones extra para el paquete GESTIONS                                 */
/*============================================================================*/
( 8,24), ( 8,25), ( 8,26), ( 8,27), ( 8,28),
( 7,24),                            ( 7,28),
( 6,24),                            ( 6,28),
( 5,24),                            ( 5,28),
( 4,24),                            ( 4,28),
( 3,24),                            ( 3,28),
( 2,24),                            ( 2,28),
( 1,24),                            ( 1,28),
/*============================================================================*/
/* Inserciones extra para el paquete SUBJECTS                                 */
/*============================================================================*/
( 8,29), ( 8,30), ( 8,31), ( 8,32), ( 8,33), ( 8,34), ( 8,35), ( 8,36), ( 8,37), ( 8,38), ( 8,39), ( 8,40), ( 8,41),
( 7,29),                            ( 7,33),          ( 7,35),          ( 7,37), ( 7,38), ( 7,39), ( 7,40), ( 7,41),
( 6,29),                            ( 6,33),                            ( 6,37), ( 6,38), ( 6,39), ( 6,40), ( 6,41),
( 5,29),                            ( 5,33),                            ( 5,37), ( 5,38), ( 5,39), ( 5,40), ( 5,41),
( 4,29),                            ( 4,33),                                              ( 4,39), ( 4,40), ( 4,41),
( 3,29),                            ( 3,33),                                                       ( 3,40), ( 3,41),
( 2,29),                            ( 2,33),                                                                ( 2,41),
( 1,29),                            ( 1,33),
/*============================================================================*/
/* Inserciones extra para el paquete AREAS                                    */
/*============================================================================*/
( 8,42), ( 8,43), ( 8,44), ( 8,45), ( 8,46),
( 7,42),                   ( 7,45),
( 6,42),                   ( 6,45),
( 5,42),                   ( 5,45),
( 4,42),                   ( 4,45),
( 3,42),                   ( 3,45),
( 2,42),                   ( 2,45),
( 1,42),                   ( 1,45),
/*============================================================================*/
/* Inserciones extra para el paquete CAREERS                                  */
/*============================================================================*/
( 8,47), ( 8,48), ( 8,49), ( 8,50), ( 8,51),
( 7,47),                   ( 7,50),
( 6,47),                   ( 6,50),
( 5,47),                   ( 5,50),
( 4,47),                   ( 4,50),
( 3,47),                   ( 3,50),
( 2,47),                   ( 2,50),
( 1,47),                   ( 1,50),
/*============================================================================*/
/* Inserciones extra para el paquete COMMUNITIES                              */
/*============================================================================*/
( 8,52), ( 8,53), ( 8,54),
( 7,52), ( 7,53), ( 7,54),
( 6,52), ( 6,53), ( 6,54),
( 5,52), ( 5,53), ( 5,54),
( 4,52), ( 4,53), ( 4,54),
( 3,52), ( 3,53), ( 3,54),
( 2,52), ( 2,53), ( 2,54),
( 1,52),          ( 1,54),
/*============================================================================*/
/* Inserciones extra para el paquete RESOURCES                                */
/*============================================================================*/
( 8,55), ( 8,56), ( 8,57), ( 8,58), ( 8,59),
( 7,55), ( 7,56), ( 7,57), ( 7,58),
( 6,55), ( 6,56), ( 6,57), ( 6,58),
( 5,55), ( 5,56), ( 5,57), ( 5,58),
( 4,55), ( 4,56), ( 4,57), ( 4,58),
( 3,55), ( 3,56), ( 3,57), ( 3,58),
( 2,55), ( 2,56), ( 2,57), ( 2,58),
         ( 1,56),
/*============================================================================*/
/* Inserciones extra para el paquete VIDEOS                                   */
/*============================================================================*/
( 8,60),
( 7,60),
( 6,60),
( 5,60),
( 4,60),
/*============================================================================*/
/* Inserciones extra para el paquete COMMENTS                                 */
/*============================================================================*/
( 8,61), ( 8,62), ( 8,63), ( 8,64),
( 7,61), ( 7,62), ( 7,63),
( 6,61), ( 6,62), ( 6,63),
( 5,61), ( 5,62), ( 5,63),
( 4,61), ( 4,62), ( 4,63),
( 3,61), ( 3,62), ( 3,63),
( 2,61), ( 2,62), ( 2,63),
         ( 1,62),
/*============================================================================*/
/* Inserciones extra para el paquete RATINGS                                  */
/*============================================================================*/
( 8,65),
( 7,65),
( 6,65),
( 5,65),
( 4,65),
( 3,65),
( 2,65),
/*============================================================================*/
/* Inserciones extra para el paquete TAGS                                     */
/*============================================================================*/
( 8,66), (8,67),
( 7,66), (7,67),
( 6,66), (6,67),
( 5,66), (5,67),
( 4,66),
( 3,66),
( 2,66),
( 1,66),
/*============================================================================*/
/* Inserciones extra para el paquete FEEDBACK                                 */
/*============================================================================*/
( 8,68), ( 8,69), ( 8,70), ( 8,71),
( 7,68), ( 7,69), ( 7,70), ( 7,71),
( 6,68),
( 5,68),
( 4,68),
( 3,68),
( 2,68),
/*============================================================================*/
/* Inserciones extra para el paquete THEMES                                   */
/*============================================================================*/
( 8,72), ( 8,73),
( 7,72), ( 7,73),
( 6,72), ( 6,73),
( 5,72), ( 5,73),
( 4,72), ( 4,73),
( 3,72), ( 3,73),
( 2,72), ( 2,73),
/*============================================================================*/
/* Inserciones extra para el paquete ANALYTICS                                */
/*============================================================================*/
( 8,74),
( 7,74),
( 6,74),
( 5,74),
( 4,74),
( 3,74),
( 2,74);

INSERT INTO `user`
(`role`, `label`, `url`, `password`, `tsregister`, `status`, `surname`, `name`)
VALUES
(8, 'admin', 'admin', md5(CONCAT('KQ01805XG4GLTZHIFX19K0GR3G0K537F','asdf')), UNIX_TIMESTAMP(), 'active', 'Administrador', 'Señor');

INSERT INTO `evaluation`
(`author`, `label`, `access`, `tsregister`, `useful`, `description`)
VALUES
(1, 'Metodo clasico', 'public', UNIX_TIMESTAMP(), TRUE, 'El metodo clasico de evaluacion');

INSERT INTO `evaluation_test`
(`evaluation`, `label`, `key`, `order`, `minimumnote`, `defaultnote`, `maximumnote`, `formula`)
VALUES
(1, '1er Parcial',   '1P',  1, 0, 1, 100, null),
(1, '2do Parcial',   '2P',  2, 0, 1, 100, null),
(1, 'Promedio',      'PP',  3, 0, 1, 100, '(1P + 2P) / 2'),
(1, 'Examen Final',  'EF',  4, 0, 1, 100, null),
(1, '2da Instancia', '2I',  5, 0, 1,  51, null),
(1, 'Observaciones', 'Obs', 6, 0, 1, 100, 'PROXIMO(MAXIMO(PP, EF, 2I) - 1, 100, 0)');

INSERT INTO `evaluation_test_value`
(`evaluation`, `test`, `label`, `value`)
VALUES
(1, 6, 'Reprobado', 0),
(1, 6, 'Aprobado',  100);

INSERT INTO `template`
(`label`, `description`, `doctype`, `tsregister`, `css_properties`)
VALUES
('minimal', 'Plantilla basica diseñada especialmente para navegadores antiguos o de compatibilidades dudosas', 'HTML4_LOOSE', UNIX_TIMESTAMP(), '{}'),
('webarte', 'Plantilla simple que utiliza hoja de estilos y no javascript', 'XHTML1_STRICT', UNIX_TIMESTAMP(), '{"background":"#FFFFFF", "background_headers":"#3B5998","background_headers2":"#627AAD","background_messages":"#FEFFDD","color_headers":"#FFFFFF","color_borders":"#E2E2E2","color_letters":"#333333"}');
