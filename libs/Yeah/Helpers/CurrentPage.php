<?php

class Yeah_Helpers_CurrentPage
{
    public function currentPage() {
        $session = new Zend_Session_Namespace();
        $history = $session->history;
        return $history->currentUrl();
    }
}
