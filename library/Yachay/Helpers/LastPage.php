<?php

class Yachay_Helpers_LastPage
{
    public function lastPage() {
        $session = new Zend_Session_Namespace('yachay');
        return $session->lastPage;
    }
}

