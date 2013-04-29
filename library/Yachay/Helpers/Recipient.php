<?php

class Yachay_Helpers_Recipient
{
    public function recipient($recipient) {
        @list($element, $ident) = @split('-', $recipient);

        $url = new Zend_View_Helper_Url();

        switch ($element) {
            case 'global':
                return '<a href="' . $url->url(array(), 'base_user') . '">Pagina principal</a>';
            case 'area':
                $model_areas = new Areas();
                $area = $model_areas->findByIdent($ident);
                return '<a href="' . $url->url(array('area' => $area->url), 'areas_area_view') . '">' . $area->label . '</a>';
            case 'career':
                $model_careers = new Careers();
                $career = $model_careers->findByIdent($ident);
                return '<a href="' . $url->url(array('career' => $career->url), 'careers_career_view') . '">' . $career->label . '</a>';
            case 'subject':
                $model_subjects = new Subjects();
                $subject = $model_subjects->findByIdent($ident);
                return '<a href="' . $url->url(array('subject' => $subject->url), 'subjects_subject_view') . '">' . $subject->label . '</a>';
            case 'groupset':
                $model_groups = new Groups();
                $model_groupsets = new Groupsets();
                $model_groupsets_groups = new Groupsets_Groups();
                $groupset = $model_groupsets->findByIdent($ident);
                $groups = $model_groupsets_groups->selectByGroupset($ident);
                $return = array();
                foreach ($groups as $group)  {
                    $group = $model_groups->findByIdent($group['group']);
                    $subject = $group->getSubject();
                    $return[] = '<a href="' . $url->url(array('subject' => $subject->url, 'group' => $group->url), 'groups_group_view') . '">'. "Grupo: {$group->label}" . '</a>';
                }
                return '(' . implode(', ', $return) . ')';
            case 'group':
                $model_groups = new Groups();
                $group = $model_groups->findByIdent($ident);
                $subject = $group->getSubject();
                return '<a href="' . $url->url(array('subject' => $subject->url, 'group' => $group->url), 'groups_group_view') . '">' . "Grupo {$group->label} ({$subject->label})" . '</a>';
            case 'team':
                $model_teams = new Teams();
                $team = $model_teams->findByIdent($ident);
                $group = $team->getGroup();
                $subject = $group->getSubject();
                return '<a href="' . $url->url(array('subject' => $subject->url, 'group' => $group->url, 'team' => $team->url), 'teams_team_view') . '">' ."Equipo $team->label ({$subject->label})" . '</a>';
            case 'community':
                $model_communities = new Communities();
                $community = $model_communities->findByIdent($ident);

                if (!empty($community)) {
                    return '<a href="' . $url->url(array('community' => $community->url), 'communities_community_view') . '">' . $community->label . '</a>';
                }
            case 'user':
                $model_users = new Users();
                $user = $model_users->findByIdent($ident);
                return '<a href="' . $url->url(array('user' => $user->url), 'users_user_view') .'">' . $user->label . '</a>';
        }
    }
}
