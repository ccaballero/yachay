<?php

global $TOOLBAR;
global $USER;

$model_roles = new Roles();
$role = $model_roles->findByIdent($USER->role);

$session = new Zend_Session_Namespace();
$context = $session->context;
$TOOLBAR->items[] = $context->__toString();

if ($USER->role == 1) {
    $TOOLBAR->items[] = $role->label;
    $TOOLBAR->items[] = '<a href="' . $this->url(array(), 'login_in') . '">Ingresar</a>';
} else {
    $TOOLBAR->items[] = '<a href="' . $this->url(array('user' => $USER->url), 'profile_view') . '">' . $USER->getFullName() . '</a>';
    $TOOLBAR->items[] = '<a href="' . $this->url(array('user' => $USER->url), 'settings') . '">Preferencias</a>';
    $TOOLBAR->items[] = '<a href="' . $this->url(array(), 'login_out') . '">Salir</a>';
}
