<h1>Administrador de conjuntos</h1>

<form method="post" action="#">
    <input type="hidden" name="return" value="<?= $this->currentPage() ?>" />

    <table>
        <tr>
            <td><input type="button" value="Nuevo" onclick="location.href='<?= $this->url(array(), 'groupsets_new') ?>'" /></td>
            <td><input type="submit" name="delete" value="Eliminar" /></td>
        </tr>
    </table>

    <hr />
<?php if (count($this->groupsets)) { ?>
    <center>
        <table width="100%">
            <tr>
            	<th>&nbsp;</th>
                <th><?= $this->utf2html($this->model->_mapping['label']) ?></th>
                <th>Opciones</th>
                <th><?= $this->utf2html($this->model->_mapping['tsregister']) ?></th>
            </tr>
        <?php foreach ($this->groupsets as $groupset) { ?>
            <tr>
            	<td><input type="checkbox" name="check[]" value="<?= $groupset->ident ?>" /></td>
                <td><?= $this->utf2html($groupset->label) ?></td>
                <td>
                    <center>
                        <a href="<?= $this->url(array('groupset' => $groupset->ident), 'groupsets_groupset_view') ?>">Ver</a>
                        <a href="<?= $this->url(array('groupset' => $groupset->ident), 'groupsets_groupset_edit') ?>">Editar</a>
                        <a href="<?= $this->url(array('groupset' => $groupset->ident), 'groupsets_groupset_delete') ?>">Eliminar</a>
                    </center>
                </td>
                <td><center><?= $this->timestamp($groupset->tsregister) ?></center></td>
            </tr>
        <?php } ?>
        </table>
    </center>
<?php } else { ?>
    <p>No existen conjuntos registradas</p>
<?php } ?>
    <hr />

    <table>
        <tr>
            <td><input type="button" value="Nuevo" onclick="location.href='<?= $this->url(array(), 'groupsets_new') ?>'" /></td>
            <td><input type="submit" name="delete" value="Eliminar" /></td>
        </tr>
    </table>
</form>
