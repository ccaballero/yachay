<?php

echo '<h1>Peticiones: ' . $this->community->label . '</h1>';

echo '<form method="post" action="" accept-charset="utf-8">';
echo '<input type="hidden" name="return" value="' . $this->currentPage() . '" />';
echo '<table>';
echo '<tr>';
if ($this->community->amModerator()) {
    echo '<td><input type="submit" value="Aceptar Petición" name="accept" /></td>';
    echo '<td><input type="submit" value="Denegar Petición" name="decline" /></td>';
}
echo '</tr>';
echo '</table>';
echo '<hr />';

if (count($this->applicants) != 0) {
    foreach ($this->applicants as $applicant) {
        $assign = $this->community->getPetition($applicant);
        echo '<table width="100%">';
        echo '<tr>';
        echo '<td rowspan="2" width="18px">';
        if ($this->community->amModerator()) {
            echo '<input type="checkbox" name="applicants[]" value="' . $applicant->ident . '" />';
        } else {
            echo '&nbsp;';
        }
        echo '</td>';
        echo '<td>';
        if ($this->acl('users', 'view')) {
            echo '<a href="' . $this->url(array('user' => $applicant->url), 'users_user_view') . '">' . $applicant->label . '</a>';
        } else {
            echo $applicant->label;
        }
        echo '</td>';
        echo '<td colspan="2">' . $applicant->getFullName() . '</td>';
        echo '</tr>';
        echo '<tr>';
        echo '<td>Fecha de solicitud: ' . $this->timestamp($assign->tsregister) . '</td>';
        echo '<td width="240px">';
        if ($this->community->amModerator()) {
            echo '[<a href="' . $this->url(array('community' => $this->community->url, 'user' => $applicant->url), 'communities_community_petition_applicant_accept') . '">Aceptar</a>]';
            echo '[<a href="' . $this->url(array('community' => $this->community->url, 'user' => $applicant->url), 'communities_community_petition_applicant_decline') . '">Denegar</a>]';
        } else {
            echo '&nbsp;';
        }
        echo '</td>';
        echo '</tr>';
        echo '</table>';
    }
} else {
    echo '<p>No existe ninguna petición de ingreso en esta comunidad.</p>';
}

echo '<hr />';
echo '<table>';
echo '<tr>';
if ($this->community->amModerator()) {
    echo '<td><input type="submit" value="Aceptar Petición" name="accept" /></td>';
    echo '<td><input type="submit" value="Denegar Petición" name="decline" /></td>';
}
echo '</tr>';
echo '</table>';
echo '</form>';
