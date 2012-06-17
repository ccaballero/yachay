<?php

class Packages_View_Helper_Type
{
    public function type($val) {
        switch ($val) {
            case 'platform':
                return 'Modulo componente de la plataforma';
            case 'middleware':
                return 'Modulo componente de interconexion entre la plataforma y las aplicaciones';
            case 'application':
                return 'Modulo de aplicacion';
            case 'automagic':
                return 'Modulo de funciones agregadas';
        }
    }
}
