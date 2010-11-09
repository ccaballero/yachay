<h1><?= $this->PAGE->label ?></h1>

<?php if (count($this->communities)) { ?>
    <center><?= $this->paginator($this->communities, $this->route) ?></center>
    <?php foreach ($this->communities as $community) { ?>
        <table width="100%">
            <tr>
                <td colspan="2">
                    <?php if ($this->acl('communities', 'view')) { ?>
                    <a href="<?= $this->url(array('community' => $community->url), 'communities_community_view') ?>">
                        <b><?= $community->label ?></b>
                    </a>
                    <?php } else { ?>
                        <b><?= $community->label ?></b>
                    <?php } ?>
                    &nbsp;
                    <?php if ($community->amAuthor()) { ?>
                        <b><i>[<a href="<?= $this->url(array('community' => $community->url), 'communities_community_edit') ?>">Editar</a>]</i></b>
                    <?php } ?>
                    <?php if ($this->acl('communities', 'enter')) { ?>
                        <?php if (!$community->amModerator() && !$community->amMember()) { ?>
                            [<a href="<?= $this->url(array('community' => $community->url), 'communities_community_join') ?>">Unirse</a>]
                        <?php } else if (!$community->amAuthor()) { ?>
                            [<a href="<?= $this->url(array('community' => $community->url), 'communities_community_leave') ?>">Retirarse</a>]
                        <?php } ?>
                    <?php } ?>
                </td>
            </tr>
            <tr>
                <td colspan="2"><b>Descripción: </b><?= $community->description ?></td>
            </tr>
            <tr>
                <td colspan="2">
                    <b>Etiquetas: </b>
                <?php
                    $tags = $community->getTags();
                    foreach ($tags as $tag) { ?>
                        <a href="<?= $this->url(array('tag' => $tag->url), 'tags_tag_view') ?>"><i><?= $tag->label ?></i></a>&nbsp;
                <?php } ?>
                </td>
            </tr>
            <tr>
                <td width="300px"><b>Modalidad: </b><?= $this->mode(NULL, $community->mode) ?></td>
                <td><b>Miembros: </b><?= $community->members ?></td>
            </tr>
        </table>
    <?php } ?>
    <center><?= $this->paginator($this->communities, $this->route) ?></center>
<?php } else { ?>
<p>No existen communidades registradas</p>
<?php } ?>
