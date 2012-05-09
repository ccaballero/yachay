<h1><?php echo $this->page->label ?></h1>
<p>
    <span class="mark">Dictada por:</span> <?php echo $this->group->getTeacher()->getFullName() ?><br />
    <span class="mark">Grupo:</span> <?php echo $this->group->label ?><br />
    <span class="mark">Materia:</span> <?php echo $this->subject->label ?><br />
    <span class="mark">Gestion:</span> <?php echo $this->gestion->label ?>
</p>

<form method="post" action="" accept-charset="utf-8">
    <input type="hidden" name="return" value="<?php echo $this->currentPage() ?>" />

    <div>
<input type="button" name="new" value="Nuevo" onclick="location.href='<?php echo $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url), 'teams_new') ?>'" /><input type="submit" name="unlock" value="Activar" /><input type="submit" name="lock" value="Desactivar" /><input type="submit" name="delete" value="Eliminar" /><input type="button" name="assign" value="Asignación" onclick="location.href='<?php echo $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url), 'teams_assign') ?>'" />
    </div>

<?php if (count($this->teams)) { ?>
    <table width="100%">
        <tr>
            <th>&nbsp;</th>
            <th><?php echo $this->model_teams->_mapping['label'] ?></th>
            <th><?php echo $this->model_teams->_mapping['status'] ?></th>
            <th>Opciones</th>
            <th><?php echo $this->model_teams->_mapping['tsregister'] ?></th>
        </tr>
    <?php foreach ($this->teams as $key => $team) { ?>
        <tr class="<?php echo $key % 2 == 0 ? 'even' : 'odd' ?>">
            <td><input type="checkbox" name="check[]" value="<?php echo $team->ident ?>" /></td>
            <td><?php echo $team->label ?></td>
            <td class="center">
            <?php if ($team->status == 'active') { ?>
                <img src="<?php echo $this->template->htmlbase . 'images/tick.png' ?>" alt="Grupo activo" title="Equipo activo" />
            <?php } else { ?>
                <img src="<?php echo $this->template->htmlbase . 'images/cross.png' ?>" alt="Grupo inactivo" title="Equipo inactivo" />
            <?php } ?>
            </td>
            <td class="options">
                <a href="<?php echo $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url, 'team' => $team->url), 'teams_team_view') ?>"><img src="<?php echo $this->template->htmlbase . 'images/page_white_text.png' ?>" alt="Ver" title="Ver" /></a>
                <a href="<?php echo $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url, 'team' => $team->url), 'teams_team_edit') ?>"><img src="<?php echo $this->template->htmlbase . 'images/pencil.png' ?>" alt="Editar" title="Editar" /></a>
            <?php if ($team->status == 'inactive') { ?>
                <a href="<?php echo $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url, 'team' => $team->url), 'teams_team_unlock') ?>"><img src="<?php echo $this->template->htmlbase . 'images/lock_open.png' ?>" alt="Activar" title="Activar" /></a>
            <?php } else { ?>
                <a href="<?php echo $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url, 'team' => $team->url), 'teams_team_lock') ?>"><img src="<?php echo $this->template->htmlbase . 'images/lock.png' ?>" alt="Desactivar" title="Desactivar" /></a>
            <?php } ?>
                <a href="<?php echo $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url, 'team' => $team->url), 'teams_team_delete') ?>"><img src="<?php echo $this->template->htmlbase . 'images/delete.png' ?>" alt="Eliminar" title="Eliminar" /></a>
            </td>
            <td class="center"><?php echo $this->timestamp($team->tsregister) ?></td>
        </tr>
    <?php } ?>
    </table>
<?php } else { ?>
    <p>No existen equipos registrados en el grupo</p>
<?php } ?>

    <div>
<input type="button" name="new" value="Nuevo" onclick="location.href='<?php echo $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url), 'teams_new') ?>'" /><input type="submit" name="unlock" value="Activar" /><input type="submit" name="lock" value="Desactivar" /><input type="submit" name="delete" value="Eliminar" /><input type="button" name="assign" value="Asignación" onclick="location.href='<?php echo $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url), 'teams_assign') ?>'" />
    </div>
</form>
