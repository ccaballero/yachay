
/*====================================================================================================================*/
/* Datos de implantacion del sistema                                                                                  */
/*====================================================================================================================*/

UPDATE `user` SET `activity` = 1 WHERE `ident` = 1;

INSERT INTO `user`
(`role`, `label`,       `url`,         `tsregister`,     `status`,   `formalname`,        `surname`,          `name`,        `code`,    `activity`, `participation`, `sociability`, `popularity`)
VALUES
(7,      'antonio',     'antonio',     UNIX_TIMESTAMP(), 'active',   'MAMANI ANTONIO',    'Mamani',           'Antonio',     200212474, 5,          0,                4,            0), /*  2 */
(6,      'carlos',      'carlos',      UNIX_TIMESTAMP(), 'active',   'CABALLERO CARLOS',  'Caballero',        'Carlos',      200323785, 2,          2,               11,            0), /*  3 */
(5,      'leticia',     'leticia',     UNIX_TIMESTAMP(), 'active',   'BLANCO LETICIA',    'Blanco',           'Leticia',     200437576, 2,          2,                4,            0), /*  4 */
(5,      'ruperto',     'ruperto',     UNIX_TIMESTAMP(), 'active',   'LEON RUPERTO',      'Leon',             'Ruperto',     200175667, 0,          0,                1,            0), /*  5 */
(5,      'johnny',      'johnny',      UNIX_TIMESTAMP(), 'active',   'ARIAS JHONNY',      'Arias',            'Jhonny',      200257678, 0,          0,                2,            0), /*  6 */
(5,      'americo',     'americo',     UNIX_TIMESTAMP(), 'active',   'VARGAS AMERICO',    'Vargas',           'Americo',     200346789, 0,          0,                0,            0), /*  7 */
(5,      'indira',      'indira',      UNIX_TIMESTAMP(), 'active',   'CAMACHO INDIRA',    'Camacho',          'Indira',      200437870, 2,          0,                0,            0), /*  8 */
(5,      'carrasco',    'carrasco',    UNIX_TIMESTAMP(), 'active',   'CARRASCO ALVARO',   'Carrasco',         'Alvaro',      200529877, 0,          0,                0,            0), /*  9 */
(4,      'viviana',     'viviana',     UNIX_TIMESTAMP(), 'active',   'MORALES VIVIANA',   'Morales',          'Viviana',     200687577, 1,          0,                0,            0), /* 10 */
(4,      'juanpa',      'juanpa',      UNIX_TIMESTAMP(), 'inactive', 'RUIZ JUAN PABLO',   'Ruiz',             'Juan Pablo',  200776154, 7,          0,                0,            0), /* 11 */
(4,      'christian',   'christian',   UNIX_TIMESTAMP(), 'active',   'MAMANI CHRISTIAN',  'Mamani',           'Christian',   200865043, 0,          0,                0,            0), /* 12 */
(4,      'wilfredo',    'wilfredo',    UNIX_TIMESTAMP(), 'active',   'VARGAS WILFREDO',   'Vargas',           'Wilfredo',    200954932, 0,          0,                0,            0), /* 13 */
(3,      'luis',        'luis',        UNIX_TIMESTAMP(), 'active',   'ARCE LUIS',         'Arce',             'Luis',        200048321, 1,          0,                0,            0), /* 14 */
(3,      'pedro',       'pedro',       UNIX_TIMESTAMP(), 'active',   'VALDES PEDRO',      'Valdes',           'Pedro',       200636211, 2,          0,                0,            0), /* 15 */
(3,      'juan',        'juan',        UNIX_TIMESTAMP(), 'active',   'GOMEZ JUAN',        'Gomez',            'Juan',        200424121, 5,          0,                0,            0), /* 16 */
(3,      'benjamin',    'benjamin',    UNIX_TIMESTAMP(), 'active',   'PEREZ BENJAMIN',    'Perez',            'Benjamin',    200213212, 2,          0,                0,            0), /* 17 */
(3,      'juanjo',      'juanjo',      UNIX_TIMESTAMP(), 'active',   'OLIVERA JUAN JOSE', 'Olivera',          'Juan Jose',   200237323, 4,          0,                0,            0), /* 18 */
(3,      'tatiana',     'tatiana',     UNIX_TIMESTAMP(), 'active',   'MORUNO TATIANA',    'Moruno',           'Tatiana',     200430434, 1,          0,                0,            0), /* 19 */
(3,      'pablo',       'pablo',       UNIX_TIMESTAMP(), 'active',   'HURTADO PABLO',     'Hurtado',          'Pablo',       200449545, 4,          0,                0,            0), /* 20 */
(3,      'vladimir',    'vladimir',    UNIX_TIMESTAMP(), 'active',   'GARCIA VLADIMIR',   'Garcia',           'Vladimir',    200558656, 2,          0,                0,            0), /* 21 */
(3,      'marcelo',     'marcelo',     UNIX_TIMESTAMP(), 'active',   'PAVON MARCELO',     'Pavon',            'Marcelo',     200667667, 1,          0,                0,            0), /* 22 */
(3,      'jorge',       'jorge',       UNIX_TIMESTAMP(), 'active',   'ALAMEDA JORGE',     'Alameda',          'Jorge',       200788578, 5,          0,                0,            0), /* 23 */
(3,      'eduardo',     'eduardo',     UNIX_TIMESTAMP(), 'active',   'DIPP EDUARDO',      'Dipp',             'Eduardo',     200879489, 5,          0,                0,            2), /* 24 */
(3,      'hugo',        'hugo',        UNIX_TIMESTAMP(), 'active',   'ALCONZ HUGO',       'Alconz',           'Hugo',        200904390, 2,          0,                0,            0), /* 25 */
(2,      'alexey',      'alexey',      UNIX_TIMESTAMP(), 'inactive', 'RODRIGUEZ ALEXEY',  'Rodriguez',        'Alexey',      200982298, 1,          0,                0,            0), /* 26 */
(2,      'aquilino',    'aquilino',    UNIX_TIMESTAMP(), 'active',   'DAVALOS AQUILINO',  'Davalos',          'Aquilino',    200873187, 0,          0,                0,            0); /* 27 */

