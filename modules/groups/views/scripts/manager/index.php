<h1>Administrador de grupos</h1>
<i><b>Materia: </b><?= $this->utf2html($this->subject->label) ?></i>
<br />
<i><b>Gestion: </b><?= $this->utf2html($this->gestion->label) ?></i>

<form method="post" action="#">
    <input type="hidden" name="return" value="<?= $this->currentPage() ?>" />
    <table>
        <tr>
            <td><input type="button" value="Nuevo" onclick="location.href='<?= $this->url(array('subject' => $this->subject->url), 'groups_new') ?>'" /></td>
            <td><input type="submit" value="Activar" name="unlock" /></td>
            <td><input type="submit" value="Desactivar" name="lock" /></td>
            <td><input type="submit" value="Eliminar" name="delete" /></td>
        </tr>
    </table>

    <hr />
<?php if (count($this->groups)) { ?>
    <center>
        <table width="100%">
            <tr>
                <th>&nbsp;</th>
                <th><?= $this->utf2html($this->model->_mapping['label']) ?></th>
                <th>Opciones</th>
                <th><?= $this->utf2html($this->model->_mapping['tsregister']) ?></th>
            </tr>
        <?php foreach ($this->groups as $group) { ?>
            <tr>
                <td>
                    <input type="checkbox" name="check[]" value="<?= $group->ident ?>" />
                </td>
                <td><?= $this->utf2html($group->label) ?></td>
                <td>
                    <center>
                    <a href="<?= $this->url(array('subject' => $this->subject->url, 'group' => $group->url), 'groups_group_view') ?>">Ver</a>
                    <a href="<?= $this->url(array('subject' => $this->subject->url, 'group' => $group->url), 'groups_group_edit') ?>">Editar</a>
                <?php if ($group->status == 'inactive') { ?>
                    <a href="<?= $this->url(array('subject' => $this->subject->url, 'group' => $group->url), 'groups_group_unlock') ?>">Activar</a>
                <?php } else { ?>
                    <a href="<?= $this->url(array('subject' => $this->subject->url, 'group' => $group->url), 'groups_group_lock') ?>">Desactivar</a>
                <?php } ?>
                    <a href="<?= $this->url(array('subject' => $this->subject->url, 'group' => $group->url), 'groups_group_delete') ?>">Eliminar</a>
                    </center>
                </td>
                <td><center><?= $this->timestamp($group->tsregister) ?></center></td>
            </tr>
        <?php } ?>
        </table>
    </center>
<?php } else { ?>
    <p>No existen grupos registrados en la materia</p>
<?php } ?>
    <hr />

    <table>
        <tr>
            <td><input type="button" value="Nuevo" onclick="location.href='<?= $this->url(array('subject' => $this->subject->url), 'groups_new') ?>'" /></td>
            <td><input type="submit" value="Activar" name="unlock" /></td>
            <td><input type="submit" value="Desactivar" name="lock" /></td>
            <td><input type="submit" value="Eliminar" name="delete" /></td>
        </tr>
    </table>
</form>
