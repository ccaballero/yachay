<h1><?= $this->PAGE->label ?></h1>

<center>
    <form method="post" action="" accept-charset="utf-8">
        <input type="hidden" name="return" value="<?= $this->lastPage() ?>" />
        <table>
            <tr>
                <td><b>Publicar en (*):</b></td>
                <td><?= $this->context('publish') ?></td>
            </tr>
            <tr>
                <td colspan="2"><b>Mensaje (*):</b></td>
            </tr>
            <tr>
                <td colspan="2">
                    <textarea name="message" cols="50" rows="5"><?= $this->note->note ?></textarea>
                </td>
            </tr>
            <tr>
                <td><b>Etiquetas (**):</b></td>
                <td><input name="tags" value="" maxlength="128" /></td>
            </tr>
            <tr>
                <td>Convertir en Aviso</td>
                <td><input type="checkbox" name="priority"/></td>
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
                    <input type="submit" value="Crear nota" />
                    <a href="<?= $this->lastPage() ?>">Cancelar</a>
                </td>
            </tr>
        </table>
    </form>
</center>