INSERT INTO `friend`
(`user`, `friend`, `mutual`, `tsregister`)
VALUES
( 3,  2, TRUE,  UNIX_TIMESTAMP()),
( 3,  4, TRUE,  UNIX_TIMESTAMP()),
( 2,  3, TRUE,  UNIX_TIMESTAMP()),
( 4,  3, TRUE,  UNIX_TIMESTAMP()),
( 3,  5, FALSE, UNIX_TIMESTAMP()),
( 6,  3, FALSE, UNIX_TIMESTAMP());

INSERT INTO `community`
(`label`,          `url`,              `mode`,   `author`, `members`,     `tsregister`,     `interests`, `description`)
VALUES
('Gentoosa',       'gentoosa',         'open',   3,        3,             UNIX_TIMESTAMP(), 'linux, gentoo, software libre', 'Gente que use la distribucion Gentoo, o que simplemente le encante compilar su kernel'),
('FechaFiferos',   'fechafiferos',     'close',  18,       1,             UNIX_TIMESTAMP(), 'futbol, deporte, umss', 'Los que juegan futbol cada sabado en las canchas de la U');

INSERT INTO `community_user`
(`community`, `user`, `type`, `status`, `tsregister`)
VALUES
(1,  3, 'moderator', 'active', UNIX_TIMESTAMP()),
(1, 15, 'moderator', 'active', UNIX_TIMESTAMP()),
(1, 23, 'member',    'active', UNIX_TIMESTAMP()),
(2, 18, 'moderator', 'active', UNIX_TIMESTAMP());

INSERT INTO `gestion`
(`label`,          `url`,              `status`,      `tsregister`)
VALUES
('2009/01',        '2009-01',          'inactive',    UNIX_TIMESTAMP()),
('2009/02',        '2009-02',          'active',      UNIX_TIMESTAMP());

