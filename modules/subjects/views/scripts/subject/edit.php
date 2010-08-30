<h1>Editar materia</h1>

<center>
    <form method="post" action="">
        <input type="hidden" name="return" value="<?= $this->lastPage() ?>" />
        <table>
            <tr>
                <td><b>Nombre de materia (*):</b></td>
                <td><input type="text" name="label" value="<?= $this->utf2html($this->subject->label) ?>" maxlength="64" /></td>
            </tr>
            <tr>
                <td><b>Moderador (*):</b></td>
                <td><?= $this->moderator('moderator', $this->subject->moderator) ?></td>
            </tr>
            <tr>
                <td><b>Codigo (*):</b></td>
                <td><input type="text" name="code" value="<?= $this->subject->code ?>" maxlength="7" /></td>
            </tr>
            <tr>
                <td><b>Visibilidad (*):</b></td>
                <td><?= $this->visibility('visibility', $this->subject->visibility) ?></td>
            </tr>
            <tr>
                <td colspan="2"><b>Descripci&oacute;n :</b></td>
            </tr>
            <tr>
                <td colspan="2">
                    <textarea name="description"><?= $this->utf2html($this->subject->description) ?></textarea>
                </td>
            </tr>
            <tr>
                <td colspan="2"><b>Areas a las que pertenece :</b></td>
            </tr>
        <?php foreach ($this->areas as $area) { ?>
            <tr>
                <td><?= $this->utf2html($area->label) ?></td>
                <td><input type="checkbox" name="areas[]" <?= in_array($area->ident, $this->checks) ? 'checked="checked" ':'' ?>value="<?= $area->ident ?>" /></td>
            </tr>
        <?php } ?>
            <tr>
                <td colspan="2">(*) Campos obligatorios.</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>
                    <input type="submit" value="Editar materia" />
                    <input type="button" value="Cancelar" onclick="location.href='<?= $this->lastPage() ?>'" />
                </td>
            </tr>
        </table>
    </form>
</center>
