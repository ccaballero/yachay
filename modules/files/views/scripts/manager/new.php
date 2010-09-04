<h1>Nuevo archivo</h1>

<center>
    <form enctype="multipart/form-data" method="post" action="">
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
                <td colspan="2"><b>Descripci&oacute;n :</b></td>
            </tr>
            <tr>
                <td colspan="2">
                    <textarea name="description" cols="50" rows="5"><?= $this->utf2html($this->file->file) ?></textarea>
                </td>
            </tr>
            <tr>
                <td colspan="2">(*) Campos obligatorios.</td>
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