INSERT INTO `subject`
(`gestion`, `author`, `moderator`, `code`,  `label`,                           `url`,                            `tsregister`,     `status`,   `visibility`, `description`)
VALUES
(1,         1,        2,           2010010, 'Introducción a la programación',  'introduccion-a-la-programacion', UNIX_TIMESTAMP(), 'active',   'public',     'Principios de programacion'),
(1,         1,        2,           2010003, 'Elementos de programación',       'elementos-de-programacion',      UNIX_TIMESTAMP(), 'active',   'register',   'Estructuras de datos'),
(1,         1,        2,           2008054, 'Calculo I',                       'calculo-i',                      UNIX_TIMESTAMP(), 'inactive', 'register',   'Matematicas basicas'),
(1,         1,        2,           2008019, 'Algebra I',                       'algebra-i',                      UNIX_TIMESTAMP(), 'inactive', 'private',    'Matematicas basicas'),
(1,         1,        2,           2010018, 'Sistemas de información I',       'sistemas-de-informacion-i',      UNIX_TIMESTAMP(), 'active',   'private',    'Modelamiento de sistemas'),
(1,         1,        2,           2010020, 'Ingeniería de software',          'ingenieria-de-software',         UNIX_TIMESTAMP(), 'active',   'public',     'Modelamiento de sistemas'),
(2,         1,        2,           2010010, 'Introducción a la programación',  'introduccion-a-la-programacion', UNIX_TIMESTAMP(), 'active',   'register',   'Principios de programacion'),
(2,         1,        2,           2010003, 'Elementos de programación',       'elementos-de-programacion',      UNIX_TIMESTAMP(), 'active',   'public',     'Estructuras de datos'),
(2,         1,        2,           2010018, 'Sistemas de información I',       'sistemas-de-informacion_i',      UNIX_TIMESTAMP(), 'active',   'register',   'Modelamiento de sistemas'),
(2,         1,        2,           2010020, 'Ingeniería de software',          'ingenieria-de-software',         UNIX_TIMESTAMP(), 'active',   'public',     'Modelamiento de sistemas'),
(2,         1,        3,           2010027, 'Inteligéncia artificial',         'inteligencia-artificial',        UNIX_TIMESTAMP(), 'active',   'private',    'Imitar el comportamiento del ser humano'),
(2,         1,        3,           2010029, 'Sistemas expertos',               'sistemas-expertos',              UNIX_TIMESTAMP(), 'active',   'public',     'Desarrollar sistemas especializados basados en la inteligencia Artificial');

INSERT INTO `area`
(`label`,                    `url`,                        `description`,                                           `tsregister`)
VALUES
('Programación',             'programacion',               'Area sobre temas de programacion de sistemas',          UNIX_TIMESTAMP()),
('Matematicas',              'matematicas',                'Area sobre topicos matematicos variados',               UNIX_TIMESTAMP()),
('Analisis de sistemas',     'analisis-de-sistemas',       'Area sobre temas respectivos al analisis de sistemas',  UNIX_TIMESTAMP()),
('Inteligencia artificial',  'inteligencia-artificial',    'Area sobre topicos en inteligencia artificial',         UNIX_TIMESTAMP());

INSERT INTO `area_subject`
(`area`, `subject`, `gestion`)
VALUES
( 1, 1, 1),
( 1, 2, 1),
( 3, 1, 1),
( 3, 2, 1),
( 2, 3, 1),
( 2, 4, 1),
( 3, 5, 1),
( 3, 6, 1),
( 1, 7, 2),
( 1, 8, 2),
( 3, 7, 2),
( 3, 8, 2),
( 3, 9, 2),
( 3,10, 2),
( 4,11, 2),
( 4,12, 2);

