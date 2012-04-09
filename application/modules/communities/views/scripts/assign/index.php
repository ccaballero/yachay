<?php

echo '<h1>Miembros: ' . $this->community->label . '</h1>';
echo '<form method="post" action="" accept-charset="utf-8"><input type="hidden" name="return" value="' . $this->currentPage() . '" />';
echo '<table><tr>';
if ($this->community->amAuthor()) {
    echo '<td><input type="submit" value="Convertir en moderador" name="moderate" /></td><td><input type="submit" value="Convertir en miembro" name="unmoderate" /></td>';
}
if ($this->community->amModerator()) {
    echo '<td><input type="submit" value="Habilitar" name="unlock" /></td><td><input type="submit" value="Deshabilitar" name="lock" /></td><td><input type="submit" value="Retirar" name="delete" /></td>';
}
echo '</tr></table>';
echo '<hr />';

echo '<h2>Moderadores</h2>';
if (count($this->moderators) != 0) {
    foreach ($this->moderators as $moderator) {
        $assign = $this->community->getAssignement($moderator);
        echo '<table width="100%"><tr><td rowspan="2" width="18px">';
        if ($this->community->amModerator() && $moderator->ident <> $this->community->author && $moderator->ident <> $this->USER->ident) {
            echo '<input type="checkbox" name="members[]" value="' . $moderator->ident . '" />';
        } else {
            echo '&nbsp;';
        }
        echo '</td><td>';
        if ($this->acl('users', 'view')) {
            echo '<a href="' . $this->url(array('user' => $moderator->url), 'users_user_view') . '">' . $moderator->label . '</a>';
        } else {
            echo $moderator->label;
        }
        echo '</td><td colspan="2">' . $moderator->getFullName() . '</td></tr><tr>';
        echo '<td>Miembro desde: ' . $this->timestamp($assign->tsregister) . '</td><td width="80px">';
        echo $this->enable($assign->status);
        echo '</td><td width="350px">';
        if ($this->community->amModerator() && $this->community->author <> $moderator->ident && $moderator->ident <> $this->USER->ident) {
            echo '[<a href="' . $this->url(array('community' => $this->community->url, 'user' => $moderator->url), 'communities_community_assign_member_unlock') . '">Habilitar</a>]';
            echo '[<a href="' . $this->url(array('community' => $this->community->url, 'user' => $moderator->url), 'communities_community_assign_member_lock') . '">Deshabilitar</a>]';
            echo '[<a href="' . $this->url(array('community' => $this->community->url, 'user' => $moderator->url), 'communities_community_assign_member_delete') . '">Retirar</a>]';
        } else {
            echo '&nbsp;';
        }
        echo '</td></tr></table>';
    }
} else {
    echo '<p>No existe ningun moderador registrado en esta comunidad.</p>';
}

echo '<h2>Miembros</h2>';
if (count($this->members) != 0) {
    foreach ($this->members as $member) {
        $assign = $this->community->getAssignement($member);
        echo '<table width="100%"><tr><td rowspan="2" width="18px">';
        if ($this->community->amModerator()) {
            if ($member->ident <> $this->community->author && $member->ident <> $this->USER->ident ) {
                echo '<input type="checkbox" name="members[]" value="' . $member->ident . '" />';
            }
        } else {
            echo '&nbsp;';
        }
        echo '</td><td>';
        if ($this->acl('users', 'view')) {
            echo '<a href="' . $this->url(array('user' => $member->url), 'users_user_view') . '">' . $member->label . '</a>';
        } else {
            echo $member->label;
        }
        echo '</td><td colspan="2">' . $member->getFullName() . '</td></tr><tr>';
        echo '<td>Miembro desde: ' . $this->timestamp($assign->tsregister) . '</td><td width="80px">';
        echo $this->enable($assign->status);
        echo '</td><td width="350px">';
        if ($this->community->amModerator() && $this->community->author <> $member->ident && $member->ident <> $this->USER->ident) {
            echo '[<a href="' . $this->url(array('community' => $this->community->url, 'user' => $member->url), 'communities_community_assign_member_unlock') . '">Habilitar</a>]';
            echo '[<a href="' . $this->url(array('community' => $this->community->url, 'user' => $member->url), 'communities_community_assign_member_lock') . '">Deshabilitar</a>]';
            echo '[<a href="' . $this->url(array('community' => $this->community->url, 'user' => $member->url), 'communities_community_assign_member_delete') . '">Retirar</a>]';
        } else {
            echo '&nbsp;';
        }
        echo '</td></tr></table>';
    }
} else {
    echo '<p>No existe ningun miembro registrado en esta comunidad.</p>';
}

echo '<hr />';
echo '<table><tr>';
if ($this->community->amAuthor()) {
    echo '<td><input type="submit" value="Convertir en moderador" name="moderate" /></td><td><input type="submit" value="Convertir en miembro" name="unmoderate" /></td>';
}
if ($this->community->amModerator()) {
    echo '<td><input type="submit" value="Habilitar" name="unlock" /></td><td><input type="submit" value="Deshabilitar" name="lock" /></td><td><input type="submit" value="Retirar" name="delete" /></td>';
}
echo '</tr></table>';
echo '</form>';
