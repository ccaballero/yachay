<h1>Nuevo equipo</h1>

<center>
    <form method="post" action="" accept-charset="utf-8">
        <input type="hidden" name="return" value="<?= $this->lastPage() ?>" />
        <table>
            <tr>
                <td><b>Nombre del equipo (*):</b></td>
                <td><input type="text" name="label" value="<?= $this->team->label ?>" maxlength="64" /></td>
            </tr>
            <tr>
                <td colspan="2"><b>Descripci&oacute;n :</b></td>
            </tr>
            <tr>
                <td colspan="2">
                    <textarea name="description"><?= $this->utf2html($this->team->description) ?></textarea>
                </td>
            </tr>
            <tr>
                <td colspan="2">(*) Campos obligatorios.</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>
                    <input type="submit" value="Crear equipo" />
                    <a href="<?= $this->lastPage() ?>">Cancelar</a>
                </td>
            </tr>
        </table>
    </form>
</center>
