<?php

class Analytics_IndexController extends Yachay_Controller_Action
{
    private $sql1 = "
         SELECT role.label as role, a.count as total, b.count as logged, c.count as email, d.count as username FROM role 
         LEFT JOIN (SELECT user.role, count(*) as count FROM user                               GROUP BY user.role) as a ON role.ident = a.role
         LEFT JOIN (SELECT user.role, count(*) as count FROM user WHERE user.tslastlogin <> 0   GROUP BY user.role) as b ON role.ident = b.role
         LEFT JOIN (SELECT user.role, count(*) as count FROM user WHERE user.email <> 0         GROUP BY user.role) as c ON role.ident = c.role
         LEFT JOIN (SELECT user.role, count(*) as count FROM user WHERE user.label <> user.code GROUP BY user.role) as d ON role.ident = d.role
         ORDER BY role.ident ASC";
    
    private $sql2 = "
        SELECT role.label as role, a.activity, a.participation, a.sociability, a.popularity FROM role
        LEFT JOIN (SELECT user.role, sum(user.activity) as activity, sum(user.participation) as participation, sum(user.sociability) as sociability, sum(user.popularity) as popularity FROM user GROUP BY user.role) as a
        ON role.ident = a.role
        ORDER BY role.ident ASC";

    private $sql3 = "
        SELECT u1.ident as `_from`,
                u1.label as `from`,
                u1.username as `fusername`,
                u1.email as `femail`,
                u1.role as `frole`,
                u1.activity as `fac`,
                u1.participation as `fpa`,
                u1.sociability as `fso`,
                u1.popularity as `fpo`,
                u2.ident as `_to`,
                u2.label as `to`,
                u2.username `tusername`,
                u2.email as `temail`,
                u2.role as `trole`,
                u2.activity as `tac`,
                u2.participation as `tpa`,
                u2.sociability as `tso`,
                u2.popularity as `tpo`,
                friend.mutual
        FROM friend
        LEFT JOIN (
            SELECT user.ident,
                    user.label,
                    (user.code <> user.label) as username,
                    (user.email <> '') as email,
                    user.activity,
                    user.participation,
                    user.sociability,
                    user.popularity,
                    role.label as role
            FROM user
            JOIN role
            ON role.ident = user.role
        ) as u1
        ON friend.user = u1.ident
        LEFT JOIN (
            SELECT user.ident,
                    user.label,
                    (user.code <> user.label) as username,
                    (user.email <> '') as email,
                    user.activity,
                    user.participation,
                    user.sociability,
                    user.popularity,
                    role.label as role
            FROM user
            JOIN role
            ON role.ident = user.role
        ) as u2
        ON friend.friend = u2.ident";

    private $sql4 = "
        SELECT a.type as space, a.count as total, b.resources as resources, IFNULL(c.viewers, 0) as viewers
        FROM (
            SELECT 'Portada' as type, 1 as count) as a
            CROSS JOIN (SELECT 'Portada' as type, count(resource) as resources FROM resource_global) as b ON a.type = b.type
            CROSS JOIN (SELECT 'Portada' as type, sum(viewers) as viewers FROM resource WHERE ident IN (SELECT resource FROM resource_global)) as c ON a.type = c.type
        UNION ALL
        SELECT a.type as space, a.count as total, b.resources as resources, c.viewers as viewers
        FROM (
            SELECT 'Carreras' as type, count(*) as count FROM `career`) as a
            CROSS JOIN (SELECT 'Carreras' as type, count(resource) as resources FROM career_resource) as b ON a.type = b.type
            CROSS JOIN (SELECT 'Carreras' as type, sum(viewers) as viewers FROM resource WHERE ident IN (SELECT resource FROM career_resource)) as c ON a.type = c.type
        UNION ALL
        SELECT a.type as space, a.count as total, b.resources as resources, c.viewers as viewers
        FROM (
            SELECT 'Areas' as type, count(*) as count FROM `area`) as a
            CROSS JOIN (SELECT 'Areas' as type, count(resource) as resources FROM area_resource) as b ON a.type = b.type
            CROSS JOIN (SELECT 'Areas' as type, sum(viewers) as viewers FROM resource WHERE ident IN (SELECT resource FROM area_resource)) as c ON a.type = c.type
        UNION ALL
        SELECT a.type as space, a.count as total, b.resources as resources, c.viewers as viewers
        FROM (
            SELECT 'Materias' as type, count(*) as count FROM `subject`) as a
            CROSS JOIN (SELECT 'Materias' as type, count(resource) as resources FROM subject_resource) as b ON a.type = b.type
            CROSS JOIN (SELECT 'Materias' as type, sum(viewers) as viewers FROM resource WHERE ident IN (SELECT resource FROM subject_resource)) as c ON a.type = c.type
        UNION ALL
        SELECT a.type as space, a.count as total, b.resources as resources, c.viewers as viewers
        FROM (
            SELECT 'Grupos' as type, count(*) as count FROM `group`) as a
            CROSS JOIN (SELECT 'Grupos' as type, count(resource) as resources FROM group_resource) as b ON a.type = b.type
            CROSS JOIN (SELECT 'Grupos' as type, sum(viewers) as viewers FROM resource WHERE ident IN (SELECT resource FROM group_resource)) as c ON a.type = c.type
        UNION ALL
        SELECT a.type as space, a.count as total, b.resources as resources, IFNULL(c.viewers, 0) as viewers
        FROM (
            SELECT 'Equipos' as type, count(*) as count FROM `team`) as a
            CROSS JOIN (SELECT 'Equipos' as type, count(resource) as resources FROM team_resource) as b ON a.type = b.type
            CROSS JOIN (SELECT 'Equipos' as type, sum(viewers) as viewers FROM resource WHERE ident IN (SELECT resource FROM team_resource)) as c ON a.type = c.type
        UNION ALL
        SELECT a.type as space, a.count as total, b.resources as resources, c.viewers as viewers
        FROM (
            SELECT 'Comunidades' as type, count(*) as count FROM `community`) as a
            CROSS JOIN (SELECT 'Comunidades' as type, count(resource) as resources FROM community_resource) as b ON a.type = b.type
            CROSS JOIN (SELECT 'Comunidades' as type, sum(viewers) as viewers FROM resource WHERE ident IN (SELECT resource FROM community_resource)) as c ON a.type = c.type";
    
