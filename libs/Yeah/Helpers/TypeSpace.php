<?php

class Yeah_Helpers_TypeSpace
{
    public function typeSpace($val) {
        switch ($val) {
            case 'global':
                return 'General';
            case 'areas':
                return 'Áreas';
            case 'careers':
                return 'Carreras';
            case 'subjects':
                return 'Materias';
            case 'groupsets':
                return 'Conjuntos';
            case 'groups':
                return 'Grupos';
            case 'teams':
                return 'Equipos';
            case 'communities':
                return 'Comunidades';
            case 'users':
                return 'Contactos';
            case 'me':
                return 'Personal';
        }
    }
}
