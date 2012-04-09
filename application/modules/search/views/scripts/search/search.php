<?php

global $SEARCH;
global $USER;

if ($USER->hasPermission('search', 'list')) {
    $SEARCH->action = $this->url(array(), 'search_list');
    $SEARCH->method = 'GET';
    $SEARCH->search = '<input type="text" name="q" /><input type="submit" value="Buscar" />';
}
