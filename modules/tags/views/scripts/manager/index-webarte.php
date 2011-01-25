<h1><?= $this->PAGE->label ?></h1>

<form method="post" action="" accept-charset="utf-8">
    <input type="hidden" name="return" value="<?= $this->currentPage() ?>" />

    <div>
<?php if ($this->acl('tags', 'list')) { ?><input type="button" name="list" value="Lista" onclick="location.href='<?= $this->url(array(), 'tags_list') ?>'" /><?php } ?>
<?php if ($this->acl('tags', 'delete')) { ?><input type="submit" name="delete" value="Eliminar" /><?php } ?>
    </div>

<?php if (count($this->tags)) { ?>
    <table>
        <tr>
            <th>&nbsp;</th>
            <th><?= $this->model_tags->_mapping['label'] ?></th>
            <th><?= $this->model_tags->_mapping['weight'] ?></th>
            <th>Opciones</th>
            <th><?= $this->model_tags->_mapping['tsregister'] ?></th>
        </tr>
    <?php foreach ($this->tags as $key => $tag) { ?>
        <tr class="<?= $key % 2 == 0 ? 'even' : 'odd' ?>">
            <td><input type="checkbox" name="check[]" value="<?= $tag->ident ?>" /></td>
            <td><?= $tag->label ?></td>
            <td class="center"><?= $tag->weight ?></td>
            <td class="options">
                <?php if ($this->acl('tags', 'list')) { ?>
                    <a href="<?= $this->url(array('tag' => $tag->url), 'tags_tag_view') ?>"><img src="<?= $this->TEMPLATE->htmlbase . 'images/page_white_text.png' ?>" alt="Ver" title="Ver" /></a>
                <?php } ?>
                <?php if ($this->acl('tags', 'delete')) { ?>
                    <a href="<?= $this->url(array('tag' => $tag->url), 'tags_tag_delete') ?>"><img src="<?= $this->TEMPLATE->htmlbase . 'images/delete.png' ?>" alt="Eliminar" title="Eliminar" /></a>
                <?php } ?>
            </td>
            <td class="center"><?= $this->timestamp($tag->tsregister) ?></td>
        </tr>
    <?php } ?>
    </table>
<?php } else { ?>
    <p>No existen etiquetas registradas</p>
<?php } ?>

    <div>
<?php if ($this->acl('tags', 'list')) { ?><input type="button" name="list" value="Lista" onclick="location.href='<?= $this->url(array(), 'tags_list') ?>'" /><?php } ?>
<?php if ($this->acl('tags', 'delete')) { ?><input type="submit" name="delete" value="Eliminar" /><?php } ?>
    </div>
</form>
