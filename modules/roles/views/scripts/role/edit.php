<h1>Editar rol</h1>

<center>
    <form method="post" action="" accept-charset="utf-8">
        <input type="hidden" name="return" value="<?= $this->lastPage() ?>" />
	    <table>
	        <tr>
	            <td><b>Rol (*):</b></td>
	            <td><input name="label" type="text" value="<?= $this->utf2html($this->role->label) ?>" maxlength="50" /></td>
	        </tr>
	        <tr>
	            <td colspan="2"><b>Descripcion:</b></td>
	        </tr>
	        <tr>
	            <td colspan="2" align="right"><textarea name="description" ><?= $this->utf2html($this->role->description) ?></textarea></td>
	        </tr>
	        <tr>
                <td colspan="2"><b>Privilegios:</b></td>
            </tr>
        <?php foreach ($this->privileges as $privilege) { ?>
            <tr>
                <td><b>[<?= $privilege->module ?>]</b>&nbsp;<?= $this->utf2html($privilege->label) ?></td>
                <td align="right">
                    <input type="checkbox" <?= in_array($privilege->ident, $this->role_privilege) ? 'checked="checked" ' : '' ?>name="privileges[]" value="<?= $privilege->ident ?>" />
                </td>
            </tr>
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
