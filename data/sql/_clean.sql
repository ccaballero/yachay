
/*============================================================================*/
/* Script para eliminar las tablas de la base de datos                        */
/*============================================================================*/

DROP TABLE IF EXISTS `template_user`;
DROP TABLE IF EXISTS `template`;
DROP TABLE IF EXISTS `feedback`;
DROP TABLE IF EXISTS `tag_user`;
DROP TABLE IF EXISTS `tag_community`;
DROP TABLE IF EXISTS `tag_resource`;
DROP TABLE IF EXISTS `tag`;
DROP TABLE IF EXISTS `rating`;
DROP TABLE IF EXISTS `comment`;
DROP TABLE IF EXISTS `calification`;
DROP TABLE IF EXISTS `evaluation_test_value`;
DROP TABLE IF EXISTS `evaluation_test`;
ALTER TABLE `group` DROP FOREIGN KEY `fk_eva`;
ALTER TABLE `group` DROP INDEX `index_eva`;
ALTER TABLE `group` DROP COLUMN `evaluation`;
DROP TABLE IF EXISTS `evaluation`;
DROP TABLE IF EXISTS `video`;
DROP TABLE IF EXISTS `photo`;
DROP TABLE IF EXISTS `event`;
DROP TABLE IF EXISTS `file`;
DROP TABLE IF EXISTS `link`;
DROP TABLE IF EXISTS `note`;
DROP TABLE IF EXISTS `community_resource`;
DROP TABLE IF EXISTS `team_resource`;
DROP TABLE IF EXISTS `group_resource`;
DROP TABLE IF EXISTS `career_resource`;
DROP TABLE IF EXISTS `area_resource`;
DROP TABLE IF EXISTS `subject_resource`;
DROP TABLE IF EXISTS `user_resource`;
DROP TABLE IF EXISTS `resource_global`;
DROP TABLE IF EXISTS `resource`;
DROP TABLE IF EXISTS `groupset_group`;
DROP TABLE IF EXISTS `groupset`;
DROP TABLE IF EXISTS `community_petition`;
DROP TABLE IF EXISTS `community_user`;
DROP TABLE IF EXISTS `community`;
DROP TABLE IF EXISTS `team_user`;
DROP TABLE IF EXISTS `team`;
DROP TABLE IF EXISTS `group_user`;
DROP TABLE IF EXISTS `group`;
DROP TABLE IF EXISTS `career_subject`;
DROP TABLE IF EXISTS `career`;
DROP TABLE IF EXISTS `area_subject`;
DROP TABLE IF EXISTS `area`;
DROP TABLE IF EXISTS `subject_user`;
DROP TABLE IF EXISTS `subject`;
DROP TABLE IF EXISTS `gestion`;
DROP TABLE IF EXISTS `invitation`;
DROP TABLE IF EXISTS `friend`;
DROP TABLE IF EXISTS `login_forgot`;
DROP TABLE IF EXISTS `user`;
DROP TABLE IF EXISTS `role_privilege`;
DROP TABLE IF EXISTS `role`;
DROP TABLE IF EXISTS `widget_route`;
DROP TABLE IF EXISTS `widget`;
DROP TABLE IF EXISTS `route_menu`;
DROP TABLE IF EXISTS `route_privilege`;
DROP TABLE IF EXISTS `route`;
DROP TABLE IF EXISTS `privilege`;
DROP TABLE IF EXISTS `package`;

