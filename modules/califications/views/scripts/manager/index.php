<h1>Calificaciones: 
    Grupo <?= $this->utf2html($this->group->label) ?>
</h1>

<i><b>Materia: </b><?= $this->utf2html($this->subject->label) ?></i>
<br />
<br />
<b>Dictada por: <i><?= $this->group->getTeacher()->getFullName() ?></i></b>
<br />
<b>Estado: <i><?= $this->status($this->group->status) ?></i></b>
<br />

<form method="post" action="" accept-charset="utf-8">
    <input type="hidden" name="return" value="<?= $this->currentPage() ?>" />
    <table>
        <tr>
            <td><input type="submit" value="Guardar" name="save" /></td>
            <td><input type="submit" value="Limpiar" name="clean" /></td>
            <td>[<a href="<?= $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url), 'califications_import') ?>">Importar</a>]</td>
            <td>[<a href="<?= $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url), 'califications_export') ?>">Exportar</a>]</td>
            <td>&nbsp;|&nbsp;</td>
            <td><?= $this->evaluation('evaluation', $this->group->evaluation) ?></td>
            <td><input type="submit" value="Cambiar" name="change" /></td>
        </tr>
    </table>

	<hr />
    <?php if (count($this->students) != 0) { ?>
		<table width="100%">
			<tr>
				<th>Estudiante</th>
			<?php foreach ($this->tests as $test) { ?>
				<th><?= $test->key ?></th>
			<?php } ?>
			</tr>
	    <?php foreach ($this->students as $student) { ?>
			<tr>
				<td><?= $student->getFullName() ?></td>
			<?php foreach ($this->tests as $test) { ?>
			<?php $hasformula = !empty($test->formula); ?>
				<td>
					<center>
					<?php if ($test->hasValues()) { ?>
						<?= $this->testValues('calification[' . $this->group->ident . '][' . $student->ident . '][' . $this->evaluation->ident . '][' . $test->ident . ']', $this->model->getCalification($this->group->ident, $student->ident, $this->evaluation->ident, $test), $test, $hasformula) ?>
					<?php } else { ?>
						<input type="text" <?= $hasformula ? 'disabled="disabled" ':'' ?>maxlength="8" size="3" name="calification[<?= $this->group->ident ?>][<?= $student->ident?>][<?= $this->evaluation->ident?>][<?= $test->ident ?>]" value="<?= $this->model->getCalification($this->group->ident, $student->ident, $this->evaluation->ident, $test) ?>" />
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
	<hr />

    <table>
        <tr>
            <td><input type="submit" value="Guardar" name="save" /></td>
            <td><input type="submit" value="Limpiar" name="clean" /></td>
            <td>[<a href="<?= $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url), 'califications_import') ?>">Importar</a>]</td>
            <td>[<a href="<?= $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url), 'califications_export') ?>">Exportar</a>]</td>
        </tr>
    </table>
</form>
