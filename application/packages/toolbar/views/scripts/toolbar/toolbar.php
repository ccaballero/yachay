<?php

global $TOOLBAR;

$model_roles = new Roles();
$role = $model_roles->findByIdent($this->user->role);

$session = new Zend_Session_Namespace('yachay');
$TOOLBAR->items[] = $this->contextLabel($session->context_type, $session->context_label);

if ($this->user->role == 1) {
    $TOOLBAR->items[] = $role->label;
    $TOOLBAR->items[] = '<a href="' . $this->url(array(), 'login_in') . '">Ingresar</a>';
} else {
    $TOOLBAR->items[] = '<a href="' . $this->url(array('user' => $this->user->url), 'profile_view') . '">' . $this->user->getFullName() . '</a>';
    $TOOLBAR->items[] = '<a href="' . $this->url(array('user' => $this->user->url), 'settings') . '">Preferencias</a>';
    $TOOLBAR->items[] = '<a href="' . $this->url(array(), 'login_out') . '">Salir</a>';
}
