<h1>Lista de amigos</h1>

<?php if (Yeah_Acl::hasPermission('friends', 'contact')) { ?>
<table>
    <tr>
        <td>[<a href="<?= $this->url(array(), 'friends_friends') ?>">Amigos</a>]</td>
        <td>[<a href="<?= $this->url(array(), 'friends_followings') ?>">Solicitudes</a>]</td>
        <td>[<a href="<?= $this->url(array(), 'friends_followers') ?>">Peticiones</a>]</td>
    </tr>
</table>
<?php } ?>
<hr/>

<?php if (count($this->friends)) { ?>
    <?php foreach ($this->friends as $friend) { ?>
        <?php $user = $this->users->findByIdent($friend->friend); ?>
        <table width="100%">
            <tr>
                <td rowspan="6" width="100px" valign="top">
                    <img src="<?= $this->media . '../users/thumbnail_medium/' . $user->getAvatar() ?>" alt="<?= $user->getFullName() ?>" />
                </td>
                <td colspan="4">
                    <?php if (Yeah_Acl::hasPermission('users', 'view')) { ?>
                        <b><a href="<?= $this->url(array('user' => $user->url), 'users_user_view') ?>"><?= $this->utf2html($user->label) ?></a></b>
                    <?php } else { ?>
                        <b><?= $this->utf2html($user->label) ?></b>
                    <?php } ?>
                    &nbsp;
                    <?php if (Yeah_Acl::hasPermission('friends', 'contact')) { ?>
                        [<a href="<?= $this->url(array('user' => $user->url), 'friends_delete') ?>"><b><i>Retirar contacto</i></b></a>]
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
                <td colspan="4">
                    <b>Actividad: </b><?= $user->activity ?>&nbsp;
                    <b>Participacion: </b><?= $user->participation ?>&nbsp;
                    <b>Sociabilidad: </b><?= $user->sociability ?>&nbsp;
                    <b>Popularidad: </b><?= $user->popularity ?>
                </td>
            </tr>
            <tr>
                <td colspan="4"><b>Intereses: </b><?= $this->none($user->interests) ?></td>
            </tr>
            <tr>
                <td colspan="4"><b>Fecha de contacto: </b><?= $this->timestamp($friend->tsregister) ?></td>
            </tr>
        </table>
        <br />
    <?php } ?>
<?php } else { ?>
<p>No existen amigos registrados</p>
<?php } ?>

<hr/>
<?php if (Yeah_Acl::hasPermission('friends', 'contact')) { ?>
<table>
    <tr>
        <td>[<a href="<?= $this->url(array(), 'friends_friends') ?>">Amigos</a>]</td>
        <td>[<a href="<?= $this->url(array(), 'friends_followings') ?>">Solicitudes</a>]</td>
        <td>[<a href="<?= $this->url(array(), 'friends_followers') ?>">Peticiones</a>]</td>
    </tr>
</table>
<?php } ?>
