<?php global $USER; ?>

<h1>Lista de usuarios</h1>

<?php if (count($this->users)) { ?>
<center>
    <?= $this->paginator($this->users, $this->route) ?>
    <table width="100%">
    <?php foreach ($this->users as $user) { ?>
        <tr>
            <td rowspan="4" width="100px">
                <img src="<?= $this->media . 'thumbnail_medium/' . $user->getAvatar() ?>" alt="<?= $user->getFullName() ?>"/>
            </td>
            <td valign="top">
                <?php if (Yeah_Acl::hasPermission('users', 'view')) { ?>
                <a href="<?= $this->url(array('user' => $user->url), 'users_user_view') ?>"><b><?= $this->utf2html($user->label) ?></b></a>
                <?php } else { ?>
                    <b><?= $this->utf2html($user->label) ?></b>
                <?php } ?>
                &nbsp;
                <?php if (Yeah_Acl::hasPermission('users', 'edit') && $USER->hasFewerPrivileges($user)) { ?>
                <b>[<i><a href="<?= $this->url(array('user' => $user->url), 'users_user_edit') ?>">Editar</a></i>]</b>
                <?php } ?>
                <?php if (Yeah_Acl::hasPermission('friends', 'contact')) { ?>
                    <?php if ($USER->ident != $user->ident) { ?>
                        <?php if ($this->friends->hasContact($USER->ident, $user->ident)) { ?>
                        <a href="<?= $this->url(array('user' => $user->url), 'friends_delete') ?>">
                            <b>[<i>Retirar contacto</i>]</b>
                        </a>
                        <?php } else { ?>
                        <a href="<?= $this->url(array('user' => $user->url), 'friends_add') ?>">
                            <b>[<i>Agregar contacto</i>]</b>
                        </a>
                        <?php } ?>
                    <?php } ?>
                <?php } ?>
            </td>
            <td valign="top"><b>Nombre Completo: </b><?= $this->utf2html($user->getFullName()) ?></td>
        </tr>
        <tr>
            <td><b>Cargo: </b><?= $user->getRole()->label ?></td>
            <td><b>Carrera: </b><?= $this->none($user->career) ?></td>
        </tr>
        <tr>
            <td colspan="2">
                <b>Etiquetas: </b>
            <?php
                $tags = $user->getTags();
                foreach ($tags as $tag) { ?>
                    <a href="<?= $this->url(array('tag' => $tag->url), 'tags_tag_view') ?>"><i><?= $tag->label ?></i></a>&nbsp;
            <?php } ?>
            </td>
        </tr>
        <tr>
            <td colspan="2" valign="top">
                <b>Actividad: </b><?= $user->activity ?>&nbsp;
                <b>Participacion: </b><?= $user->participation ?>&nbsp;
                <b>Sociabilidad: </b><?= $user->sociability ?>&nbsp;
                <b>Popularidad: </b><?= $user->popularity ?>
            </td>
        </tr>
    <?php } ?>
    </table>
    <?= $this->paginator($this->users, $this->route) ?>
</center>
<?php } else { ?>
<p>No existen usuarios registrados</p>
<?php } ?>
