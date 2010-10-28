<h1>Usuario: <?= $this->utf2html($this->user->label) ?>
<?php global $USER; ?>
    <?php if (Yeah_Acl::hasPermission('users', 'edit') && $USER->hasFewerPrivileges($this->user)) { ?>
        [<i><a href="<?= $this->url(array('user' => $this->user->url), 'users_user_edit') ?>">Editar</a></i>]
    <?php } ?>
    <?php if (Yeah_Acl::hasPermission('friends', 'contact')) { ?>
        <?php if ($USER->ident != $this->user->ident) { ?>
            <?php if ($this->friends->hasContact($USER->ident, $this->user->ident)) { ?>
            [<a href="<?= $this->url(array('user' => $this->user->url), 'friends_delete') ?>"><b><i>Retirar contacto</i></b></a>]
            <?php } else { ?>
            [<a href="<?= $this->url(array('user' => $this->user->url), 'friends_add') ?>"><b><i>Agregar contacto</i></b></a>]
            <?php } ?>
        <?php } ?>
    <?php } ?>
</h1>

<table width="100%">
    <tr valign="top">
        <td rowspan="9" width="200px">
            <img src="<?= $this->media . 'thumbnail_large/' . $this->user->getAvatar() ?>" alt="<?= $this->user->getFullName() ?>" />
        </td>
        <td colspan="4"><b>Nombre Completo: </b><?= $this->utf2html($this->user->getFullName()) ?></td>
    </tr>
    <tr valign="top">
        <td colspan="2"><b>Cargo: </b><?= $this->user->getRole()->label ?></td>
        <td colspan="2"><b>Carrera: </b><?= $this->none($this->user->career) ?></td>
    </tr>
    <tr valign="top">
        <td colspan="4">
            <b>Etiquetas: </b>
        <?php
            $tags = $this->user->getTags();
            foreach ($tags as $tag) { ?>
                <a href="<?= $this->url(array('tag' => $tag->url), 'tags_tag_view') ?>"><i><?= $tag->label ?></i></a>&nbsp;
        <?php } ?>
        </td>
    </tr>
    <tr>
        <td colspan="4">
            <b>Actividad: </b><?= $this->user->activity ?>&nbsp;
            <b>Participacion: </b><?= $this->user->participation ?>&nbsp;
            <b>Sociabilidad: </b><?= $this->user->sociability ?>&nbsp;
            <b>Popularidad: </b><?= $this->user->popularity ?>
        </td>
    </tr>
    <tr valign="top"><td colspan="4"><b>Descripcion Personal:</b></td></tr>
    <tr valign="top"><td colspan="4"><?= $this->none($this->utf2html($this->user->description)) ?></td></tr>
    <tr valign="top"><td colspan="4"><b>Pasatiempos:</b></td></tr>
    <tr valign="top"><td colspan="4"><?= $this->none($this->utf2html($this->user->hobbies)) ?></td></tr>
</table>
<hr />
<?= $this->partial('resource.php', array('resources' => $this->resources, 'route' => $this->route)) ?>