    private $sql5 = "
        SELECT a.type, a.count, a.viewers, a.comments, a.raters, b.tags
        FROM (
            SELECT 'Notas' as type, count(*) as count, sum(viewers) as viewers, sum(comments) as comments, sum(raters) as raters FROM note LEFT JOIN resource ON note.resource = resource.ident) as a
            LEFT JOIN (SELECT 'Notas' as type, count(*) as tags FROM tag_resource WHERE resource IN (SELECT resource FROM note)) as b ON a.type = b.type
        UNION ALL
        SELECT a.type, a.count, a.viewers, a.comments, a.raters, b.tags
        FROM (
            SELECT 'Archivos' as type, count(*) as count, sum(viewers) as viewers, sum(comments) as comments, sum(raters) as raters FROM file LEFT JOIN resource ON file.resource = resource.ident) as a
            LEFT JOIN (SELECT 'Archivos' as type, count(*) as tags FROM tag_resource WHERE resource IN (SELECT resource FROM file)) as b ON a.type = b.type
        UNION ALL
        SELECT a.type, a.count, a.viewers, a.comments, a.raters, b.tags
        FROM (
            SELECT 'Eventos' as type, count(*) as count, sum(viewers) as viewers, sum(comments) as comments, sum(raters) as raters FROM event LEFT JOIN resource ON event.resource = resource.ident) as a
            LEFT JOIN (SELECT 'Eventos' as type, count(*) as tags FROM tag_resource WHERE resource IN (SELECT resource FROM event)) as b ON a.type = b.type
        UNION ALL
        SELECT a.type, a.count, a.viewers, a.comments, a.raters, b.tags
        FROM (
            SELECT 'Enlaces' as type, count(*) as count, sum(viewers) as viewers, sum(comments) as comments, sum(raters) as raters FROM link LEFT JOIN resource ON link.resource = resource.ident) as a
            LEFT JOIN (SELECT 'Enlaces' as type, count(*) as tags FROM tag_resource WHERE resource IN (SELECT resource FROM link)) as b ON a.type = b.type
        UNION ALL
        SELECT a.type, a.count, a.viewers, a.comments, a.raters, b.tags
        FROM (
            SELECT 'Fotografias' as type, count(*) as count, sum(viewers) as viewers, sum(comments) as comments, sum(raters) as raters FROM photo LEFT JOIN resource ON photo.resource = resource.ident) as a
            LEFT JOIN (SELECT 'Fotografias' as type, count(*) as tags FROM tag_resource WHERE resource IN (SELECT resource FROM photo)) as b ON a.type = b.type
        UNION ALL
        SELECT a.type, a.count, a.viewers, a.comments, a.raters, b.tags
        FROM (
            SELECT 'Videos' as type, count(*) as count, sum(viewers) as viewers, sum(comments) as comments, sum(raters) as raters FROM video LEFT JOIN resource ON video.resource = resource.ident) as a
            LEFT JOIN (SELECT 'Videos' as type, count(*) as tags FROM tag_resource WHERE resource IN (SELECT resource FROM video)) as b ON a.type = b.type";

    public $availables = array('users', 'valorations', 'contacts', 'spaces', 'resources', 'timeline');
    protected $db;

    public function init() {
        $this->db = Zend_Db_Table::getDefaultAdapter();
        parent::init();
    }

