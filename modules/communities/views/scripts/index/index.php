<h1>Lista de comunidades</h1>

<?php if (count($this->communities)) { ?>
    <center><?= $this->paginator($this->communities, $this->route) ?></center>
    <?php foreach ($this->communities as $community) { ?>
        <table width="100%">
            <tr>
                <td rowspan="5" width="100px">
                    <img src="<?= $this->media . 'thumbnail_medium/' . $community->getAvatar() ?>" />
                </td>
                <td colspan="2">
                    <?php if (Yeah_Acl::hasPermission('communities', 'view')) { ?>
                    <a href="<?= $this->url(array('community' => $community->url), 'communities_community_view') ?>">
                        <b><?= $this->utf2html($community->label) ?></b>
                    </a>
                    <?php } else { ?>
                        <b><?= $this->utf2html($community->label) ?></b>
                    <?php } ?>
                    &nbsp;
                    <?php if ($community->amAuthor()) { ?>
                        <b><i>[<a href="<?= $this->url(array('community' => $community->url), 'communities_community_edit') ?>">Editar</a>]</i></b>
                    <?php } ?>
                    <?php if (Yeah_Acl::hasPermission('communities', 'enter')) { ?>
                        <?php if (!$community->amModerator() && !$community->amMember()) { ?>
                            [<a href="<?= $this->url(array('community' => $community->url), 'communities_community_join') ?>">Unirse</a>]
                        <?php } else if (!$community->amAuthor()) { ?>
                            [<a href="<?= $this->url(array('community' => $community->url), 'communities_community_leave') ?>">Retirarse</a>]
                        <?php } ?>
                    <?php } ?>
                </td>
            </tr>
            <tr>
                <td colspan="2"><b>Descripci&oacute;n: </b><?= $this->utf2html($community->description) ?></td>
            </tr>
            <tr>
                <td colspan="2"><b>Intereses: </b><?= $this->utf2html($community->interests) ?></td>
            </tr>
            <tr>
                <td width="300px"><b>Modalidad: </b><?= $this->mode(NULL, $community->mode) ?></td>
                <td><b>Miembros: </b><?= $this->utf2html($community->members) ?></td>
            </tr>
        </table>
    <?php } ?>
    <center><?= $this->paginator($this->communities, $this->route) ?></center>
<?php } else { ?>
<p>No existen communidades registradas</p>
<?php } ?>
