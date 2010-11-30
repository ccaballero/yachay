<h1><?= $this->PAGE->label ?></h1>

<p>
    <span class="mark">Materia:</span>
    <?= $this->subject->label ?>
    <br />
    <span class="mark">Gestion:</span>
    <?= $this->gestion->label ?>
</p>

<form method="post" action="" accept-charset="utf-8">
    <input type="hidden" name="return" value="<?= $this->currentPage() ?>" />

    <div>
<input type="button" name="new" value="Nuevo" onclick="location.href='<?= $this->url(array('subject' => $this->subject->url), 'groups_new') ?>'" /><input type="submit" name="unlock" value="Activar" /><input type="submit" name="lock" value="Desactivar" /><input type="submit" name="delete" value="Eliminar" />
    </div>

<?php if (count($this->groups)) { ?>
    <table width="100%">
        <tr>
            <th>&nbsp;</th>
            <th><?= $this->model_groups->_mapping['label'] ?></th>
            <th><?= $this->model_groups->_mapping['status'] ?></th>
            <th>Opciones</th>
            <th><?= $this->model_groups->_mapping['tsregister'] ?></th>
        </tr>
    <?php foreach ($this->groups as $key => $group) { ?>
        <tr class="<?= $key % 2 == 0 ? 'even' : 'odd' ?>">
            <td>
                <input type="checkbox" name="check[]" value="<?= $group->ident ?>" />
            </td>
            <td class="center"><?= $group->label ?></td>
            <td class="center">
            <?php if ($group->status == 'active') { ?>
                <img src="<?= $this->TEMPLATE->htmlbase . 'images/tick.png' ?>" alt="Grupo activo" title="Grupo activo" />
            <?php } else { ?>
                <img src="<?= $this->TEMPLATE->htmlbase . 'images/cross.png' ?>" alt="Grupo inactivo" title="Grupo inactivo" />
            <?php } ?>
            </td>
            <td class="center">
                <a href="<?= $this->url(array('subject' => $this->subject->url, 'group' => $group->url), 'groups_group_view') ?>"><img src="<?= $this->TEMPLATE->htmlbase . 'images/page_white_text.png' ?>" alt="Ver" title="Ver" /></a>
                <a href="<?= $this->url(array('subject' => $this->subject->url, 'group' => $group->url), 'groups_group_edit') ?>"><img src="<?= $this->TEMPLATE->htmlbase . 'images/pencil.png' ?>" alt="Editar" title="Editar" /></a>
            <?php if ($group->status == 'inactive') { ?>
                <a href="<?= $this->url(array('subject' => $this->subject->url, 'group' => $group->url), 'groups_group_unlock') ?>"><img src="<?= $this->TEMPLATE->htmlbase . 'images/lock_open.png' ?>" alt="Activar" title="Activar" /></a>
            <?php } else { ?>
                <a href="<?= $this->url(array('subject' => $this->subject->url, 'group' => $group->url), 'groups_group_lock') ?>"><img src="<?= $this->TEMPLATE->htmlbase . 'images/lock.png' ?>" alt="Desactivar" title="Desactivar" /></a>
            <?php } ?>
                <a href="<?= $this->url(array('subject' => $this->subject->url, 'group' => $group->url), 'groups_group_delete') ?>"><img src="<?= $this->TEMPLATE->htmlbase . 'images/delete.png' ?>" alt="Eliminar" title="Eliminar" /></a>
            </td>
            <td class="center"><?= $this->timestamp($group->tsregister) ?></td>
        </tr>
    <?php } ?>
    </table>
<?php } else { ?>
    <p>No existen grupos registrados en la materia</p>
<?php } ?>

    <div>
<input type="button" name="new" value="Nuevo" onclick="location.href='<?= $this->url(array('subject' => $this->subject->url), 'groups_new') ?>'" /><input type="submit" name="unlock" value="Activar" /><input type="submit" name="lock" value="Desactivar" /><input type="submit" name="delete" value="Eliminar" />
    </div>
</form>
