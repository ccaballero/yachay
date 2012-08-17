
/*============================================================================*/
/* Instalador de los paquetes originales de la distribucion                   */
/*============================================================================*/

SELECT 'base';
\. apps/base.sql

SELECT 'packages';
\. apps/packages.sql

SELECT 'routes';
\. apps/routes.sql

SELECT 'widgets';
\. apps/widgets.sql

SELECT 'privileges';
\. apps/privileges.sql

/*============================================================================*/

SELECT 'roles';
\. apps/roles.sql

SELECT 'spaces';
\. apps/spaces.sql

/*============================================================================*/

SELECT 'login';
\. apps/login.sql

SELECT 'users';
\. apps/users.sql

SELECT 'profile';
\. apps/profile.sql

SELECT 'settings';
\. apps/settings.sql

/*============================================================================*/

SELECT 'friends';
\. apps/friends.sql

SELECT 'invitations';
\. apps/invitations.sql

/*============================================================================*/

SELECT 'gestions';
\. apps/gestions.sql

SELECT 'subjects';
\. apps/subjects.sql

SELECT 'areas';
\. apps/areas.sql

SELECT 'careers';
\. apps/careers.sql

SELECT 'groups';
\. apps/groups.sql

SELECT 'teams';
\. apps/teams.sql

SELECT 'communities';
\. apps/communities.sql

/*============================================================================*/

SELECT 'groupsets';
\. apps/groupsets.sql

SELECT 'resources';
\. apps/resources.sql

SELECT 'notes';
\. apps/notes.sql

SELECT 'links';
\. apps/links.sql

SELECT 'files';
\. apps/files.sql

SELECT 'events';
\. apps/events.sql

SELECT 'photos';
\. apps/photos.sql

SELECT 'videos';
\. apps/videos.sql

/*============================================================================*/

SELECT 'evaluations';
\. apps/evaluations.sql

SELECT 'califications';
\. apps/califications.sql

/*============================================================================*/

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

/*============================================================================*/

SELECT 'analytics';
\. apps/analytics.sql

/*============================================================================*/

SELECT 'extra';
\. _extra.sql
