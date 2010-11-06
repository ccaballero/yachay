<?php 

echo '<h1>' . $this->PAGE->label . ' [<i><a href="' . $this->url(array('user' => $this->user->url), 'profile_edit') . '">Editar</a></i>]</h1>';
echo '<hr />';
echo '<p>En esta pagina usted puede ver sus datos registrados en el sistema, se recomienda que mantenga al dia esta información de manera que pueda sacarle el maximo provecho a este sistema.</p>';

echo '<table width="100%"><tr><td rowspan="14" width="200px" valign="top">';
echo '<b><i>Imagen grande:</i></b><br />';
echo '<img src="' . $this->media . 'users/thumbnail_large/' . $this->user->getAvatar() . '" alt="' . $this->user->getFullName() . '" />';
echo '<br /><b><i>Imagen mediana:</i></b><br />';
echo '<img src="' . $this->media . 'users/thumbnail_medium/' . $this->user->getAvatar() . '" alt="' . $this->user->getFullName() . '" />';
echo '<br /><b><i>Imagen pequeña:</i></b><br />';
echo '<img src="' . $this->media . 'users/thumbnail_small/' . $this->user->getAvatar() . '" alt="' . $this->user->getFullName() . '" />';
echo '</td><td colspan="2"><b>Usuario: </b>' . $this->user->label . '</td>';
echo '<td colspan="2"><b>Codigo: </b>' . $this->user->code . '</td></tr>';
echo '<tr><td colspan="4"><b>Correo electronico: </b>' . $this->none($this->user->email) . '</td></tr>';
echo '<tr><td colspan="4"><b>Apellidos: </b>' . $this->none($this->user->surname) . '</td></tr>';
echo '<tr><td colspan="4"><b>Nombres: </b>' . $this->none($this->user->name) . '</td></tr>';
echo '<tr><td colspan="4"><b>Fecha de nacimiento: </b>' . $this->none($this->user->birthdate) . '</td></tr>';
echo '<tr><td colspan="2"><b>Cargo: </b>' . $this->user->getRole()->label . '</td>';
echo '<td colspan="2"><b>Carrera: </b>' . $this->none($this->user->career) . '</td></tr>';
echo '<tr><td colspan="2"><b>Telefono: </b>' . $this->none($this->user->phone) . '</td>';
echo '<td colspan="2"><b>Celular: </b>' . $this->none($this->user->cellphone) . '</td></tr>';
echo '<tr><td colspan="4"><b>Actividad: </b>' . $this->user->activity . '&nbsp;<b>Participacion: </b>' . $this->user->participation . '&nbsp;';
echo '<b>Sociabilidad: </b>' . $this->user->sociability . '&nbsp;<b>Popularidad: </b>' . $this->user->popularity . '</td></tr>';
echo '<tr><td colspan="4"><b>Miembro desde: </b>' . $this->timestamp($this->user->tsregister) . '</td></tr>';
echo '<tr><td colspan="4"><b>Ultimo acceso: </b>' . $this->timestamp($this->user->tslastlogin) . '</td></tr>';
echo '<tr><td colspan="4"><b>Etiquetas: </b>';

$tags = $this->user->getTags();
foreach ($tags as $tag) {
    echo '<a href="' . $this->url(array('tag' => $tag->url), 'tags_tag_view') . '"><i>' . $tag->label . '</i></a>&nbsp;';
}

echo '</td></tr><tr><td colspan="4"><b>Pasatiempos: </b>' . $this->none($this->user->hobbies) . '</td>';
echo '</tr><tr><td colspan="4"><b>Descripcion personal: </b>' . $this->none($this->user->description) . '</td>';
echo '</tr><tr><td colspan="4"><b>Firma: </b>' . $this->none($this->user->sign) . '</td></tr></table>';
