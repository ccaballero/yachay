<h1><?php echo $this->route->label ?></h1>

<form method="post" action="" accept-charset="utf-8">
    <input type="hidden" name="return" value="<?php echo $this->currentPage() ?>" />

    <div>
<?php if ($this->acl('feedback', 'list')) { ?><input type="button" name="list" value="Lista" onclick="location.href='<?php echo $this->url(array(), 'feedback_list') ?>'" /><?php } ?>
<?php if ($this->acl('feedback', 'new')) { ?><input type="button" name="new" value="Nuevo" onclick="location.href='<?php echo $this->url(array(), 'feedback_new') ?>'" /><?php } ?>
<input type="submit" name="mark" value="Marcar" /><input type="submit" name="unmark" value="Desmarcar" /><input type="submit" name="resolv" value="Resuelto" /><input type="submit" name="unresolv" value="No resuelto" /><input type="submit" name="delete" value="Eliminar" />
    </div>

<?php if (count($this->feedback)) { ?>
    <table>
        <tr>
            <th>&nbsp;</th>
            <th><?php echo $this->model_feedback->_mapping['description'] ?></th>
            <th>Estado</th>
            <th>Opciones</th>
            <th><?php echo $this->model_feedback->_mapping['tsregister'] ?></th>
        </tr>
    <?php foreach ($this->feedback as $key => $entry) { ?>
        <tr class="<?php echo $key % 2 == 0 ? 'even' : 'odd' ?>">
            <td><input type="checkbox" name="check[]" value="<?php echo $entry->resource ?>" /></td>
            <td><?php echo $this->wrapper($entry->description, 8) ?></td>
            <td class="center">
                <?php if ($entry->mark) { ?><img src="<?php echo $this->template->htmlbase . 'images/heart.png' ?>" alt="Problema en seguimiento" title="Problema en seguimiento" /><?php } ?>
                <?php if ($entry->resolved) { ?><img src="<?php echo $this->template->htmlbase . 'images/lightbulb.png' ?>" alt="Problema resuelto" title="Problema resuelto" /><?php } ?>
            </td>
            <td class="options">
                <a href="<?php echo $this->url(array('entry' => $entry->resource), 'feedback_entry_view') ?>"><img src="<?php echo $this->template->htmlbase . 'images/page_white_text.png' ?>" alt="Ver" title="Ver" /></a>
                <?php if ($entry->resolved) { ?>
                    <a href="<?php echo $this->url(array('entry' => $entry->resource), 'feedback_entry_unresolv') ?>"><img src="<?php echo $this->template->htmlbase . 'images/lightbulb_delete.png' ?>" alt="Marcar como no resuelto" title="Marcar como no resuelto" /></a>
                <?php } else { ?>
                    <a href="<?php echo $this->url(array('entry' => $entry->resource), 'feedback_entry_resolv') ?>"><img src="<?php echo $this->template->htmlbase . 'images/lightbulb_add.png' ?>" alt="Marcar como resuelto" title="Marcar como resuelto" /></a>
                <?php } ?>
                <?php if ($entry->mark) { ?>
                    <a href="<?php echo $this->url(array('entry' => $entry->resource), 'feedback_entry_unmark') ?>"><img src="<?php echo $this->template->htmlbase . 'images/heart_delete.png' ?>" alt="Desmarcar como favorito" title="Desmarcar como favorito" /></a>
                <?php } else { ?>
                    <a href="<?php echo $this->url(array('entry' => $entry->resource), 'feedback_entry_mark') ?>"><img src="<?php echo $this->template->htmlbase . 'images/heart_add.png' ?>" alt="Marcar como favorito" title="Marcar como favorito" /></a>
                <?php } ?>
                <a href="<?php echo $this->url(array('entry' => $entry->resource), 'feedback_entry_drop') ?>"><img src="<?php echo $this->template->htmlbase . 'images/delete.png' ?>" alt="Eliminar" title="Eliminar" /></a>
            </td>
            <td class="center"><?php echo $this->timestamp($entry->getResource()->tsregister) ?></td>
        </tr>
    <?php } ?>
    </table>
<?php } else { ?>
    <p>No existen sugerencias</p>
<?php } ?>

    <div>
<?php if ($this->acl('feedback', 'list')) { ?><input type="button" name="list" value="Lista" onclick="location.href='<?php echo $this->url(array(), 'feedback_list') ?>'" /><?php } ?>
<?php if ($this->acl('feedback', 'new')) { ?><input type="button" name="new" value="Nuevo" onclick="location.href='<?php echo $this->url(array(), 'feedback_new') ?>'" /><?php } ?>
<input type="submit" name="mark" value="Marcar" /><input type="submit" name="unmark" value="Desmarcar" /><input type="submit" name="resolv" value="Resuelto" /><input type="submit" name="unresolv" value="No resuelto" /><input type="submit" name="delete" value="Eliminar" />
    </div>
</form>
