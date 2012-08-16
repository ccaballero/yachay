<?php

echo '<h1>' . $this->route->label . '</h1>';
echo '<form method="post" action="" accept-charset="utf-8">';
echo '<input type="hidden" name="return" value="' . $this->currentPage() . '" />';

echo '<table><tr>';
if (Yachay_Acl::hasPermission('invitations', 'new')) {
    echo '<td>[<a href="' . $this->url(array(), 'invitations_new') . '">Nuevo</a>]</td>';
}
echo '</tr></table>';
echo '<hr />';

if (count($this->invitations)) {
    echo '<table><tr><th>' . $this->model_invitations->_mapping['email'] . '</th><th>Opciones</th><th>' . $this->model_invitations->_mapping['tsregister'] . '</th></tr>';
    foreach ($this->invitations as $invitation) {
        echo '<tr><td>' . $invitation->email . '</td><td><center>';
        if (!$invitation->accepted) {
            echo '[<a href="' . $this->url(array('invitation' => $invitation->ident), 'invitations_invitation_delete') . '">Revocar</a>]';
        }
        echo '</center></td>';
        echo '<td><center>' . $this->timestamp($invitation->tsregister) . '</center></td></tr>';
    }
    echo '</table>';
} else {
    echo '<p>No enviaste ninguna invitación aún</p>';
}

echo '<hr />';
echo '<table><tr>';
if (Yachay_Acl::hasPermission('invitations', 'new')) {
    echo '<td>[<a href="' . $this->url(array(), 'invitations_new') . '">Nuevo</a>]</td>';
}
echo '</tr></table>';
echo '</form>';
