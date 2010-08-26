<h1>Lista de comunidades</h1>

<?php if (count($this->communities)) { ?>
    <center><?= $this->paginator($this->communities, $this->route) ?></center>
    <?php foreach ($this->communities as $community) { ?>
        <table>
            <tr>
                <td rowspan="5" width="100px">
                    <img src="<?= $this->media . 'thumbnail_medium/' . $community->getAvatar() ?>" />
                </td>
                <td colspan="4">
                    <?php if (Yeah_Acl::hasPermission('communities', 'view')) { ?>
                    <a href="<?= $this->url(array('community' => $community->url), 'communities_community_view') ?>">
                        <b><?= $this->utf2html($community->label) ?></b>
                    </a>
                    <?php } else { ?>
                        <b><?= $this->utf2html($community->label) ?></b>
                    <?php } ?>
                    &nbsp;
                    <?php global $USER; ?>
                    <?php if ($community->author == $USER->ident) { ?>
                    <a href="<?= $this->url(array('community' => $community->url), 'communities_community_edit') ?>">
                        <b><i>[Editar]</i></b>
                    </a>
                    <?php } ?>
                </td>
            </tr>
            <tr>
                <td colspan="4"><b>Descripci&oacute;n: </b><?= $this->utf2html($community->description) ?></td>
            </tr>
            <tr>
                <td colspan="4"><b>Miembros: </b><?= $this->utf2html($community->members) ?></td>
            </tr>
        </table>
    <?php } ?>
    <center><?= $this->paginator($this->communities, $this->route) ?></center>
<?php } else { ?>
<p>No existen communidades registradas</p>
<?php } ?>
