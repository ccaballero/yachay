
/*============================================================================*/
/* Instalador de los paquetes originales de la distribucion                   */
/*============================================================================*/

SELECT '_system';
\. _system.sql

SELECT 'packages';
\. packages.sql

SELECT 'frontpage';
\. frontpage.sql

SELECT 'pages';
\. pages.sql

SELECT 'regions';
\. regions.sql

SELECT 'widgets';
\. widgets.sql

SELECT 'privileges';
\. privileges.sql

/*============================================================================*/

SELECT 'menus';
\. menus.sql

SELECT 'toolbar';
\. toolbar.sql

/*============================================================================*/

SELECT 'roles';
\. roles.sql

SELECT 'spaces';
\. spaces.sql

/*============================================================================*/

SELECT 'login';
\. login.sql

SELECT 'users';
\. users.sql

SELECT 'profile';
\. profile.sql

SELECT 'settings';
\. settings.sql

/*============================================================================*/

SELECT 'friends';
\. friends.sql

SELECT 'invitations';
\. invitations.sql

/*============================================================================*/

SELECT 'gestions';
\. gestions.sql

SELECT 'subjects';
\. subjects.sql

SELECT 'areas';
\. areas.sql

SELECT 'careers';
\. careers.sql

SELECT 'groups';
\. groups.sql

SELECT 'teams';
\. teams.sql

SELECT 'communities';
\. communities.sql

/*============================================================================*/

SELECT 'groupsets';
\. groupsets.sql

SELECT 'resources';
\. resources.sql

SELECT 'notes';
\. notes.sql

SELECT 'links';
\. links.sql

SELECT 'files';
\. files.sql

SELECT 'events';
\. events.sql

SELECT 'photos';
\. photos.sql

SELECT 'videos';
\. videos.sql

/*============================================================================*/

SELECT 'evaluations';
\. evaluations.sql

SELECT 'califications';
\. califications.sql

/*============================================================================*/

SELECT 'comments';
\. comments.sql

SELECT 'ratings';
\. ratings.sql

SELECT 'valorations';
\. valorations.sql

SELECT 'tags';
\. tags.sql

SELECT 'feedback';
\. feedback.sql

SELECT 'templates';
\. templates.sql

/*============================================================================*/

SELECT 'analytics';
\. analytics.sql

/*============================================================================*/

SELECT 'extra';
\. _extra.sql