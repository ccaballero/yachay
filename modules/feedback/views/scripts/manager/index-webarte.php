<h1><?= $this->PAGE->label ?></h1>

<form method="post" action="" accept-charset="utf-8">
    <input type="hidden" name="return" value="<?= $this->currentPage() ?>" />

    <div>
<?php if ($this->acl('feedback', 'list')) { ?><input type="button" name="list" value="Lista" onclick="location.href='<?= $this->url(array(), 'feedback_list') ?>'" /><?php } ?>
<?php if ($this->acl('feedback', 'new')) { ?><input type="button" name="new" value="Nuevo" onclick="location.href='<?= $this->url(array(), 'feedback_new') ?>'" /><?php } ?>
<input type="submit" name="mark" value="Marcar" /><input type="submit" name="unmark" value="Desmarcar" /><input type="submit" name="resolv" value="Resuelto" /><input type="submit" name="unresolv" value="No resuelto" /><input type="submit" name="delete" value="Eliminar" />
    </div>

<?php if (count($this->feedback)) { ?>
    <table>
        <tr>
            <th>&nbsp;</th>
            <th><?= $this->model_feedback->_mapping['description'] ?></th>
            <th>&nbsp;</th>
            <th>Opciones</th>
            <th><?= $this->model_feedback->_mapping['tsregister'] ?></th>
        </tr>
    <?php foreach ($this->feedback as $key => $entry) { ?>
        <tr class="<?= $key % 2 == 0 ? 'even' : 'odd' ?>">
            <td><input type="checkbox" name="check[]" value="<?= $entry->resource ?>" /></td>
            <td><?= $this->wrapper($entry->description, 8) ?></td>
            <td class="center">
                <?php if ($entry->mark) { ?><img src="<?= $this->TEMPLATE->htmlbase . 'images/heart.png' ?>" alt="Problema en seguimiento" title="Problema en seguimiento" /><?php } ?>
                <?php if ($entry->resolved) { ?><img src="<?= $this->TEMPLATE->htmlbase . 'images/lightbulb.png' ?>" alt="Problema resuelto" title="Problema resuelto" /><?php } ?>
            </td>
            <td class="options">
                <a href="<?= $this->url(array('entry' => $entry->resource), 'feedback_entry_view') ?>"><img src="<?= $this->TEMPLATE->htmlbase . 'images/page_white_text.png' ?>" alt="Ver" title="Ver" /></a>
                <?php if ($entry->resolved) { ?>
                    <a href="<?= $this->url(array('entry' => $entry->resource), 'feedback_entry_unresolv') ?>"><img src="<?= $this->TEMPLATE->htmlbase . 'images/lightbulb_delete.png' ?>" alt="Marcar como no resuelto" title="Marcar como no resuelto" /></a>
                <?php } else { ?>
                    <a href="<?= $this->url(array('entry' => $entry->resource), 'feedback_entry_resolv') ?>"><img src="<?= $this->TEMPLATE->htmlbase . 'images/lightbulb_add.png' ?>" alt="Marcar como resuelto" title="Marcar como resuelto" /></a>
                <?php } ?>
                <?php if ($entry->mark) { ?>
                    <a href="<?= $this->url(array('entry' => $entry->resource), 'feedback_entry_unmark') ?>"><img src="<?= $this->TEMPLATE->htmlbase . 'images/heart_delete.png' ?>" alt="Desmarcar como favorito" title="Desmarcar como favorito" /></a>
                <?php } else { ?>
                    <a href="<?= $this->url(array('entry' => $entry->resource), 'feedback_entry_mark') ?>"><img src="<?= $this->TEMPLATE->htmlbase . 'images/heart_add.png' ?>" alt="Marcar como favorito" title="Marcar como favorito" /></a>
                <?php } ?>
                <a href="<?= $this->url(array('entry' => $entry->resource), 'feedback_entry_drop') ?>"><img src="<?= $this->TEMPLATE->htmlbase . 'images/delete.png' ?>" alt="Eliminar" title="Eliminar" /></a>
            </td>
            <td class="center"><?= $this->timestamp($entry->getResource()->tsregister) ?></td>
        </tr>
    <?php } ?>
    </table>
<?php } else { ?>
    <p>No existen sugerencias</p>
<?php } ?>

    <div>
<?php if ($this->acl('feedback', 'list')) { ?><input type="button" name="list" value="Lista" onclick="location.href='<?= $this->url(array(), 'feedback_list') ?>'" /><?php } ?>
<?php if ($this->acl('feedback', 'new')) { ?><input type="button" name="new" value="Nuevo" onclick="location.href='<?= $this->url(array(), 'feedback_new') ?>'" /><?php } ?>
<input type="submit" name="mark" value="Marcar" /><input type="submit" name="unmark" value="Desmarcar" /><input type="submit" name="resolv" value="Resuelto" /><input type="submit" name="unresolv" value="No resuelto" /><input type="submit" name="delete" value="Eliminar" />
    </div>
</form>
