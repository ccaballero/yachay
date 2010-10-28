<h1>Nueva comunidad</h1>

<center>
    <form method="post" action="" enctype="multipart/form-data" accept-charset="utf-8">
        <input type="hidden" name="return" value="<?= $this->lastPage() ?>" />
        <table>
            <tr>
                <td><b>Nombre (*):</b></td>
                <td>
                    <input type="text" name="label" size="15" maxlength="64" value="<?= $this->community->label ?>" />
                </td>
            </tr>
            <tr>
                <td><b>Modalidad (*):</b></td>
                <td><?= $this->mode('mode', $this->community->mode) ?></td>
            </tr>
            <tr>
                <td><b>Avatar:</b></td>
                <td><?= $this->formFile('file')?></td>
            </tr>
            <tr>
                <td><b>Etiquetas (**):</b></td>
                <td><input name="tags" value="" maxlength="128" /></td>
            </tr>
            <tr>
                <td colspan="2"><b>Descripci&oacute;n :</b></td>
            </tr>
            <tr>
                <td colspan="2">
                    <textarea name="description" cols="50" rows="5"><?= $this->community->description ?></textarea>
                </td>
            </tr>
            <tr>
                <td colspan="2">(*) Campos obligatorios.</td>
            </tr>
            <tr>
                <td colspan="2">(**) Las etiquetas deben separarse con comas.</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>
                    <input type="submit" value="Crear comunidad" />
                    <a href="<?= $this->lastPage() ?>">Cancelar</a>
                </td>
            </tr>
        </table>
    </form>
</center>
