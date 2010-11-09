<h1><?= $this->PAGE->label ?></h1>

<form method="post" action="" accept-charset="utf-8">
    <input type="hidden" name="return" value="<?= $this->currentPage() ?>" />

    <table>
        <tr>
        <?php if ($this->acl('tags', 'list')) { ?>
            <td>[<a href="<?= $this->url(array(), 'tags_list') ?>">Lista</a>]</td>
        <?php } ?>
        <?php if ($this->acl('tags', 'delete')) { ?>
            <td><input type="submit" name="delete" value="Eliminar" /></td>
        <?php } ?>
        </tr>
    </table>

    <hr />
<?php if (count($this->tags)) { ?>
    <table width="100%">
        <tr>
            <th>&nbsp;</th>
            <th><?= $this->model_tags->_mapping['label'] ?></th>
            <th><?= $this->model_tags->_mapping['weight'] ?></th>
            <th>Opciones</th>
            <th><?= $this->model_tags->_mapping['tsregister'] ?></th>
        </tr>
    <?php foreach ($this->tags as $tag) { ?>
        <tr>
            <td><input type="checkbox" name="check[]" value="<?= $tag->ident ?>" /></td>
            <td><?= $tag->label ?></td>
            <td><center><?= $tag->weight ?></center></td>
            <td>
                <center>
                <?php if ($this->acl('tags', 'list')) { ?>
                    <a href="<?= $this->url(array('tag' => $tag->url), 'tags_tag_view') ?>">Ver</a>
                <?php } ?>
                <?php if ($this->acl('tags', 'delete')) { ?>
                    <a href="<?= $this->url(array('tag' => $tag->url), 'tags_tag_delete') ?>">Eliminar</a>
                <?php } ?>
                </center>
            </td>
            <td><center><?= $this->timestamp($tag->tsregister) ?></center></td>
        </tr>
    <?php } ?>
    </table>
<?php } else { ?>
    <p>No existen etiquetas registradas</p>
<?php } ?>
    <hr />

    <table>
        <tr>
        <?php if ($this->acl('tags', 'list')) { ?>
            <td>[<a href="<?= $this->url(array(), 'tags_list') ?>">Lista</a>]</td>
        <?php } ?>
        <?php if ($this->acl('tags', 'delete')) { ?>
            <td><input type="submit" name="delete" value="Eliminar" /></td>
        <?php } ?>
        </tr>
    </table>
</form>
