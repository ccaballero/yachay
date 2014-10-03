
/*============================================================================*/
/* Instalador de los paquetes originales de la distribucion                   */
/*============================================================================*/

SELECT 'base' AS '';
\. apps/base.sql

SELECT 'packages' AS '';
\. apps/packages.sql

SELECT 'routes' AS '';
\. apps/routes.sql

SELECT 'widgets' AS '';
\. apps/widgets.sql

SELECT 'privileges' AS '';
\. apps/privileges.sql

/*============================================================================*/

SELECT 'roles' AS '';
\. apps/roles.sql

SELECT 'spaces' AS '';
\. apps/spaces.sql

/*============================================================================*/

SELECT 'users' AS '';
\. apps/users.sql

SELECT 'login' AS '';
\. apps/login.sql

SELECT 'profile' AS '';
\. apps/profile.sql

SELECT 'settings' AS '';
\. apps/settings.sql

/*============================================================================*/

SELECT 'friends' AS '';
\. apps/friends.sql

SELECT 'invitations' AS '';
\. apps/invitations.sql

/*============================================================================*/

SELECT 'gestions' AS '';
\. apps/gestions.sql

SELECT 'subjects' AS '';
\. apps/subjects.sql

SELECT 'areas' AS '';
\. apps/areas.sql

SELECT 'careers' AS '';
\. apps/careers.sql

SELECT 'groups' AS '';
\. apps/groups.sql

SELECT 'teams' AS '';
\. apps/teams.sql

SELECT 'communities' AS '';
\. apps/communities.sql

/*============================================================================*/

SELECT 'groupsets' AS '';
\. apps/groupsets.sql

SELECT 'resources' AS '';
\. apps/resources.sql

SELECT 'notes' AS '';
\. apps/notes.sql

SELECT 'links' AS '';
\. apps/links.sql

SELECT 'files' AS '';
\. apps/files.sql

SELECT 'events' AS '';
\. apps/events.sql

SELECT 'photos' AS '';
\. apps/photos.sql

SELECT 'videos' AS '';
\. apps/videos.sql

/*============================================================================*/

SELECT 'evaluations' AS '';
\. apps/evaluations.sql

SELECT 'califications' AS '';
\. apps/califications.sql

/*============================================================================*

SELECT 'comments';
\. apps/comments.sql

SELECT 'ratings';
\. apps/ratings.sql

SELECT 'valorations';
\. apps/valorations.sql

SELECT 'tags';
\. apps/tags.sql

SELECT 'feedback';
\. apps/feedback.sql

SELECT 'templates';
\. apps/templates.sql

/*============================================================================*

SELECT 'analytics';
\. apps/analytics.sql

SELECT 'register';
\. apps/register.sql

/*============================================================================*

SELECT 'extra';
\. _extra.sql
