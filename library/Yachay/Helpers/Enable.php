<?php

class Yachay_Helpers_Enable
{
    public function enable($val) {
        switch ($val) {
            case 'active':
                return 'Habilitado';
            case 'inactive':
                return 'Inhabilitado';
        }
    }
}
