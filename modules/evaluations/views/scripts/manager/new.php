<h1>Nuevo criterio de evaluaci&oacute;n</h1>

<center>
    <form method="post" action="">
        <input type="hidden" name="return" value="<?= $this->lastPage() ?>" />
        <table>
	        <tr>
                <td><b>Nombre del criterio (*):</b></td>
                <td>
                    <input type="text" name="label" size="15" maxlength="64" value="<?= $this->utf2html($this->evaluation->label) ?>" />
                </td>
            </tr>
            <tr>
                <td><b>Accesibilidad (*):</b></td>
                <td><?= $this->accesibility('access', $this->evaluation->access) ?></td>
            </tr>
            <tr>
                <td colspan="2"><b>Descripci&oacute;n :</b></td>
            </tr>
            <tr>
                <td colspan="2">
                    <textarea name="description"><?= $this->utf2html($this->evaluation->description) ?></textarea>
                </td>
            </tr>
            <tr>
                <td colspan="2">(*) Campos obligatorios.</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>
                    <input type="submit" value="Crear criterio" />
                    <a href="<?= $this->lastPage() ?>">Cancelar</a>
                </td>
            </tr>
        </table>
    </form>
</center>
