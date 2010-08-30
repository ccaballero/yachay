<h1>Administrador de equipos</h1>
<b>Grupo: </b><i><?= $this->utf2html($this->group->label) ?></i>
<br />
<b>Materia: </b><i><?= $this->utf2html($this->subject->label) ?></i>

<form method="post" action="">
    <input type="hidden" name="return" value="<?= $this->currentPage() ?>" />
    <table>
        <tr>
            <td><input type="button" value="Nuevo" onclick="location.href='<?= $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url), 'teams_new') ?>'" /></td>
            <td><input type="submit" value="Activar" name="unlock" /></td>
            <td><input type="submit" value="Desactivar" name="lock" /></td>
            <td><input type="submit" value="Eliminar" name="delete" /></td>
            <td><input type="button" value="Asignacion" onclick="location.href='<?= $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url), 'teams_assign') ?>'" /></td>
        </tr>
    </table>

    <hr />
<?php if (count($this->teams)) { ?>
    <center>
        <table width="100%">
            <tr>
                <th>&nbsp;</th>
                <th><?= $this->utf2html($this->model->_mapping['label']) ?></th>
                <th><?= $this->utf2html($this->model->_mapping['status']) ?></th>
                <th>Opciones</th>
                <th><?= $this->utf2html($this->model->_mapping['tsregister']) ?></th>
            </tr>
        <?php foreach ($this->teams as $team) { ?>
            <tr>
                <td>
                    <input type="checkbox" name="check[]" value="<?= $team->ident ?>" />
                </td>
                <td><?= $this->utf2html($team->label) ?></td>
                <td><?= $this->status($team->status) ?></td>
                <td>
                    <center>
                    <a href="<?= $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url, 'team' => $team->url), 'teams_team_view') ?>">Ver</a>
                    <a href="<?= $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url, 'team' => $team->url), 'teams_team_edit') ?>">Editar</a>
                <?php if ($team->status == 'inactive') { ?>
                    <a href="<?= $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url, 'team' => $team->url), 'teams_team_unlock') ?>">Activar</a>
                <?php } else { ?>
                    <a href="<?= $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url, 'team' => $team->url), 'teams_team_lock') ?>">Desactivar</a>
                <?php } ?>
                    <a href="<?= $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url, 'team' => $team->url), 'teams_team_delete') ?>">Eliminar</a>
                    </center>
                </td>
                <td><center><?= $this->timestamp($team->tsregister) ?></center></td>
            </tr>
        <?php } ?>
        </table>
    </center>
<?php } else { ?>
    <p>No existen equipos registrados en el grupo</p>
<?php } ?>
    <hr />

    <table>
        <tr>
            <td><input type="button" value="Nuevo" onclick="location.href='<?= $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url), 'teams_new') ?>'" /></td>
            <td><input type="submit" value="Activar" name="unlock" /></td>
            <td><input type="submit" value="Desactivar" name="lock" /></td>
            <td><input type="submit" value="Eliminar" name="delete" /></td>
            <td><input type="button" value="Asignacion" onclick="location.href='<?= $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url), 'teams_assign') ?>'" /></td>
        </tr>
    </table>
</form>
