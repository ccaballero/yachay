<?php

class Yachay_Helpers_Mime
{
    public function mime($value) {
        $config = Zend_Registry::get('config');

        $return = 'unknown.png';
        $mimes = array (
            'application/zip' => 'application-zip.png',
            'application/x-compressed-tar' => 'application-x-tar.png',
            'application/x-gzip' => 'application-x-gzip.png',
            'application/x-rar' => 'application-x-rar.png',
            'application/x-php' => 'application-x-php.png',
            'application/x-java' => 'application-x-java.png',
            'application/x-python' => 'text-x-python.png',
            'application/pdf' => 'application-pdf.png',
            'audio/mpeg' => 'audio-mpeg.png',
            'image/jpeg' => 'image-x-generic.png',
            'image/jpg' => 'image-x-generic.png',
            'image/png' => 'image-x-generic.png',
            'image/gif' => 'image-x-generic.png',
            'text/x-sql' => 'text-x-sql.png',
            'text/plain' => 'text-plain.png'
        );
        foreach ($mimes as $key => $mime) {
            if ($key == $value) {
                $image = '<img src = "' . $config->resources->frontController->baseUrl . '/media/mimetypes/' . $mime . '" />';
                return $image;
            }
        }

        return $image = '<img src = "' . $config->resources->frontController->baseUrl . '/media/mimetypes/' . $return . '" />';
    }
}