INSERT INTO `subject_user`
(`subject`, `user`, `type`,     `status`,   `tsregister`)
VALUES
( 1,         4,     'teacher',  'active',   UNIX_TIMESTAMP()),
( 2,         4,     'teacher',  'active',   UNIX_TIMESTAMP()),
( 3,         5,     'teacher',  'active',   UNIX_TIMESTAMP()),
( 4,         9,     'teacher',  'active',   UNIX_TIMESTAMP()),
( 5,         8,     'teacher',  'active',   UNIX_TIMESTAMP()),
( 6,         8,     'teacher',  'active',   UNIX_TIMESTAMP()),
( 1,        10,     'auxiliar', 'active',   UNIX_TIMESTAMP()),
( 2,        11,     'auxiliar', 'active',   UNIX_TIMESTAMP()),
( 6,        12,     'auxiliar', 'active',   UNIX_TIMESTAMP()),
( 1,        14,     'student',  'active',   UNIX_TIMESTAMP()),
( 1,        15,     'student',  'active',   UNIX_TIMESTAMP()),
( 1,        16,     'student',  'active',   UNIX_TIMESTAMP()),
( 1,        17,     'student',  'active',   UNIX_TIMESTAMP()),
( 1,        18,     'student',  'inactive', UNIX_TIMESTAMP()),
( 1,        19,     'student',  'active',   UNIX_TIMESTAMP()),
( 2,        20,     'student',  'active',   UNIX_TIMESTAMP()),
( 2,        21,     'student',  'active',   UNIX_TIMESTAMP()),
( 2,        22,     'student',  'active',   UNIX_TIMESTAMP()),
( 2,        23,     'student',  'active',   UNIX_TIMESTAMP()),
( 3,        14,     'student',  'active',   UNIX_TIMESTAMP()),
( 3,        18,     'student',  'active',   UNIX_TIMESTAMP()),
( 4,        23,     'student',  'active',   UNIX_TIMESTAMP()),
( 4,        25,     'student',  'active',   UNIX_TIMESTAMP()),
( 5,        21,     'student',  'active',   UNIX_TIMESTAMP()),
( 5,        22,     'student',  'active',   UNIX_TIMESTAMP()),
( 5,        23,     'student',  'active',   UNIX_TIMESTAMP()),
( 5,        24,     'student',  'active',   UNIX_TIMESTAMP()),
( 1,        26,     'guest',    'active',   UNIX_TIMESTAMP()),
( 4,        26,     'guest',    'active',   UNIX_TIMESTAMP()),
( 7,         4,     'teacher',  'active',   UNIX_TIMESTAMP()),
( 8,         4,     'teacher',  'active',   UNIX_TIMESTAMP()),
( 9,         8,     'teacher',  'active',   UNIX_TIMESTAMP()),
(10,         8,     'teacher',  'active',   UNIX_TIMESTAMP()),
(11,         6,     'teacher',  'active',   UNIX_TIMESTAMP()),
(12,         6,     'teacher',  'active',   UNIX_TIMESTAMP()),
( 7,        10,     'auxiliar', 'active',   UNIX_TIMESTAMP()),
( 8,        11,     'auxiliar', 'active',   UNIX_TIMESTAMP()),
(12,        14,     'auxiliar', 'active',   UNIX_TIMESTAMP()),
( 7,        16,     'student',  'active',   UNIX_TIMESTAMP()),
( 7,        17,     'student',  'active',   UNIX_TIMESTAMP()),
( 8,        18,     'student',  'active',   UNIX_TIMESTAMP()),
( 8,        19,     'student',  'active',   UNIX_TIMESTAMP()),
( 8,        20,     'student',  'active',   UNIX_TIMESTAMP()),
( 8,        21,     'student',  'active',   UNIX_TIMESTAMP()),
( 9,        21,     'student',  'active',   UNIX_TIMESTAMP()),
( 9,        22,     'student',  'active',   UNIX_TIMESTAMP()),
( 9,        23,     'student',  'active',   UNIX_TIMESTAMP()),
( 9,        24,     'student',  'active',   UNIX_TIMESTAMP()),
(10,        22,     'student',  'active',   UNIX_TIMESTAMP()),
(10,        23,     'student',  'active',   UNIX_TIMESTAMP()),
(10,        24,     'student',  'active',   UNIX_TIMESTAMP()),
(10,        25,     'student',  'active',   UNIX_TIMESTAMP()),
(11,        16,     'student',  'active',   UNIX_TIMESTAMP()),
(11,        17,     'student',  'inactive', UNIX_TIMESTAMP()),
(12,        17,     'student',  'active',   UNIX_TIMESTAMP()),
(10,        27,     'guest',    'active',   UNIX_TIMESTAMP());

INSERT INTO `evaluation`
(`author`, `label`,          `access`,  `tsregister`, `useful`, `description`)
VALUES
(1,        'Metodo moderno', 'public',  1249974001,   TRUE,     'El metodo moderno de calificacion');

INSERT INTO `evaluation_test`
(`evaluation`, `label`,         `key`, `order`, `minimumnote`, `defaultnote`, `maximumnote`, `formula`)
VALUES
(2,            '1er Repaso',    '1R',   1,       0,             1,              100,          null),
(2,            '2do Repaso',    '2R',   2,       0,             1,              100,          null),
(2,            '3er Repaso',    '3R',   3,       0,             1,              100,          null),
(2,            '4to Repaso',    '4R',   4,       0,             1,              100,          null),
(2,            'Promedio 1',    'PT1',  5,       0,             1,               80,          'ESCALA(PROMEDIO(1R, 2R, 3R, 4R), 0, 100, 0, 80)'),
(2,            'Trabajo 1',     'T1',   6,       0,             0,               20,          null),
(2,            '1er Parcial',   '1P',   7,       0,             1,              100,          'PT1 + T1'),
(2,            '5to Repaso',    '5R',   8,       0,             1,              100,          null),
(2,            '6to Repaso',    '6R',   9,       0,             1,              100,          null),
(2,            '7mo Repaso',    '7R',  10,       0,             1,              100,          null),
(2,            '8vo Repaso',    '8R',  11,       0,             1,              100,          null),
(2,            'Promedio 2',    'PT2', 12,       0,             1,               80,          'ESCALA(PROMEDIO(5R, 6R, 7R, 8R), 0, 100, 0, 80)'),
(2,            'Trabajo 2',     'T2',  13,       0,             0,               20,          null),
(2,            '2er Parcial',   '2P',  14,       0,             1,              100,          'PT2 + T2'),
(2,            'Promedio',      'PP',  15,       0,             1,              100,          'PROMEDIO(1P, 2P)'),
(2,            'Examen Final',  'EF',  16,       0,             1,              100,          null),
(2,            '2ª Instancia',  '2I',  17,       0,             1,              51,           null),
(2,            'Observaciones', 'Obs', 18,       0,             1,              100,          'PROXIMO(MAXIMO(PP, EF, 2I), 0, 100)');

