<?php

class Yeah_Helpers_LastPage
{
    public function lastPage() {
        $session = new Zend_Session_Namespace();
        $history = $session->history;
        return $history->lastUrl();
    }
}

