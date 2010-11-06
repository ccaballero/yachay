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
        if (!empty($this->global)) {
            return 'Pagina principal';
        }
        if (!empty($this->area)) {
            return 'Area: ' . $this->area->label;
        }
        if (!empty($this->subject)) {
            return 'Materia: ' . $this->subject->label;
        }
        if (!empty($this->group)) {
            return 'Grupo: ' . $this->group->label;
        }
        if (!empty($this->team)) {
            return 'Equipo: ' . $this->team->label;
        }
        if (!empty($this->user)) {
            return 'Usuario: ' . $this->user->label;
        }
        if (!empty($this->community)) {
            return 'Comunidad: ' . $this->community->label;
        }
        return "";
    }
}
