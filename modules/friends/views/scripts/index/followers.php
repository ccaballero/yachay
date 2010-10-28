<h1>Lista de peticiones</h1>

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

<?php if (count($this->followers)) { ?>
    <table width="100%">
    <?php foreach ($this->followers as $follower) { ?>
    <?php $user = $this->users->findByIdent($follower->user); ?>
        <tr>
            <td rowspan="5" width="100px" valign="top">
                <img src="<?= $this->media . '../users/thumbnail_medium/' . $user->getAvatar() ?>" alt="<?= $user->getFullName() ?>" />
            </td>
            <td valign="top">
                <?php if (Yeah_Acl::hasPermission('users', 'view')) { ?>
                    <b><a href="<?= $this->url(array('user' => $user->url), 'users_user_view') ?>"><?= $this->utf2html($user->label) ?></a></b>
                <?php } else { ?>
                    <b><?= $this->utf2html($user->label) ?></b>
                <?php } ?>
                &nbsp;
                <?php if (Yeah_Acl::hasPermission('friends', 'contact')) { ?>
                    [<a href="<?= $this->url(array('user' => $user->url), 'friends_add') ?>"><b><i>Agregar contacto</i></b></a>]
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
        <tr>
            <td colspan="2"><b>Fecha de contacto: </b><?= $this->timestamp($follower->tsregister) ?></td>
        </tr>
    <?php } ?>
    </table>
<?php } else { ?>
<p>No existen peticiones registradas</p>
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