INSERT INTO `evaluation_test_value`
(`evaluation`, `test`, `label`,         `value`)
VALUES
(2,            12,     'No entregado',    0),
(2,            12,     'Malo',            5),
(2,            12,     'Regular',        10),
(2,            12,     'Bueno',          15),
(2,            12,     'Excelente',      20),
(2,            19,     'No entregado',    0),
(2,            19,     'Malo',            5),
(2,            19,     'Regular',        10),
(2,            19,     'Bueno',          15),
(2,            19,     'Excelente',      20),
(2,            24,     'Reprobado',       0),
(2,            24,     'Aprobado',      100);

INSERT INTO `group`
(`subject`, `author`, `teacher`, `evaluation`, `label`,    `url`,    `tsregister`,     `status`,   `description`)
VALUES
( 1,        2,        4,         1,            '1',        '1',      UNIX_TIMESTAMP(), 'active',   ''),
( 1,        2,        4,         1,            '2',        '2',      UNIX_TIMESTAMP(), 'active',   ''),
( 2,        2,        4,         1,            '1',        '1',      UNIX_TIMESTAMP(), 'active',   ''),
( 3,        2,        5,         1,            '1',        '1',      UNIX_TIMESTAMP(), 'active',   ''),
( 3,        2,        5,         1,            '2',        '2',      UNIX_TIMESTAMP(), 'active',   ''),
( 4,        2,        9,         1,            '1',        '1',      UNIX_TIMESTAMP(), 'active',   ''),
( 5,        2,        8,         1,            '1',        '1',      UNIX_TIMESTAMP(), 'active',   ''),
( 6,        2,        8,         1,            '1',        '1',      UNIX_TIMESTAMP(), 'active',   ''),
( 7,        2,        4,         1,            '1',        '1',      UNIX_TIMESTAMP(), 'active',   ''),
( 7,        2,        4,         1,            '2',        '2',      UNIX_TIMESTAMP(), 'active',   ''),
( 7,        2,        4,         1,            '3',        '3',      UNIX_TIMESTAMP(), 'active',   ''),
( 8,        2,        4,         1,            '1',        '1',      UNIX_TIMESTAMP(), 'inactive', ''),
( 8,        2,        4,         1,            '2',        '2',      UNIX_TIMESTAMP(), 'active',   ''),
( 9,        2,        8,         1,            '1',        '1',      UNIX_TIMESTAMP(), 'active',   ''),
(10,        2,        8,         1,            '1',        '1',      UNIX_TIMESTAMP(), 'active',   ''),
(10,        2,        8,         1,            '2',        '2',      UNIX_TIMESTAMP(), 'active',   ''),
(11,        3,        6,         1,            '1',        '1',      UNIX_TIMESTAMP(), 'active',   ''),
(11,        3,        6,         1,            '2',        '2',      UNIX_TIMESTAMP(), 'active',   ''),
(12,        3,        6,         1,            '1',        '1',      UNIX_TIMESTAMP(), 'active',   '');

INSERT INTO `group_user`
(`group`, `user`, `type`,     `status`,   `tsregister`)
VALUES
(12,      11,     'auxiliar', 'active',   UNIX_TIMESTAMP()),
(12,      18,     'student',  'active',   UNIX_TIMESTAMP()),
(12,      19,     'student',  'active',   UNIX_TIMESTAMP()),
(12,      20,     'student',  'active',   UNIX_TIMESTAMP()),
(15,      22,     'student',  'active',   UNIX_TIMESTAMP()),
(15,      23,     'student',  'active',   UNIX_TIMESTAMP()),
(15,      24,     'student',  'inactive', UNIX_TIMESTAMP()),
(15,      25,     'student',  'active',   UNIX_TIMESTAMP()),
(15,      27,     'guest',    'active',   UNIX_TIMESTAMP());

INSERT INTO `team`
(`group`, `author`, `label`,          `url`,            `status`,    `tsregister`,     `description`)
VALUES
(12,      4,        'Delta',          'delta',          'active',    UNIX_TIMESTAMP(), ''),
(12,      4,        'Canal cultural', 'canal-cultural', 'inactive',  UNIX_TIMESTAMP(), '');

INSERT INTO `team_user`
(`team`, `user`, `tsregister`)
VALUES
(1,      18,     UNIX_TIMESTAMP()),
(2,      19,     UNIX_TIMESTAMP());

