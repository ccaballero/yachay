
/*============================================================================*/
/* Instalador de los paquetes originales de la distribucion                   */
/*============================================================================*/

SELECT 'base';
\. packages/base.sql

SELECT 'packages';
\. packages/packages.sql

SELECT 'frontpage';
\. packages/frontpage.sql

SELECT 'pages';
\. packages/pages.sql

SELECT 'regions';
\. packages/regions.sql

SELECT 'widgets';
\. packages/widgets.sql

SELECT 'privileges';
\. packages/privileges.sql

/*============================================================================*/

SELECT 'menus';
\. packages/menus.sql

SELECT 'toolbar';
\. packages/toolbar.sql

/*============================================================================*/

SELECT 'roles';
\. packages/roles.sql

SELECT 'spaces';
\. packages/spaces.sql

/*============================================================================*/

SELECT 'login';
\. packages/login.sql

SELECT 'users';
\. packages/users.sql

SELECT 'profile';
\. packages/profile.sql

SELECT 'settings';
\. packages/settings.sql

/*============================================================================*/

SELECT 'friends';
\. packages/friends.sql

SELECT 'invitations';
\. packages/invitations.sql

/*============================================================================*/

SELECT 'gestions';
\. packages/gestions.sql

SELECT 'subjects';
\. packages/subjects.sql

SELECT 'areas';
\. packages/areas.sql

SELECT 'careers';
\. packages/careers.sql

SELECT 'groups';
\. packages/groups.sql

SELECT 'teams';
\. packages/teams.sql

SELECT 'communities';
\. packages/communities.sql

/*============================================================================*/

SELECT 'groupsets';
\. packages/groupsets.sql

SELECT 'resources';
\. packages/resources.sql

SELECT 'notes';
\. packages/notes.sql

SELECT 'links';
\. packages/links.sql

SELECT 'files';
\. packages/files.sql

SELECT 'events';
\. packages/events.sql

SELECT 'photos';
\. packages/photos.sql

SELECT 'videos';
\. packages/videos.sql

/*============================================================================*/

SELECT 'evaluations';
\. packages/evaluations.sql

SELECT 'califications';
\. packages/califications.sql

/*============================================================================*/

SELECT 'comments';
\. packages/comments.sql

SELECT 'ratings';
\. packages/ratings.sql

SELECT 'valorations';
\. packages/valorations.sql

SELECT 'tags';
\. packages/tags.sql

SELECT 'feedback';
\. packages/feedback.sql

SELECT 'templates';
\. packages/templates.sql

/*============================================================================*/

SELECT 'analytics';
\. packages/analytics.sql

/*============================================================================*/

SELECT 'extra';
\. _extra.sql
