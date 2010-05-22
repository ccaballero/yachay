<?php

class Yeah_Settings_Context
{
    public $global;
    public $area;
    public $subject;
    public $group;
    public $team;
    public $user;
    public $community;
    
    public function getElement() {
        if (!empty($this->global)) {
            return 'global';
        }
        if (!empty($this->area)) {
            return 'area';
        }
        if (!empty($this->subject)) {
            return 'subject';
        }
        if (!empty($this->group)) {
            return 'group';
        }
        if (!empty($this->team)) {
            return 'team';
        }
        if (!empty($this->user)) {
            return 'user';
        }
        if (!empty($this->community)) {
            return 'community';
        }
    }
    
    public function __toString() {
        $utf = new Yeah_Helpers_Utf2html;
        if (!empty($this->global)) {
            return 'Sistema';
        }
        if (!empty($this->area)) {
            return 'Area: ' . $utf->utf2html($this->area->label);
        }
        if (!empty($this->subject)) {
            return 'Materia: ' . $utf->utf2html($this->subject->label);
        }
        if (!empty($this->group)) {
            return 'Grupo: ' . $utf->utf2html($this->group->label);
        }
        if (!empty($this->team)) {
            return 'Equipo: ' . $utf->utf2html($this->team->label);
        }
        if (!empty($this->user)) {
            return 'Usuario: ' . $utf->utf2html($this->user->label);
        }
        if (!empty($this->community)) {
            return 'Comunidad: ' . $utf->utf2html($this->community->label);
        }
        return "";
    }
}
