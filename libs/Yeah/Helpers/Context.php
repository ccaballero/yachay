<?php

class Yeah_Helpers_Context
{
    public function context($name) {
        global $USER;
        $_ = new Yeah_Helpers_Utf2html();

        // context
        $session = new Zend_Session_Namespace();
        $context = $session->context;
        $context_type = $context->getElement();

        $default = '';
        $select = 'selected="selected"';

        $options = array();

        // set for global context
        if ($context_type == 'global') {
            $default = $select;
        }
        
        $options[] = '<option value="global" ' . $default . '>Pagina principal</option>';

        // set for area context
        $areas_model = Yeah_Adapter::getModel('areas');
        $areas_list = $areas_model->selectAll();
        if (count($areas_list) != 0) {
            if ($context_type == 'area') {
                $default = true;
            } else {
                $default = false;
            }
            $options[] = '<optgroup label="Areas">';
            foreach ($areas_list as $area) {
                $options[] = '<option value="area-' . $area->ident . '" ' . (($default && ($context->{$context_type}->ident == $area->ident)) ? $select : '') . '>' . $_->utf2html($area->label) . '</option>';
            }
            $options[] = '</optiongroup>';
        }

        // gestion calculus
        $gestion_model = Yeah_Adapter::getModel('gestions');
        $gestion = $gestion_model->findByActive();
        
        // set for subject context
        $subjects_model = Yeah_Adapter::getModel('subjects');
        $assignement1 = Yeah_Adapter::getModel('subjects', 'Subjects_Users');
        $subjects1 = $subjects_model->selectAll($gestion->ident);
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
                                if (!empty($assign)) {
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
                $options[] = '<option value="subject-' . $subject->ident . '" ' . (($default && ($context->{$context_type}->ident == $subject->ident)) ? $select : '') . '>' . $_->utf2html($subject->label) . '</option>';
            }
            $options[] = '</optiongroup>';
        }

        // set for groupset context
        $groupsets_model = Yeah_Adapter::getModel('groupsets');
        $groupsets1 = $groupsets_model->selectByAuthor($USER->ident);
        $groupsets2 = array();
        foreach ($groupsets1 as $groupset) {
            if ($groupset->gestion == $gestion->ident) {
                $groupsets2[] = $groupset;
            }
        }
        if (count($groupsets2) != 0) {
            $options[] = '<optgroup label="Conjuntos">';
            foreach ($groupsets2 as $groupset) {
                $options[] = '<option value="groupset-' . $groupset->ident . '" ' . '>' . $_->utf2html($groupset->label) . '</option>';
            }
            $options[] = '</optiongroup>';
        }

        // set for group context
        $groups_model = Yeah_Adapter::getModel('groups');
        $assignement2 = Yeah_Adapter::getModel('groups', 'Groups_Users');
        $groups = array();
        foreach ($subjects2 as $subject) {
            $groups_list = $groups_model->selectAll($subject->ident);
            foreach ($groups_list as $group) {
                if ($group->teacher == $USER->ident) {
                    $groups[] = $group;
                }
                $assign = $assignement2->findByGroupAndUser($group->ident, $USER->ident);
                if (!empty($assign)) {
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
                $options[] = '<option value="group-' . $group->ident . '" ' . (($default && ($context->{$context_type}->ident == $group->ident)) ? $select : '') . '>' . $_->utf2html($subject->label) . ' (grupo ' . $_->utf2html($group->label) . ')</option>';
            }
            $options[] = '</optiongroup>';
        }

        // set for team context
        $teams_model = Yeah_Adapter::getModel('teams');
        $assignement3 = Yeah_Adapter::getModel('teams', 'Teams_Users');
        $teams = array();
        foreach ($groups as $group) {
            $teams_list = $teams_model->selectAll($group->ident);
            foreach ($teams_list as $team) {
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
                $options[] = '<option value="team-' . $team->ident . '" ' . (($default && ($context->{$context_type}->ident == $team->ident)) ? $select : '') . '>' . $_->utf2html($subject->label) . ' (grupo ' . $_->utf2html($group->label) . ')(' . $_->utf2html($team->label) . ')</option>';
            }
            $options[] = '</optiongroup>';
        }

        // set for community context
        $commnities_model = Yeah_Adapter::getModel('communities');
        $assignement4 = Yeah_Adapter::getModel('communities', 'Communities_Users');
        $communities1 = $commnities_model->selectAll();
        $communities2 = array();
        foreach ($communities1 as $community) {
            $assign = $assignement4->findByCommunityAndUser($community->ident, $USER->ident);
            if (!empty($assign)) {
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
                $options[] = '<option value="community-' . $community->ident . '" ' . (($default && ($context->{$context_type}->ident == $community->ident)) ? $select : '') . '>' . $_->utf2html($community->label) . '</option>';
            }
            $options[] = '</optiongroup>';
        }

        // set for user context
        $users_model = Yeah_Adapter::getModel('users');
        $users_list = $users_model->selectByStatus('active');
        if (count($users_list) != 0) {
            if ($context_type == 'user') {
                $default = true;
            } else {
                $default = false;
            }
            $options[] = '<optgroup label="Usuarios">';
            foreach ($users_list as $user) {
                $options[] = '<option value="user-' . $user->ident . '" ' . (($default && ($context->{$context_type}->ident == $user->ident)) ? $select : '') . '>' . $_->utf2html($user->label) . '</option>';
            }
            $options[] = '</optiongroup>';
        }

        $select = '<select name="' . $name . '" id="' . $name . '">' . implode('', $options) . '</select>';
        return $select;
    }
}
