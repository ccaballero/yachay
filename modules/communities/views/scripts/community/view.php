<h1>Comunidad: <?= $this->utf2html($this->community->label) ?>
    <?php if ($this->community->amAuthor()) { ?>
    <a href="<?= $this->url(array('community' => $this->community->url), 'communities_community_edit') ?>">
        <b><i>[Editar]</i></b>
    </a>
    <?php } ?>
</h1>

<table width="100%">
    <tr valign="top">
        <td rowspan="5" width="200px">
            <img src="<?= $this->media . 'thumbnail_large/' . $this->community->getAvatar() ?>" />
        </td>
        <td><b>Descripci&oacute;n: </b></td>
    </tr>
    <tr><td><?= $this->utf2html($this->community->description) ?></td></tr>
    <tr valign="top"><td><b>Modalidad: </b><?= $this->mode(NULL, $this->community->mode) ?></td></tr>
    <tr valign="top"><td><b>Intereses: </b><?= $this->community->interests ?></td></tr>
    <tr valign="top">
        <td>
            <b>Miembros: </b><?= $this->community->members ?>
            <i><a href="<?= $this->url(array('community' => $this->community->url), 'communities_community_assign') ?>">[Ver miembros]</a></i>
        </td>
    </tr>
</table>

<?= $this->partial('resource.php', array('resources' => $this->resources, 'route' => $this->route)) ?>
