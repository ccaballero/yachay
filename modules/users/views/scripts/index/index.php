<h1>Lista de usuarios</h1>
<?php global $USER; ?>
<?php if (count($this->users)) { ?>
    <center><?= $this->paginator($this->users, $this->route) ?></center>
    <?php foreach ($this->users as $user) { ?>
        <table width="100%">
            <tr>
                <td rowspan="5" width="100px">
                    <img src="<?= $this->media . 'thumbnail_medium/' . $user->getAvatar() ?>" />
                </td>
                <td colspan="4">
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
            </tr>
            <tr>
                <td colspan="4"><b>Nombre Completo: </b><?= $this->utf2html($user->getFullName()) ?></td>
            </tr>
            <tr>
                <td colspan="2" width="50%"><b>Cargo: </b><?= $user->getRole()->label ?></td>
                <td colspan="2" width="50%"><b>Carrera: </b><?= $this->none($user->career) ?></td>
            </tr>
            <tr>
                <td colspan="2"><b>Actividad: </b><?= $user->activity ?></td>
                <td colspan="2"><b>Sociabilidad: </b><?= $user->sociability ?></td>
                <!--<td><b>Conocimiento: </b><?= $user->knowledge ?></td>
                <td><b>Participacion: </b><?= $user->participation ?></td>
                <td><b>Popularidad: </b><?= $user->popularity ?></td>-->
            </tr>
            <tr>
                <td colspan="4">&nbsp;<?= $user->interests ?></td>
            </tr>
        </table>
    <?php } ?>
    <center><?= $this->paginator($this->users, $this->route) ?></center>
<?php } else { ?>
<p>No existen usuarios registrados</p>
<?php } ?>
