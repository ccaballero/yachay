<?php

class Yachay_Helpers_CurrentPage
{
    public function currentPage() {
        $session = new Zend_Session_Namespace('yachay');
        return $session->currentPage;
    }
}
