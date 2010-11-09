<h1><?= $this->PAGE->label ?></h1>

<center>
    <form method="post" action="" accept-charset="utf-8">
        <input type="hidden" name="return" value="<?= $this->lastPage() ?>" />
        <table>
            <tr>
                <td><b>Area (*):</b></td>
                <td>
                    <input type="text" name="label" size="15" maxlength="64" value="<?= $this->area->label ?>" />
                </td>
            </tr>
            <tr>
                <td colspan="2"><b>Descripción :</b></td>
            </tr>
            <tr>
                <td colspan="2">
                    <textarea name="description" cols="50" rows="5"><?= $this->area->description ?></textarea>
                </td>
            </tr>
            <tr>
                <td colspan="2">(*) Campos obligatorios.</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>
                    <input type="submit" value="Crear area" />
                    <a href="<?= $this->lastPage() ?>">Cancelar</a>
                </td>
            </tr>
        </table>
    </form>
</center>
