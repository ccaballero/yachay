<h1><?= $this->PAGE->label ?></h1>

<form method="post" action="" accept-charset="utf-8">
    <input type="hidden" name="return" value="<?= $this->currentPage() ?>" />

    <div>
<input type="button" name="new" value="Nuevo" onclick="location.href='<?= $this->url(array(), 'groupsets_new') ?>'" /><input type="submit" name="delete" value="Eliminar" />
    </div>

<?php if (count($this->groupsets)) { ?>
    <table>
        <tr>
            <th>&nbsp;</th>
            <th><?= $this->model_groupsets->_mapping['label'] ?></th>
            <th>Opciones</th>
            <th><?= $this->model_groupsets->_mapping['tsregister'] ?></th>
        </tr>
    <?php foreach ($this->groupsets as $key => $groupset) { ?>
        <tr class="<?= $key % 2 == 0 ? 'even' : 'odd' ?>">
            <td><input type="checkbox" name="check[]" value="<?= $groupset->ident ?>" /></td>
            <td><?= $groupset->label ?></td>
            <td class="options">
                <a href="<?= $this->url(array('groupset' => $groupset->ident), 'groupsets_groupset_view') ?>"><img src="<?= $this->TEMPLATE->htmlbase . 'images/page_white_text.png' ?>" alt="Ver" title="Ver" /></a>
                <a href="<?= $this->url(array('groupset' => $groupset->ident), 'groupsets_groupset_edit') ?>"><img src="<?= $this->TEMPLATE->htmlbase . 'images/pencil.png' ?>" alt="Editar" title="Editar" /></a>
                <a href="<?= $this->url(array('groupset' => $groupset->ident), 'groupsets_groupset_delete') ?>"><img src="<?= $this->TEMPLATE->htmlbase . 'images/delete.png' ?>" alt="Eliminar" title="Eliminar" /></a>
            </td>
            <td class="center"><?= $this->timestamp($groupset->tsregister) ?></td>
        </tr>
    <?php } ?>
    </table>
<?php } else { ?>
    <p>No existen conjuntos registradas</p>
<?php } ?>

    <div>
<input type="button" name="new" value="Nuevo" onclick="location.href='<?= $this->url(array(), 'groupsets_new') ?>'" /><input type="submit" name="delete" value="Eliminar" />
    </div>
</form>
