<h1><?php echo $this->page->label ?></h1>

<form method="post" action="" accept-charset="utf-8">
    <input type="hidden" name="return" value="<?php echo $this->currentPage() ?>" />

    <div>
<?php if ($this->acl('tags', 'list')) { ?><input type="button" name="list" value="Lista" onclick="location.href='<?php echo $this->url(array(), 'tags_list') ?>'" /><?php } ?>
<?php if ($this->acl('tags', 'delete')) { ?><input type="submit" name="delete" value="Eliminar" /><?php } ?>
    </div>

<?php if (count($this->tags)) { ?>
    <table>
        <tr>
            <th>&nbsp;</th>
            <th><?php echo $this->model_tags->_mapping['label'] ?></th>
            <th><?php echo $this->model_tags->_mapping['weight'] ?></th>
            <th>Opciones</th>
            <th><?php echo $this->model_tags->_mapping['tsregister'] ?></th>
        </tr>
    <?php foreach ($this->tags as $key => $tag) { ?>
        <tr class="<?php echo $key % 2 == 0 ? 'even' : 'odd' ?>">
            <td><input type="checkbox" name="check[]" value="<?php echo $tag->ident ?>" /></td>
            <td><?php echo $tag->label ?></td>
            <td class="center"><?php echo $tag->weight ?></td>
            <td class="options">
                <?php if ($this->acl('tags', 'list')) { ?>
                    <a href="<?php echo $this->url(array('tag' => $tag->url), 'tags_tag_view') ?>"><img src="<?php echo $this->template->htmlbase . 'images/page_white_text.png' ?>" alt="Ver" title="Ver" /></a>
                <?php } ?>
                <?php if ($this->acl('tags', 'delete')) { ?>
                    <a href="<?php echo $this->url(array('tag' => $tag->url), 'tags_tag_delete') ?>"><img src="<?php echo $this->template->htmlbase . 'images/delete.png' ?>" alt="Eliminar" title="Eliminar" /></a>
                <?php } ?>
            </td>
            <td class="center"><?php echo $this->timestamp($tag->tsregister) ?></td>
        </tr>
    <?php } ?>
    </table>
<?php } else { ?>
    <p>No existen etiquetas registradas</p>
<?php } ?>

    <div>
<?php if ($this->acl('tags', 'list')) { ?><input type="button" name="list" value="Lista" onclick="location.href='<?php echo $this->url(array(), 'tags_list') ?>'" /><?php } ?>
<?php if ($this->acl('tags', 'delete')) { ?><input type="submit" name="delete" value="Eliminar" /><?php } ?>
    </div>
</form>
