<h1>Comunidad: <?= $this->utf2html($this->community->label) ?>
    <?php if ($this->community->amAuthor()) { ?>
    <a href="<?= $this->url(array('community' => $this->community->url), 'communities_community_edit') ?>">
        <b><i>[Editar]</i></b>
    </a>
    <?php } ?>
    <?php if (Yeah_Acl::hasPermission('communities', 'enter')) { ?>
        <?php if (!$this->community->amModerator() && !$this->community->amMember()) { ?>
            [<a href="<?= $this->url(array('community' => $this->community->url), 'communities_community_join') ?>">Unirse</a>]
        <?php } else if (!$this->community->amAuthor()) { ?>
            [<a href="<?= $this->url(array('community' => $this->community->url), 'communities_community_leave') ?>">Retirarse</a>]
        <?php } ?>
    <?php } ?>
</h1>

<table width="100%">
    <tr valign="top">
        <td rowspan="7" width="200px">
            <img src="<?= $this->media . 'thumbnail_large/' . $this->community->getAvatar() ?>" />
        </td>
        <td><b>Descripci&oacute;n: </b></td>
    </tr>
    <tr><td><?= $this->utf2html($this->community->description) ?></td></tr>
    <tr valign="top"><td><b>Modalidad: </b><?= $this->mode(NULL, $this->community->mode) ?></td></tr>
    <tr valign="top"><td><b>Intereses: </b><?= $this->community->interests ?></td></tr>
    <tr valign="top">
        <td>
            <b>Autor: </b>
            <?php if (Yeah_Acl::hasPermission('users', 'view')) { ?>
                <a href="<?= $this->url(array('user' => $this->community->getAuthor()->url), 'users_user_view') ?>"><?= $this->community->getAuthor()->getFullName() ?></a>
            <?php } else { ?>
                <?= $this->community->getAuthor()->getFullName() ?>
            <?php } ?>
        </td>
    </tr>
    <tr valign="top">
        <td>
            <b>Miembros: </b><?= $this->community->members ?>
            <?php if (Yeah_Acl::hasPermission('communities', 'enter')) { ?>
            <i><a href="<?= $this->url(array('community' => $this->community->url), 'communities_community_assign') ?>">[Ver miembros]</a></i>
            <?php } ?>
        </td>
    </tr>
<?php if ($this->community->mode == 'close') { ?>
    <tr valign="top">
        <td>
            <b>Peticiones: </b><?= $this->community->petitions ?>
            <?php if ($this->community->amModerator()) { ?>
            <i><a href="<?= $this->url(array('community' => $this->community->url), 'communities_community_petition') ?>">[Ver peticiones]</a></i>
            <?php } ?>
        </td>
    </tr>
<?php } ?>
</table>

<?= $this->partial('resource.php', array('resources' => $this->resources, 'route' => $this->route)) ?>
