<h1><?= $this->PAGE->label ?></h1>
<p>
    <span class="mark">Dictada por:</span> <?= $this->group->getTeacher()->getFullName() ?><br />
    <span class="mark">Grupo:</span> <?= $this->group->label ?><br />
    <span class="mark">Materia:</span> <?= $this->subject->label ?><br />
    <span class="mark">Gestion:</span> <?= $this->gestion->label ?>
</p>

<form method="post" action="" accept-charset="utf-8">
    <input type="hidden" name="return" value="<?= $this->currentPage() ?>" />

    <div>
<input type="button" name="new" value="Nuevo" onclick="location.href='<?= $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url), 'teams_new') ?>'" /><input type="submit" name="unlock" value="Activar" /><input type="submit" name="lock" value="Desactivar" /><input type="submit" name="delete" value="Eliminar" /><input type="button" name="assign" value="Asignación" onclick="location.href='<?= $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url), 'teams_assign') ?>'" />
    </div>

<?php if (count($this->teams)) { ?>
    <table width="100%">
        <tr>
            <th>&nbsp;</th>
            <th><?= $this->model_teams->_mapping['label'] ?></th>
            <th><?= $this->model_teams->_mapping['status'] ?></th>
            <th>Opciones</th>
            <th><?= $this->model_teams->_mapping['tsregister'] ?></th>
        </tr>
    <?php foreach ($this->teams as $key => $team) { ?>
        <tr class="<?= $key % 2 == 0 ? 'even' : 'odd' ?>">
            <td><input type="checkbox" name="check[]" value="<?= $team->ident ?>" /></td>
            <td><?= $team->label ?></td>
            <td class="center">
            <?php if ($team->status == 'active') { ?>
                <img src="<?= $this->TEMPLATE->htmlbase . 'images/tick.png' ?>" alt="Grupo activo" title="Equipo activo" />
            <?php } else { ?>
                <img src="<?= $this->TEMPLATE->htmlbase . 'images/cross.png' ?>" alt="Grupo inactivo" title="Equipo inactivo" />
            <?php } ?>
            </td>
            <td class="options">
                <a href="<?= $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url, 'team' => $team->url), 'teams_team_view') ?>"><img src="<?= $this->TEMPLATE->htmlbase . 'images/page_white_text.png' ?>" alt="Ver" title="Ver" /></a>
                <a href="<?= $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url, 'team' => $team->url), 'teams_team_edit') ?>"><img src="<?= $this->TEMPLATE->htmlbase . 'images/pencil.png' ?>" alt="Editar" title="Editar" /></a>
            <?php if ($team->status == 'inactive') { ?>
                <a href="<?= $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url, 'team' => $team->url), 'teams_team_unlock') ?>"><img src="<?= $this->TEMPLATE->htmlbase . 'images/lock_open.png' ?>" alt="Activar" title="Activar" /></a>
            <?php } else { ?>
                <a href="<?= $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url, 'team' => $team->url), 'teams_team_lock') ?>"><img src="<?= $this->TEMPLATE->htmlbase . 'images/lock.png' ?>" alt="Desactivar" title="Desactivar" /></a>
            <?php } ?>
                <a href="<?= $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url, 'team' => $team->url), 'teams_team_delete') ?>"><img src="<?= $this->TEMPLATE->htmlbase . 'images/delete.png' ?>" alt="Eliminar" title="Eliminar" /></a>
            </td>
            <td class="center"><?= $this->timestamp($team->tsregister) ?></td>
        </tr>
    <?php } ?>
    </table>
<?php } else { ?>
    <p>No existen equipos registrados en el grupo</p>
<?php } ?>

    <div>
<input type="button" name="new" value="Nuevo" onclick="location.href='<?= $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url), 'teams_new') ?>'" /><input type="submit" name="unlock" value="Activar" /><input type="submit" name="lock" value="Desactivar" /><input type="submit" name="delete" value="Eliminar" /><input type="button" name="assign" value="Asignación" onclick="location.href='<?= $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url), 'teams_assign') ?>'" />
    </div>
</form>