INSERT INTO `resource`
(`author`, `recipient`,    `comments`, `ratings`, `raters`, `tsregister`)
VALUES
( 1,       'global',       0,          0,         0,        1249111111),     /* NOTE   1 AVISE */
( 2,       'area-1',       0,          0,         0,        1249211112),	 /* NOTE   2 */
( 2,       'subject-8',    0,          0,         0,        1249311123),	 /* EVENT  3 */
( 3,       'subject-11',   0,          0,         0,        1249411124),	 /* FILE   4 */
( 4,       'group-12',     0,          0,         0,        1249511235),	 /* NOTE   5 AVISE */
( 4,       'group-12',     0,          0,         0,        1249611236),	 /* NOTE   6 */
( 8,       'group-16',     0,          0,         0,        1249711247),	 /* FILE   7 */
(10,       'subject-7',    0,          0,         0,        1249811248),	 /* NOTE   8 */
(11,       'global',       0,          0,         0,        1249912359),	 /* NOTE   9 AVISE */
(11,       'global',       0,          0,         0,        1249012350),	 /* FILE  10 */
(11,       'global',       0,          0,         0,        1249112361),	 /* EVENT 11 */
(14,       'subject-12',   0,          0,         0,        1249212362),	 /* NOTE  12 */
(15,       'global',       0,          0,         0,        1249312473),	 /* NOTE  13 */
(16,       'subject-7',    0,          0,         0,        1249412474),	 /* NOTE  14 AVISE */
(16,       'subject-11',   0,          0,         0,        1249512485),	 /* EVENT 15 */
(17,       'global',       0,          0,         0,        1249612486),	 /* FILE  16 */
(18,       'team-1',       0,          0,         0,        1249723597),	 /* EVENT 17 */
(19,       'team-2',       0,          0,         0,        1249823598),	 /* NOTE  18 */
(20,       'global',       0,          0,         0,        1249923509),	 /* EVENT 19 */
(21,       'user-22',      0,          0,         0,        1249023500),	 /* NOTE  20 */
(21,       'user-23',      0,          0,         0,        1249123611),	 /* NOTE  21 */
(22,       'user-21',      0,          0,         0,        1249223612),	 /* NOTE  22 */
(23,       'user-24',      0,          0,         0,        1249323623),	 /* NOTE  23 */
(24,       'user-22',      0,          0,         0,        1249423624),	 /* NOTE  24 */
(24,       'global',       1,          2,         2,        1249524735),     /* EVENT 25 */
(25,       'global',       1,          0,         0,        1249624736),     /* FILE  26 */
(26,       'area-1',       0,          0,         0,        1249724747),	 /* NOTE  27 */
(15,       'community-1',  0,          0,         0,        1249824748),	 /* NOTE  28 */
(23,       'community-1',  0,          0,         0,        1249924859);	 /* EVENT 29 */

