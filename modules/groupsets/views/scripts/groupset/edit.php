<h1>Editar conjunto</h1>

<center>
    <form method="post" action="">
        <input type="hidden" name="return" value="<?= $this->lastPage() ?>" />
        <table>
            <tr>
                <td><b>Conjunto (*):</b></td>
                <td>
                    <input type="text" name="label" size="15" maxlength="64" value="<?= $this->utf2html($this->groupset->label) ?>" />
                </td>
            </tr>
            <tr>
                <td colspan="2"><b>Grupos :</b></td>
            </tr>
            <tr>
            	<td colspan="2">
            	<?php if (count($this->subjects)) { ?>
				<?php foreach ($this->subjects as $subject) { ?>
					<b><?= $this->utf2html($subject->label) ?></b>
					<br />
                    <?php foreach ($this->groups[$subject->ident] as $group) { ?>
                    	<input type="checkbox" name="groups[]" <?= in_array($group->ident, $this->checks) ? 'checked="checked" ':'' ?>value="<?= $group->ident ?>" />
				    	<a href="<?= $this->url(array('subject' => $subject->url, 'group' => $group->url), 'groups_group_view') ?>">Grupo <?= $group->label ?></a>
						<br />
	                <?php } ?>
                <?php } ?>
                <?php } else { ?>
					<p>No existen asignaciones suyas en ninguna materia.</p>
                <?php } ?>
            <tr>
                <td colspan="2">(*) Campos obligatorios.</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>
                    <input type="submit" value="Guardar" />
                    <a href="<?= $this->lastPage() ?>">Cancelar</a>
                </td>
            </tr>
        </table>
    </form>
</center>
