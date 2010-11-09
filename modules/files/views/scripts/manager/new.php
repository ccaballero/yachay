<h1><?= $this->PAGE->label ?></h1>

<center>
    <form method="post" action="" enctype="multipart/form-data" accept-charset="utf-8">
        <input type="hidden" name="return" value="<?= $this->lastPage() ?>" />
        <table>
            <tr>
                <td><b>Publicar en (*):</b></td>
                <td><?= $this->context('publish') ?></td>
            </tr>
            <tr>
                <td><b>Archivo (2 MiB max.) (*):</b></td>
                <td><?= $this->formFile('file')?></td>
            </tr>
            <tr>
                <td colspan="2"><b>Descripción :</b></td>
            </tr>
            <tr>
                <td colspan="2">
                    <textarea name="description" cols="50" rows="5"><?= $this->file->file ?></textarea>
                </td>
            </tr>
            <tr>
                <td><b>Etiquetas (**):</b></td>
                <td><input name="tags" value="" maxlength="128" /></td>
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
                    <input type="submit" value="Subir archivo" />
                    <a href="<?= $this->lastPage() ?>">Cancelar</a>
                </td>
            </tr>
        </table>
    </form>
</center>
