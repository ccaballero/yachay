<?php

class Yeah_Helpers_Context
{
    // Values for format: { html, plain, matrix}
    public function context($name, $format = 'html') {
        global $USER;

        // context
        $session = new Zend_Session_Namespace();
        $context = $session->context;
        $context_type = $context->getElement();

        $default = '';
        $select = 'selected="selected"';

        $options = array();

        $data = array(
            'global' => array(),
            'areas' => array(),
            'subjects' => array(),
            'groupsets' => array(),
            'groups' => array(),
            'teams' => array(),
            'communities' => array(),
            'users' => array(),
        );

        // set for global context
        if ($context_type == 'global') {
            $default = $select;
        }

        $options[] = '<option value="global" ' . $default . '>Pagina principal</option>';
        $data['global'][] = 'global';

        // set for area context
        $model_areas = new Areas();
        $areas = $model_areas->selectAll();
        if (count($areas) != 0) {
            if ($context_type == 'area') {
                $default = true;
            } else {
                $default = false;
            }
            $options[] = '<optgroup label="Areas">';
            foreach ($areas as $area) {
                $options[] = '<option value="area-' . $area->ident . '" ' . (($default && ($context->{$context_type}->ident == $area->ident)) ? $select : '') . '>' . $area->label . '</option>';
                $data['areas'][] = 'area-' . $area->ident;
            }
            $options[] = '</optiongroup>';
        }

        // gestion calculus
        $model_gestion = new Gestions();
        $gestion = $model_gestion->findByActive();

        if (!empty($gestion)) {
            // set for subject context
            $model_subjects = new Subjects();
            $assignement1 = new Subjects_Users();
            $subjects1 = $model_subjects->selectAll($gestion->ident);
            $subjects2 = array();
            foreach ($subjects1 as $subject) {
                if ($subject->status == 'active' || Yeah_Acl::hasPermission('subjects', 'lock') || Yeah_Acl::hasPermission('subjects', 'moderate')) {
                    switch ($subject->visibility) {
                        case 'public':
                            $subjects2[] = $subject;
                            break;
                        case 'register':
                            if ($USER->role != 1) {
                                $subjects2[] = $subject;
                            }
                            break;
                        case 'private':
                            if ($USER->role != 1) {
                                if (Yeah_Acl::hasPermission('subjects', 'edit')) {
                                    $subjects2[] = $subject;
                                } else if ($subject->moderator == $USER->ident) {
                                    $subjects2[] = $subject;
                                } else {
                                    $assign = $assignement1->findBySubjectAndUser($subject->ident, $USER->ident);
                                    if (!empty($assign) && $assign->status == 'active') {
                                        $subjects2[] = $subject;
                                    }
                                }
                            }
                            break;
                    }
                }
            }
            $options[] = '<optgroup label="Materias">';
            if (count($subjects2) != 0) {
                if ($context_type == 'subject') {
                    $default = true;
                } else {
                    $default = false;
                }
                foreach ($subjects2 as $subject) {
                    $options[] = '<option value="subject-' . $subject->ident . '" ' . (($default && ($context->{$context_type}->ident == $subject->ident)) ? $select : '') . '>' . $subject->label . '</option>';
                    $data['subjects'][] = 'subject-' . $subject->ident;
                }
                $options[] = '</optiongroup>';
            }

            // set for groupset context
            $model_groupsets = new Groupsets();
            $groupsets1 = $model_groupsets->selectByAuthor($USER->ident);
            $groupsets2 = array();
            foreach ($groupsets1 as $groupset) {
                if ($groupset->gestion == $gestion->ident) {
                    $groupsets2[] = $groupset;
                }
            }
            if (count($groupsets2) != 0) {
                $options[] = '<optgroup label="Conjuntos">';
                foreach ($groupsets2 as $groupset) {
                    $options[] = '<option value="groupset-' . $groupset->ident . '" ' . '>' . $groupset->label . '</option>';
                    $data['groupsets'][] = 'groupset-' . $groupset->ident;
                }
                $options[] = '</optiongroup>';
            }

            // set for group context
            $model_groups = new Groups();
            $assignement2 = new Groups_Users();
            $groups = array();
            foreach ($subjects2 as $subject) {
                $list_groups = $model_groups->selectAll($subject->ident);
                foreach ($list_groups as $group) {
                    if ($group->teacher == $USER->ident) {
                        $groups[] = $group;
                    }
                    $assign = $assignement2->findByGroupAndUser($group->ident, $USER->ident);
                    if (!empty($assign) && $assign->status == 'active') {
                        $groups[] = $group;
                    }
                }
            }
            if (count($groups) != 0) {
                if ($context_type == 'group') {
                    $default = true;
                } else {
                    $default = false;
                }
                $options[] = '<optgroup label="Grupos">';
                foreach ($groups as $group) {
                    $subject = $group->getSubject();
                    $options[] = '<option value="group-' . $group->ident . '" ' . (($default && ($context->{$context_type}->ident == $group->ident)) ? $select : '') . '>' . 'Grupo ' . $group->label . ' (' . $subject->label . ')</option>';
                    $data['groups'][] = 'group-' . $group->ident;
                }
                $options[] = '</optiongroup>';
            }

            // set for team context
            $model_teams = new Teams();
            $assignement3 = new Teams_Users();
            $teams = array();
            foreach ($groups as $group) {
                $list_teams = $model_teams->selectAll($group->ident);
                foreach ($list_teams as $team) {
                    if ($group->teacher == $USER->ident) {
                        $teams[] = $team;
                    }
                    $assign = $assignement3->findByTeamAndUser($team->ident, $USER->ident);
                    if (!empty($assign)) {
                        $teams[] = $team;
                    }
                }
            }
            if (count($teams) != 0) {
                if ($context_type == 'team') {
                    $default = true;
                } else {
                    $default = false;
                }
                $options[] = '<optgroup label="Equipos">';
                foreach ($teams as $team) {
                    $group = $team->getGroup();
                    $subject = $group->getSubject();
                    $options[] = '<option value="team-' . $team->ident . '" ' . (($default && ($context->{$context_type}->ident == $team->ident)) ? $select : '') . '>' . 'Equipo ' . $team->label . ' - Grupo ' . $group->label . ' (' . $subject->label . ')</option>';
                    $data['teams'][] = 'team-' . $team->ident;
                }
                $options[] = '</optiongroup>';
            }
        }
        // set for community context
        $model_commnities = new Communities();
        $assignement4 = new Communities_Users();
        $communities1 = $model_commnities->selectAll();
        $communities2 = array();
        foreach ($communities1 as $community) {
            $assign = $assignement4->findByCommunityAndUser($community->ident, $USER->ident);
            if (!empty($assign) && $assign->status <> 'inactive') {
                $communities2[] = $community;
            }
        }
        if (count($communities2) != 0) {
            if ($context_type == 'community') {
                $default = true;
            } else {
                $default = false;
            }
            $options[] = '<optgroup label="Comunidades">';
            foreach ($communities2 as $community) {
                $options[] = '<option value="community-' . $community->ident . '" ' . (($default && ($context->{$context_type}->ident == $community->ident)) ? $select : '') . '>' . $community->label . '</option>';
                $data['communities'][] = 'community-' . $community->ident;
            }
            $options[] = '</optiongroup>';
        }

        // set for user context
        $model_users = new Users();
        $model_friends = new Friends();
        $list_friends = $model_friends->selectFriendsByUser($USER->ident);
        if (count($list_friends) != 0) {
            if ($context_type == 'user') {
                $default = true;
            } else {
                $default = false;
            }
            $options[] = '<optgroup label="Contactos">';
            foreach ($list_friends as $friend) {
                $user = $model_users->findByIdent($friend->friend);
                if ($user->status == 'active') {
                    $options[] = '<option value="user-' . $user->ident . '" ' . (($default && ($context->{$context_type}->ident == $user->ident)) ? $select : '') . '>' . $user->label . '</option>';
                    $data['users'][] = 'user-' . $user->ident;
                }
            }
            $options[] = '</optiongroup>';
        }

        // OK, all ready!
        switch ($format) {
            case 'html':
                $select = '<select name="' . $name . '" id="' . $name . '">' . implode('', $options) . '</select>';
                return $select;
            case 'matrix':
                return $data;
            case 'plain':
                $plain = array();
                foreach ($data as $spaces) {
                    foreach ($spaces as $element) {
                        $plain[] = $element;
                    }
                }
                $plain[] = 'feedback';
                return $plain;
        }
    }
}
