<h1>Nueva comunidad</h1>

<center>
    <form method="post" action="" enctype="multipart/form-data">
        <input type="hidden" name="return" value="<?= $this->lastPage() ?>" />
        <table>
            <tr>
                <td><b>Nombre (*):</b></td>
                <td>
                    <input type="text" name="label" size="15" maxlength="64" value="<?= $this->utf2html($this->community->label) ?>" />
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
                <td><b>Intereses:</b></td>
                <td><input type="text" name="interests" value="<?= $this->utf2html($this->community->interests) ?>" maxlength="1024" /></td>
            </tr>
            <tr>
                <td colspan="2"><b>Descripci&oacute;n :</b></td>
            </tr>
            <tr>
                <td colspan="2">
                    <textarea name="description"><?= $this->utf2html($this->community->description) ?></textarea>
                </td>
            </tr>
            <tr>
                <td colspan="2">(*) Campos obligatorios.</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>
                    <input type="submit" value="Crear comunidad" />
                    <input type="button" value="Cancelar" onclick="location.href='<?= $this->lastPage() ?>'" />
                </td>
            </tr>
        </table>
    </form>
</center>
