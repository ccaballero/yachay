<h1>Comunidad: <?= $this->community->label ?>
    <?php if ($this->community->amAuthor()) { ?>
        <b><i>[<a href="<?= $this->url(array('community' => $this->community->url), 'communities_community_edit') ?>">Editar</a>]</i></b>
    <?php } ?>
    <?php if ($this->acl('communities', 'enter')) { ?>
        <?php if (!$this->community->amModerator() && !$this->community->amMember()) { ?>
            [<a href="<?= $this->url(array('community' => $this->community->url), 'communities_community_join') ?>">Unirse</a>]
        <?php } else if (!$this->community->amAuthor()) { ?>
            [<a href="<?= $this->url(array('community' => $this->community->url), 'communities_community_leave') ?>">Retirarse</a>]
        <?php } ?>
    <?php } ?>
</h1>

<table width="100%">
    <tr valign="top">
        <td><b>Descripción: </b></td>
    </tr>
    <tr><td><?= $this->community->description ?></td></tr>
    <tr valign="top"><td><b>Modalidad: </b><?= $this->mode(NULL, $this->community->mode) ?></td></tr>
    <tr valign="top">
        <td colspan="2">
            <b>Etiquetas: </b>
        <?php
            $tags = $this->community->getTags();
            foreach ($tags as $tag) { ?>
                <a href="<?= $this->url(array('tag' => $tag->url), 'tags_tag_view') ?>"><i><?= $tag->label ?></i></a>&nbsp;
        <?php } ?>
        </td>
    </tr>
    <tr valign="top">
        <td>
            <b>Autor: </b>
            <?php if ($this->acl('users', 'view')) { ?>
                <a href="<?= $this->url(array('user' => $this->community->getAuthor()->url), 'users_user_view') ?>"><?= $this->community->getAuthor()->getFullName() ?></a>
            <?php } else { ?>
                <?= $this->community->getAuthor()->getFullName() ?>
            <?php } ?>
        </td>
    </tr>
    <tr valign="top">
        <td>
            <b>Miembros: </b><?= $this->community->members ?>
            <?php if ($this->acl('communities', 'enter')) { ?>
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

<?= $this->partial($this->template('resources', 'resource'), array('resources' => $this->resources, 'route' => $this->route, 'CONFIG' => $this->CONFIG, 'TEMPLATE' => $this->TEMPLATE, )) ?>
