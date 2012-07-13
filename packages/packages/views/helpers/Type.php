<?php

class Packages_View_Helper_Type
{
    public function type($val) {
        switch ($val) {
            case 'base':
                return 'Modulo componente de la plataforma';
            case 'middle':
                return 'Modulo componente de interconexion entre la plataforma y las aplicaciones';
            case 'app':
                return 'Modulo de aplicacion';
            case 'util':
                return 'Modulo de funciones agregadas';
        }
    }
}
