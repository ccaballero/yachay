<?php

class Yeah_Helpers_Utf2html
{
    public function utf2html($string) {
        $string = str_replace('á', '&aacute;', $string);
        $string = str_replace('é', '&eacute;', $string);
        $string = str_replace('í', '&iacute;', $string);
        $string = str_replace('ó', '&oacute;', $string);
        $string = str_replace('ú', '&uacute;', $string);
        $string = str_replace('Á', '&Aacute;', $string);
        $string = str_replace('É', '&Eacute;', $string);
        $string = str_replace('Í', '&Iacute;', $string);
        $string = str_replace('Ó', '&Oacute;', $string);
        $string = str_replace('Ú', '&Uacute;', $string);
        $string = str_replace('ñ', '&ntilde;', $string);
        $string = str_replace('Ñ', '&Ntilde;', $string);
        $string = str_replace('º', '&deg;', $string);
        $string = str_replace('ª', '&ordf;', $string);
        $string = str_replace('—', '&mdash;', $string);
        $string = str_replace('–', '&ndash;', $string);
        return $string;
    }
}
