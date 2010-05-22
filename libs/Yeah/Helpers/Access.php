<?php

class Yeah_Helpers_Access
{
    public function access($val) {
        switch ($val) {
            case 'public':
                return 'Publica';
            case 'private':
                return 'Privada';
        }
    }
}
