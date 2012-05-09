<h1>Calificaciones: Grupo <?php echo $this->group->label ?>
<strong class="task">
<?php if ($this->group->status == 'active') { ?>
    <img src="<?php echo $this->template->htmlbase . 'images/tick.png' ?>" alt="Grupo activo" title="Grupo activo" />
<?php } else { ?>
    <img src="<?php echo $this->template->htmlbase . 'images/cross.png' ?>" alt="Grupo inactivo" title="Grupo inactivo" />
<?php } ?>
<?php if ($this->group->amTeacher() || $this->group->amMember()) { ?>
    <a href="<?php echo $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url), 'groups_group_assign') ?>"><img src="<?php echo $this->template->htmlbase . 'images/group.png' ?>" alt="Ver miembros" title="Ver miembros" /></a>
<?php } ?>
<?php if ($this->subject->amModerator()) { ?>
    <a href="<?php echo $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url), 'groups_group_edit') ?>"><img src="<?php echo $this->template->htmlbase . 'images/pencil.png' ?>" alt="Editar" title="Editar" /></a>
<?php } ?>
</strong>
</h1>

<p>
    <span class="mark">Dictada por:</span> <?php echo $this->group->getTeacher()->getFullName() ?><br />
    <span class="mark">Método de evaluación:</span> <?php echo $this->group->getEvaluation()->label ?><br />
    <span class="mark">Materia:</span> <?php echo $this->subject->label ?><br />
    <span class="mark">Gestion:</span> <?php echo $this->subject->getGestion()->label ?>
</p>

<form method="post" action="" accept-charset="utf-8">
    <input type="hidden" name="return" value="<?php echo $this->currentPage() ?>" />

    <div>
        <input type="submit" value="Guardar" name="save" /><input type="submit" value="Limpiar" name="clean" /><input type="button" name="import" value="Importar" onclick="location.href='<?php echo $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url), 'califications_import') ?>'" /><input type="button" name="export" value="Exportar" onclick="location.href='<?php echo $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url), 'califications_export') ?>'" />&nbsp;|&nbsp;<?php echo $this->evaluation('evaluation', $this->group->evaluation) ?><input type="submit" value="Cambiar" name="change" />
    </div>

<?php if (count($this->students) != 0) { ?>
    <table id="califications">
        <tr>
            <th>Estudiante</th>
        <?php foreach ($this->tests as $test) { ?>
            <th><?php echo $test->key ?></th>
        <?php } ?>
        </tr>
    <?php foreach ($this->students as $key => $student) { ?>
        <tr class="<?php echo $key % 2 == 0 ? 'even' : 'odd' ?>">
            <td><?php echo $student->formalname ?></td>
        <?php foreach ($this->tests as $test) { ?>
            <?php $hasformula = !empty($test->formula); ?>
            <td width="20px">
                <center>
            <?php if ($test->hasValues()) { ?>
                <?php echo $this->testValues('calification[' . $this->group->ident . '][' . $student->ident . '][' . $this->evaluation->ident . '][' . $test->ident . ']', $this->model->getCalification($this->group->ident, $student->ident, $this->evaluation->ident, $test), $test, $hasformula) ?>
            <?php } else { ?>
                <input type="text" <?php echo $hasformula ? 'disabled="disabled" ':'' ?>maxlength="8" size="3" name="calification[<?php echo $this->group->ident ?>][<?php echo $student->ident?>][<?php echo $this->evaluation->ident?>][<?php echo $test->ident ?>]" value="<?php echo $this->model->getCalification($this->group->ident, $student->ident, $this->evaluation->ident, $test) ?>" />
            <?php } ?>
                </center>
            </td>
        <?php } ?>
        </tr>
    <?php } ?>
    </table>
<?php } else { ?>
    <p>No se encontraron estudiantes</p>
<?php } ?>

    <div>
        <input type="submit" value="Guardar" name="save" /><input type="submit" value="Limpiar" name="clean" /><input type="button" name="import" value="Importar" onclick="location.href='<?php echo $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url), 'califications_import') ?>'" /><input type="button" name="export" value="Exportar" onclick="location.href='<?php echo $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url), 'califications_export') ?>'" />
    </div>
</form>
