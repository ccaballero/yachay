<?php

class Yachay_Helpers_ContextLabel
{
    public function contextLabel($type, $label) {
        switch ($type) {
            case 'global':
                return 'Pagina principal';
            case 'area':
                return 'Area: ' . $label;
            case 'career':
                return 'Carrera: ' . $label;
            case 'subject':
                return 'Materia: ' . $label;
            case 'group':
                return 'Grupo: ' . $label;
            case 'team':
                return 'Equipo: ' . $label;
            case 'user':
                return 'Usuario: ' . $label;
            case 'community':
                return 'Comunidad: ' . $label;
        }
    }
}
