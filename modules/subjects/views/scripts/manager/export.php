<h1>Exportar Materias</h1>

<center>
    <form method="post" action="" enctype="multipart/form-data">
        <input type="hidden" name="return" value="<?= $this->lastPage() ?>" />
        <table>
            <tr>
                <td><b>Formato de archivo (*):</b></td>
                <td>
                    <select name="extension">
                        <option>--------------------------</option>
                        <option value="csv">.csv (Archivo separado por comas)</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td colspan="2"><b>Seleccione los atributos que desea exportar</b></td>
            </tr>
            <tr>
                <td><?= $this->utf2html($this->model->_mapping['code']) ?></td>
                <td><input type="checkbox" checked="checked" name="columns[]" value="code" \></td>
            </tr>
            <tr>
                <td><?= $this->utf2html($this->model->_mapping['moderator']) ?></td>
                <td><input type="checkbox" checked="checked" name="columns[]" value="moderator" \></td>
            </tr>
            <tr>
                <td><?= $this->utf2html($this->model->_mapping['label']) ?></td>
                <td><input type="checkbox" checked="checked" name="columns[]" value="label" \></td>
            </tr>
            <tr>
                <td><?= $this->utf2html($this->model->_mapping['visibility']) ?></td>
                <td><input type="checkbox" checked="checked" name="columns[]" value="visibility" \></td>
            </tr>
            <tr>
                <td><?= $this->utf2html($this->model->_mapping['description']) ?></td>
                <td><input type="checkbox" checked="checked" name="columns[]" value="description" \></td>
            </tr>
            <tr>
                <td colspan="2">(*) Campos obligatorios.</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>
                    <input type="submit" value="Exportar materias" />
                    <input type="button" value="Cancelar" onclick="location.href='<?= $this->lastPage() ?>'" />
                </td>
            </tr>
        </table>
    </form>
</center>
