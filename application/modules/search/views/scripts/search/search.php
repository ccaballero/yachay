<?php

global $SEARCH;

if ($this->user->hasPermission('search', 'list')) {
    $SEARCH->action = $this->url(array(), 'search_list');
    $SEARCH->method = 'GET';
    $SEARCH->search = '<input type="text" name="q" /><input type="submit" value="Buscar" />';
}
