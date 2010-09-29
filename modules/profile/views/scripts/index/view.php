<h1>
    <?= $this->utf2html($this->none($this->user->getFullName())) ?>
    [<i><a href="<?= $this->url(array('user' => $this->user->url), 'profile_edit') ?>">Editar</a></i>]
</h1>

<hr />

<p>
    En esta pagina usted puede ver sus datos registrados en el sistema, se recomienda que mantenga al dia esta 
    informacion de manera que pueda sacarle el maximo provecho a este sistema.
</p>

<table width="100%">
    <tr>
        <td rowspan="14" width="200px" valign="top">
            <b><i>Imagen grande:</i></b>
            <br />
            <img src="<?= $this->media . '../users/thumbnail_large/' . $this->user->getAvatar() ?>" alt="<?= $this->user->getFullName() ?>" />
            <br />
            <b><i>Imagen mediana:</i></b>
            <br />
            <img src="<?= $this->media . '../users/thumbnail_medium/' . $this->user->getAvatar() ?>" alt="<?= $this->user->getFullName() ?>" />
            <br />
            <b><i>Imagen peque&ntilde;a:</i></b>
            <br />
            <img src="<?= $this->media . '../users/thumbnail_small/' . $this->user->getAvatar() ?>" alt="<?= $this->user->getFullName() ?>" />
        </td>
        <td colspan="2"><b>Usuario: </b><?= $this->user->label ?></td>
        <td colspan="2"><b>Codigo: </b><?= $this->user->code ?></td>
    </tr>
    <tr>
        <td colspan="4"><b>Correo electronico: </b><?= $this->none($this->user->email) ?></td>
    </tr>
    <tr>
        <td colspan="4"><b>Apellidos: </b><?= $this->utf2html($this->none($this->user->surname)) ?></td>
    </tr>
    <tr>
        <td colspan="4"><b>Nombres: </b><?= $this->utf2html($this->none($this->user->name)) ?></td>
    </tr>
    <tr>
        <td colspan="4"><b>Fecha de nacimiento: </b><?= $this->none($this->user->birthdate) ?></td>
    </tr>
    <tr>
        <td colspan="2"><b>Cargo: </b><?= $this->utf2html($this->user->getRole()->label) ?></td>
        <td colspan="2"><b>Carrera: </b><?= $this->utf2html($this->none($this->user->career)) ?></td>
    </tr>
    <tr>
        <td colspan="2"><b>Telefono: </b><?= $this->none($this->user->phone) ?></td>
        <td colspan="2"><b>Celular: </b><?= $this->none($this->user->cellphone) ?></td>
    </tr>
    <tr>
        <td colspan="4">
            <b>Actividad: </b><?= $this->user->activity ?>&nbsp;
            <b>Participacion: </b><?= $this->user->participation ?>&nbsp;
            <b>Sociabilidad: </b><?= $this->user->sociability ?>
        </td>
        <!--<td><b>Conocimiento: </b><?= $this->user->knowledge ?></td>
        <td><b>Popularidad: </b><?= $this->user->popularity ?></td>-->
    </tr>
    <tr>
        <td colspan="4"><b>Miembro desde: </b><?= $this->timestamp($this->user->tsregister) ?></td>
    </tr>
    <tr>
        <td colspan="4"><b>Ultimo acceso: </b><?= $this->timestamp($this->user->tslastlogin) ?></td>
    </tr>
    <tr>
        <td colspan="4"><b>Intereses: </b><?= $this->utf2html($this->none($this->user->interests)) ?></td>
    </tr>
    <tr>
        <td colspan="4"><b>Pasatiempos: </b><?= $this->utf2html($this->none($this->user->hobbies)) ?></td>
    </tr>
    <tr>
        <td colspan="4"><b>Descripcion personal: </b><?= $this->utf2html($this->none($this->user->description)) ?></td>
    </tr>
    <tr>
        <td colspan="4"><b>Firma: </b><?= $this->utf2html($this->none($this->user->sign)) ?></td>
    </tr>
</table>
