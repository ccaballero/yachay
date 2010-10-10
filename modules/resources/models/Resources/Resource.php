<?php

class modules_resources_models_Resources_Resource extends Yeah_Model_Row_Validation
{
    protected $_validationRules = array();

    public function getAuthor() {
        $users = Yeah_Adapter::getModel('users');
        return $users->findByIdent($this->author);
    }

    public function getExtended() {
        $model_notes = Yeah_Adapter::getModel('notes');
        $note = $model_notes->findByResource($this->ident);
        if (!empty($note)) {
            return $note;
        }
        $model_files = Yeah_Adapter::getModel('files');
        $file = $model_files->findByResource($this->ident);
        if (!empty($file)) {
            return $file;
        }
        $model_events = Yeah_Adapter::getModel('events');
        $event = $model_events->findByResource($this->ident);
        if (!empty($event)) {
            return $event;
        }
    }

    public function amAuthor() {
        global $USER;
        return ($USER->ident == $this->author);
    }

    public function saveContext ($request) {
        $publish = $request->getParam('publish');
        list($element, $ident) = @split('-', $publish);

        switch ($element) {
            case 'global':
                $global_resource_model = Yeah_Adapter::getModel('resources', 'Resources_Globales');
                $global_resource = $global_resource_model->createRow();
                $global_resource->resource = $this->ident;
                $global_resource->save();
                break;
            case 'area':
                $areas_resource_model = Yeah_Adapter::getModel('areas', 'Areas_Resources');
                $area_resource = $areas_resource_model->createRow();
                $area_resource->resource = $this->ident;
                $area_resource->area = $ident;
                $area_resource->save();
                break;
            case 'subject':
                $subjects_resource_model = Yeah_Adapter::getModel('subjects', 'Subjects_Resources');
                $subject_resource = $subjects_resource_model->createRow();
                $subject_resource->resource = $this->ident;
                $subject_resource->subject = $ident;
                $subject_resource->save();
                break;
            case 'groupset':
                $groupsets_model = Yeah_Adapter::getModel('groupsets');
                $groupset = $groupsets_model->findByIdent($ident);
                $groups = $groupset->findmodules_groups_models_GroupsViamodules_groupsets_models_Groupsets_Groups();
                $groups_resource_model = Yeah_Adapter::getModel('groups', 'Groups_Resources');
                foreach ($groups as $group) {
                    $group_resource = $groups_resource_model->createRow();
                    $group_resource->resource = $this->ident;
                    $group_resource->group = $group->ident;
                    $group_resource->save();
                }
                break;
            case 'group':
                $groups_resource_model = Yeah_Adapter::getModel('groups', 'Groups_Resources');
                $group_resource = $groups_resource_model->createRow();
                $group_resource->resource = $this->ident;
                $group_resource->group = $ident;
                $group_resource->save();
                break;
            case 'team':
                $teams_resource_model = Yeah_Adapter::getModel('teams', 'Teams_Resources');
                $team_resource = $teams_resource_model->createRow();
                $team_resource->resource = $this->ident;
                $team_resource->team = $ident;
                $team_resource->save();
                break;
            case 'community':
                $communities_resource_model = Yeah_Adapter::getModel('communities', 'Communities_Resources');
                $community_resource = $communities_resource_model->createRow();
                $community_resource->resource = $this->ident;
                $community_resource->community = $ident;
                $community_resource->save();
            case 'user':
                $users_resource_model = Yeah_Adapter::getModel('users', 'Users_Resources');
                $user_resource = $users_resource_model->createRow();
                $user_resource->resource = $this->ident;
                $user_resource->user = $ident;
                $user_resource->save();
                break;
        }
    }

    public function delete() {
        // FIXME ??
        global $DB;
        $DB->delete('resource_global', '`resource` = ' . $this->ident);
        $DB->delete('area_resource', '`resource` = ' . $this->ident);
        $DB->delete('subject_resource', '`resource` = ' . $this->ident);
        $DB->delete('group_resource', '`resource` = ' . $this->ident);
        $DB->delete('team_resource', '`resource` = ' . $this->ident);
        $DB->delete('community_resource', '`resource` = ' . $this->ident);
        $DB->delete('user_resource', '`resource` = ' . $this->ident);
        parent::delete();
    }
}