    public function indexAction() {
        $this->requirePermission('analytics', 'view');

        $request = $this->getRequest();
        $page = $request->getParam('page');

        if (!in_array($page, $this->availables)) {
            $page = 'users';
        }

        $method = 'getStat' . ucfirst($page);
        $this->view->stat = $this->$method();

        $this->view->active = $page;
        $this->view->fg = '#000000';
        $this->view->bg = '#ffffff';
    }

    protected function getStatUsers() { return $this->db->fetchAll($this->sql1); }
    protected function getStatValorations() { return $this->db->fetchAll($this->sql2); }
    protected function getStatSpaces() { return $this->db->fetchAll($this->sql4); }
    protected function getStatResources() { return $this->db->fetchAll($this->sql5); }

    public function getStatContacts() {
        $stat1 = $this->db->fetchAll($this->sql3);

        $users = array();
        foreach ($stat1 as $stat) {
            if (!isset($users[$stat['_from']])) {
                $users[$stat['_from']] = array(
                    'ident' => $stat['_from'],
                    'label' => $stat['from'],
                    'username' => $stat['fusername'],
                    'email' => $stat['femail'],
                    'role' => $stat['frole'],
                    'ac' => $stat['fac'],
                    'pa' => $stat['fpa'],
                    'so' => $stat['fso'],
                    'po' => $stat['fpo'],
                );
            }
            if (!isset($users[$stat['_to']])) {
                $users[$stat['_to']] = array(
                    'ident' => $stat['_to'],
                    'label' => $stat['to'],
                    'username' => $stat['tusername'],
                    'email' => $stat['temail'],
                    'role' => $stat['trole'],
                    'ac' => $stat['tac'],
                    'pa' => $stat['tpa'],
                    'so' => $stat['tso'],
                    'po' => $stat['tpo'],
                );
            }
        }

        $matrix = array();
        foreach ($users as $_from => $from) {
            $row = array();
            foreach ($users as $_to => $to) {
                $row[$_to] = null;
            }
            $matrix[$_from] = $row;
        }

        foreach ($stat1 as $stat) {
            $matrix[$stat['_from']][$stat['_to']] = array(
                'mutual' => $stat['mutual'],
            );
        }

        return array('users' => $users, 'matrix' => $matrix);
    }
    
        public function getStatTimeline() {
        $sql1 = 'SELECT FROM_UNIXTIME(tsregister, "%Y-%m-%d") as date, count(*) as users FROM user GROUP BY date';
        $sql2 = 'SELECT FROM_UNIXTIME(tsregister, "%Y-%m-%d") as date, count(*) as contacts FROM friend GROUP BY date';
        $sql3 = 'SELECT FROM_UNIXTIME(tsregister, "%Y-%m-%d") as date, count(*) as resources FROM resource GROUP BY date';
        $sql4 = 'SELECT a.date as date, sum(a.spaces) as spaces FROM (
            SELECT FROM_UNIXTIME(tsregister, "%Y-%m-%d") as date, count(*) as spaces FROM career GROUP BY date
            UNION ALL
            SELECT FROM_UNIXTIME(tsregister, "%Y-%m-%d") as date, count(*) as spaces FROM area GROUP BY date
            UNION ALL
            SELECT FROM_UNIXTIME(tsregister, "%Y-%m-%d") as date, count(*) as spaces FROM subject GROUP BY date) as a GROUP BY a.date';
        $sql5 = 'SELECT FROM_UNIXTIME(tsregister, "%Y-%m-%d") as min FROM user WHERE ident = 1';
        $sql6 = 'SELECT DATE_FORMAT(NOW(), "%Y-%m-%d")';

        $stat1 = $this->db->fetchAll($sql1);
        $stat2 = $this->db->fetchAll($sql2);
        $stat3 = $this->db->fetchAll($sql3);
        $stat4 = $this->db->fetchAll($sql4);
        $stat5 = $this->db->fetchOne($sql5);
        $stat6 = $this->db->fetchOne($sql6);

        $array = array();
        $date = $stat5;
        while ($date != $stat6) {
            $array[$date] = array('users' => 0, 'contacts' => 0, 'resources' => 0, 'spaces' => 0);

            list($y, $m, $d) = split('-', $date);
            $_date = mktime(0, 0, 0, intval($m), intval($d) + 1, intval($y));
            $date = date('Y-m-d', $_date);
        }

        foreach ($stat1 as $stat) {
            $array[$stat['date']]['users'] = intval($stat['users']);
        }
        foreach ($stat2 as $stat) {
            $array[$stat['date']]['contacts'] = intval($stat['contacts']);
        }
        foreach ($stat3 as $stat) {
            $array[$stat['date']]['resources'] = intval($stat['resources']);
        }
        foreach ($stat4 as $stat) {
            $array[$stat['date']]['spaces'] = intval($stat['spaces']);
        }

        return $array;
    }
}