INSERT INTO `note`
(`resource`, `priority`, `note`)
VALUES
( 1,  true, 'El día 4 de julio de 1997 el Mars Pathfinder aterriza en Marte y a las pocas horas empieza a enviar las fotos de Marte en alta calidad que todos conocemos. La misión hasta ese momento de calificó de éxito. Se despliega la nave que sirvió para el viaje y para el aterrizaje –el SpaceCraft/Lander – para dejar salir al Sojounder Rover'),
( 2, false, 'La última avanzadilla del futuro está asomando la nariz en la factoría japonesa de la compañía Nissan. El gran mérito de su nuevo modelo Cero Emisiones: no necesitar cables para la recarga de electricidad. Mediante esta innovación el automóvil podrá repostar sin necesidad de cables en lugares adecuadamente equipados, tales como aparcamientos o estaciones de servicio: le bastará colocarse cerca de un punto de recarga.'),
( 5,  true, 'El experimentado astronauta David Wolf tiene un consejo para aquellos que se preguntan cómo estornudar en un traje espacial.'),
( 6, false, 'El avance de la tecnología es algo maravilloso, aunque los que crecimos con ciertos elementos de los cuales nos fuimos despidiendo, conocemos la nostalgia de los tiempos pasados, aunque no hayan sido mejores. ¿Se imaginan todas las cosas que, por estos avances, nuestros hijos seguramente no van a conocer? Pues Wired ha hecho una lista con las cien cosas que nuestors hijos nunca llegarán a conocer; además hay 27 traducidas en el primer comentario (¿algún voluntario para el resto?).'),
( 8, false, 'He visto que en hay un grupo de iPhone, me parece genial que esten queriendo hacer software para el iPhone. Quisiera darles una mano (si es que la aceptan), poco a poco se daran cuenta que les tomara un poquito de tiempo en su entrenamiento antes de ser capaces de hacer un juego "decente" que llegue a ser comercial.'),
( 9,  true, 'Un trabajador de Opera ha explicado una anécdota sobre lo que podría ser una línea de JavaScript que salió muy cara. Cuando la empresa Opera estaba pensando en desembolsar una gran suma de dinero en servidores, diferentes compañías les enviaron máquinas de prueba. Al probar la interfaz de administración vía web de un servidor que provenía de un importante distribuidor de hardware, encontraron que había cierto código JavaScript que detectaba si el navegador es Opera para redirigirlo directamente a una página de error. Obviamente perdieron la venta. '),
(12, false, 'Se ha lanzado un concurso llamado Digital Open organizado por Sun, Boing-Boing y la Fundación para el Futuro, dirigido a jóvenes de 17 años o menos que presenten proyectos que usen tecnologías libres y abiertas en diversos ámbitos (juegos, código, medio ambiente, innovación, medios de comunicación, artes...). Los premios de cada categoría son un paquete de productos tecnológicos y la difusión de los proyectos a través de Boing Boing. Me parece una idea interesante para difundir el software y la cultura libre entre los jóvenes, animando a pensar en nuevas formas de hacer que el SL pueda contribuir a mejorar el mundo. Para más información se puede dirigir a info@digitalopen.org, o para información en español: marialeg@gmail.com'),
(13, false, 'Cumpliendo con la promesa que hizo hace tiempo, Canonical acaba de anunciar la liberación del código completo de Launchpad, bajo la licencia GNU Affero General Public License, en su versión 3 (AGPL v3). Canonical continuará manteniendo los servidores Lauchpad, a la vez que se ocupará del desarrollo y mejora del software, permitiendo a la comunidad colaborar en su desarrollo.'),
(14, false, 'Tras varios años de retrasos e incertidumbre, parece que por fin tenemos fecha para la aprobación del estándar 802.11n . Esta mejora de los anteriores estándares -como los famosos 802.11b/g- ha pasado por numerosos obstáculos, y de hecho hasta la fecha los dispositivos "certificados" sólo garantizaban compatibilidad con el borrador del estándar. El próximo mes de septiembre podría aprobarse, al fin, el estándar definitivo, que resolverá los posibles conflictos en la adopción del estándar por parte de los fabricantes.'),
(18, false, 'Me entero gracias a Hacker News de que han publicado en el dominio público el código del módulo de mando y del módulo lunar de la misión Apollo 11 como conmemoración de los cuarenta años del primer alunizaje. Estos programas se podrán ejecutar gracias al emulador del AGC (Apollo Guidance Computer) del proyecto Virtual AGC and AGS, que también tiene su código disponible en Google Code.'),
(20, false, 'Rojadirecta.com, uno de los sitios más populares para ver fútbol y otros eventos deportivos gratis y en directo por la Red, seguirá abierto como hasta ahora. Una juez de Madrid ha sobreseído y archivado la denuncia de Audiovisual Sport por violación de la propiedad intelectual contra el sitio, que no incurre en delito alguno. La denuncia de Audiovisual Sport, sociedad controlada por la filial de Prisa Sogecable, data de 2007, cuando denunció a Rojadirecta.com por un supuesto delito contra la propiedad intelectual. Desde el portal se facilitan enlaces a restransmisiones en directo por la Red de eventos deportivos, entre ellos la Liga española de fútbol y Copa del Rey.'),
(21, false, 'Microsoft nos ha sorprendido hoy con la liberación de 20,000 líneas de código del kernel Linux bajo licencia GPL, correspondientes a 3 drivers de dispositivo que permitirán mejorar el funcionamiento del sistema operativo Linux al ser virtualizado sobre Windows Server 2008 Hyper-V o Windows Server 2008 R2 Hyper-V. Sam Ramji, Senior Director of Platform Strategy, y Tom Hanrahan, Director of the Open Source Technology Center comentan la liberación en este vídeo. '),
(22, false, 'La Fundación Symbian ha reconocido que su proceso de detección de aplicaciones malintencionadas dirigido a teléfonos basados en el sistema operativo Symbian necesita un revisión, después de que un programa troyano haya pasado un test de seguridad. Este botnet, que se llama a sí mismo "Sexy Space", consiguió pasar el proceso de firma digital, según informó este jueves el jefe de seguridad de Symbian Craig Heath. Heath dijo que el grupo está trabajando en la mejora de su seguridad, realizado un procedimiento de auditoría que le ayude a sentar una bases sólidas para garantizar la seguridad dentro de Symbian, ya que es uno de los sistemas operativos de mayor auge dentro del mundo de los terminales móviles.'),
(23, false, 'Hace algún tiempo compartí con vosotros el análisis de la migración a GNU/Linux de Rentalia.com. Basándome en esta experiencia, he creado una guía para migrar a Linux. En esta guía se explica, en términos generales, cómo migrar a GNU/Linux intentando solucionar los problemas más comunes. '),
(24, false, 'El juzgado de primera instancia e instrucción número 2 de Moguer acuerda el sobreseimiento provisional y el archivo de la causa contra los titulares del sitio web www.etmusica.com (también administradores de los portales www.elitetorrent.net, www.elitemula.com y www.sextaestacion.com), por entender que no ha quedado acreditado que el hecho denunciado sea constitutivo de infracción penal. La noticia se puede consultar en el blog del grupo ET. Su abogado, David Bravo, analiza el caso en su blog. '),
(27, false, 'El primer fabricante mundial de microprocesadores ha triplicado su contribución al núcleo Linux desde 2007 para alcanzar el segundo puesto sólo por detrás de Red Hat, superando a IBM, Novell u Oracle según los datos presentados esta semana en el simposium Linux de Otawa. CNET apunta a una cobertura a su larga asociación con Microsoft, para responder a los motivos que llevan al gigante del chip a tomarse tan en serio su contribución al software de código abierto.'),
(28, false, 'Se ha publicado un exploit para una nueva vulnerabilidad descubierta en el kernel Linux, que afecta a las versiones 2.6.30 y 2.6.30.1. Dicha vulnerabilidad es particularmente importante porque a través de ella es posible evitar las protecciones de seguridad de módulos como SELinux y AppArmor. Una posible solución es ejecutar el compilador con la orden CFLAGS+= -fno-delete-null-pointer-checks, que evita que la optimización se lleve a cabo. El error está solucionado en la rama 2.6.31-rc3. Visto en Slashdot');

