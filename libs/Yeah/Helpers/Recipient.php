<?php

class Yeah_Helpers_Recipient
{
    public function recipient($recipient) {
        global $CONFIG;
        @list($element, $ident) = @split('-', $recipient);

        $url = new Zend_View_Helper_Url;

        switch ($element) {
            case 'global':
                return '<a href="' . $url->url(array(), 'frontpage_user') . '">Pagina principal</a>';
            case 'area':
                $areas_model = Yeah_Adapter::getModel('areas');
                $area = $areas_model->findByIdent($ident);
                return '<a href="' . $url->url(array('area' => $area->url), 'areas_area_view') . '">' . $area->label . '</a>';
            case 'subject':
                $subjects_model = Yeah_Adapter::getModel('subjects');
                $subject = $subjects_model->findByIdent($ident);
                return '<a href="' . $url->url(array('subject' => $subject->url), 'subjects_subject_view') . '">' . $subject->label . '</a>';
            case 'groupset':
                $groupsets_model = Yeah_Adapter::getModel('groupsets');
                $groupset = $groupsets_model->findByIdent($ident);
                $groupsets_groups_model = Yeah_Adapter::getModel('groupsets', 'Groupsets_Groups');
                $groups = $groupsets_groups_model->selectByGroupset($ident);
                $groups_model = Yeah_Adapter::getModel('groups');
                $return = array();
                foreach ($groups as $group)  {
                    $group = $groups_model->findByIdent($group['group']);
                    $subject = $group->getSubject();
                    $return[] = '<a href="' . $url->url(array('subject' => $subject->url, 'group' => $group->url), 'groups_group_view') . '">'. "Grupo: {$group->label}" . '</a>';
                }
                return implode(', ', $return);
            case 'group':
                $groups_model = Yeah_Adapter::getModel('groups');
                $group = $groups_model->findByIdent($ident);
                $subject = $group->getSubject();
                return '<a href="' . $url->url(array('subject' => $subject->url, 'group' => $group->url), 'groups_group_view') . '">' . "Grupo {$group->label} ({$subject->label})" . '</a>';
            case 'team':
                $teams_model = Yeah_Adapter::getModel('teams');
                $team = $teams_model->findByIdent($ident);
                $group = $team->getGroup();
                $subject = $group->getSubject();
                return '<a href="' . $url->url(array('subject' => $subject->url, 'group' => $group->url, 'team' => $team->url), 'teams_team_view') . '">' ."Equipo $team->label - Grupo {$group->label} ({$subject->label})" . '</a>';
            case 'community':
                $communities_model = Yeah_Adapter::getModel('communities');
                $community = $communities_model->findByIdent($ident);
                return '<a href="' . $url->url(array('community' => $community->url), 'communities_community_view') . '">' . $community->label . '</a>';
            case 'user':
                $users_model = Yeah_Adapter::getModel('users');
                $user = $users_model->findByIdent($ident);
                return '<a href="' . $url->url(array('user' => $user->url), 'users_user_view') .'">' . $user->label . '</a>';
        }
    }
}
