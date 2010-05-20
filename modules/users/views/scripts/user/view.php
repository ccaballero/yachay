<h1>Usuario: <?= $this->utf2html($this->user->label) ?>
    <?php if (Yeah_Acl::hasPermission('users', 'edit')) { ?>
    <i><a href="<?= $this->url(array('user' => $this->user->url), 'users_user_edit') ?>">[Editar]</a></i>
    <?php } ?>
</h1>

<table width="100%">
    <tr>
        <td rowspan="4">
            <img src="<?= $this->media . 'thumbnail_medium/0.jpg' ?>" />
        </td>
        <td colspan="4"><b>Nombre Completo: </b><?= $this->utf2html($this->user->getFullName()) ?></td>
    </tr>
    <tr>
        <td colspan="4"><b>Correo Electronico: </b><?= $this->user->email ?></td>
    </tr>
    <tr>
        <td colspan="2"><b>Cargo: </b><?= $this->user->getRole()->label ?></td>
        <td colspan="2"><b>Carrera: </b><?= $this->none($this->user->career) ?></td>
    </tr>
    <tr>
        <td><b>Conocimiento: </b><?= $this->user->knowledge ?></td>
        <td><b>Participacion: </b><?= $this->user->participation ?></td>
        <td><b>Popularidad: </b><?= $this->user->popularity ?></td>
        <td><b>Actividad: </b><?= $this->user->activity ?></td>
    </tr>
</table>

<p>
    <b>Descripcion Personal:</b>
    <?= $this->none($this->utf2html($this->user->description)) ?>
</p>

<p>
    <b>Pasatiempos:</b>
    <?= $this->none($this->utf2html($this->user->hobbies)) ?>
</p>

<p>
    <b>Intereses:</b>
    <?= $this->none($this->utf2html($this->user->interests)) ?>
</p>

<hr />

<?= $this->partial('resource.php', array('resources' => $this->resources, 'route' => $this->route)) ?>