INSERT INTO `file`
(`resource`, `filename`, `size`, `mime`, `description`)
VALUES
( 4, '01 Track 01.mp3', 5158175, 'audio/mpeg', 'A ver como les suena esto :-)'),
( 7, 'foneticaIngles.pdf', 101492, 'application/pdf', 'Para que repasen la fonetica de habla inglesa.'),
(10, 'ingles.zip', 111910, 'application/zip', 'Descompriman el .zip y repasen los documentos que de ahi es el examen.'),
(26, 'logo_bidabu.png', 41783, 'image/png', 'Imagen'),
(16, 'zooey_deschanel_1.jpg', 408499, 'image/jpeg', 'Un wallpaper');

INSERT INTO `event`
(`resource`, `event`, `duration`, `label`)
VALUES
( 3, 1248332167, 86400, 'Dia de la amistad'),
(11, 1248332167, 86400, 'Navidad'),
(15, 1248332167, 86400, 'El dia del mp3'),
(17, 1248332167, 86400, 'Reunion social'),
(19, 1248332167, 21600, 'Parrillada'),
(25, 1248332167,     0, 'Entrega de notas'),
(29, 1248332167,     0, 'Publicacion de notas');

INSERT INTO `resource_global`
(`resource`)
VALUES
( 1),
( 9),
(10),
(11),
(13),
(16),
(19),
(25),
(26);

INSERT INTO `area_resource`
(`resource`, `area`)
VALUES
( 2, 1),
(27, 1);

INSERT INTO `subject_resource`
(`resource`, `subject`)
VALUES
( 3, 8),
( 4,11),
( 8, 7),
(12,12),
(14, 7),
(15,11);

INSERT INTO `group_resource`
(`resource`, `group`)
VALUES
( 5,12),
( 6,12),
( 7,16);

INSERT INTO `team_resource`
(`resource`, `team`)
VALUES
(17, 1),
(18, 2);

INSERT INTO `community_resource`
(`resource`, `community`)
VALUES
(28, 1),
(29, 1);

INSERT INTO `user_resource`
(`resource`, `user`)
VALUES
(20, 22),
(21, 23),
(22, 21),
(23, 24),
(24, 22);

INSERT INTO `comment`
(`resource`, `author`, `tsregister`, `comment`)
VALUES
(25, 3, 1249975183, 'Eh!!! ojala y haya aprobao.'),
(26, 4, 1249974584, 'Y eso que tiene que ver, con el aspecto academico, dime!!');

INSERT INTO `rating`
(`resource`, `author`, `rating`)
VALUES
(25, 3, true),
(25, 4, true);

UPDATE `user` SET `password` = md5(CONCAT('KQ01805XG4GLTZHIFX19K0GR3G0K537F','asdf'));
