<h1>Administrador de sugerencias</h1>

<form method="post" action="" accept-charset="utf-8">
    <input type="hidden" name="return" value="<?= $this->currentPage() ?>" />

    <table>
        <tr>
            <td>[<a href="<?= $this->url(array(), 'feedback_new') ?>">Nuevo</a>]</td>
            <td><input type="submit" name="mark" value="Marcar" /></td>
            <td><input type="submit" name="unmark" value="Desmarcar" /></td>
            <td><input type="submit" name="resolv" value="Resuelto" /></td>
            <td><input type="submit" name="unresolv" value="No resuelto" /></td>
            <td><input type="submit" name="delete" value="Eliminar" /></td>
        </tr>
    </table>

    <hr />
<?php if (count($this->feedback)) { ?>
    <table width="100%">
        <tr>
            <th>&nbsp;</th>
            <th><?= $this->model->_mapping['description'] ?></th>
            <th>Opciones</th>
            <th><?= $this->model->_mapping['tsregister'] ?></th>
        </tr>
    <?php foreach ($this->feedback as $entry) { ?>
        <tr>
            <td><input type="checkbox" name="check[]" value="<?= $entry->resource ?>" /></td>
            <td><?= $this->wrapper($entry->description) ?></td>
            <td>
                <center>
                    <a href="<?= $this->url(array('entry' => $entry->resource), 'feedback_entry_view') ?>">Ver</a>
                <?php if ($entry->resolved) { ?>
                    <a href="<?= $this->url(array('entry' => $entry->resource), 'feedback_entry_unresolv') ?>">No resuelto</a>
                <?php } else { ?>
                    <a href="<?= $this->url(array('entry' => $entry->resource), 'feedback_entry_resolv') ?>">Resuelto</a>
                <?php } ?>
                <?php if ($entry->mark) { ?>
                    <a href="<?= $this->url(array('entry' => $entry->resource), 'feedback_entry_unmark') ?>">Desmarcar</a>
                <?php } else { ?>
                    <a href="<?= $this->url(array('entry' => $entry->resource), 'feedback_entry_mark') ?>">Marcar</a>
                <?php } ?>
                    <a href="<?= $this->url(array('entry' => $entry->resource), 'feedback_entry_drop') ?>">Eliminar</a>
                </center>
            </td>
            <td><center><?= $this->timestamp($entry->getResource()->tsregister) ?></center></td>
        </tr>
    <?php } ?>
    </table>
<?php } else { ?>
    <p>No existen sugerencias</p>
<?php } ?>
    <hr />

    <table>
        <tr>
            <td>[<a href="<?= $this->url(array(), 'feedback_new') ?>">Nuevo</a>]</td>
            <td><input type="submit" name="mark" value="Marcar" /></td>
            <td><input type="submit" name="unmark" value="Desmarcar" /></td>
            <td><input type="submit" name="resolv" value="Resuelto" /></td>
            <td><input type="submit" name="unresolv" value="No resuelto" /></td>
            <td><input type="submit" name="delete" value="Eliminar" /></td>
        </tr>
    </table>
</form>
