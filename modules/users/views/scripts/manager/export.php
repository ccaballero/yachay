<h1>Exportar Usuarios</h1>

<center>
    <form method="post" action="#" enctype="multipart/form-data">
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
                <td><?= $this->utf2html($this->model->_mapping['role']) ?></td>
                <td><input type="checkbox" name="columns[]" value="role" \></td>
            </tr>
            <tr>
                <td><?= $this->utf2html($this->model->_mapping['label']) ?></td>
                <td><input type="checkbox" checked="checked" name="columns[]" value="label" \></td>
            </tr>
            <tr>
                <td><?= $this->utf2html($this->model->_mapping['email']) ?></td>
                <td><input type="checkbox" name="columns[]" value="email" \></td>
            </tr>
            <tr>
                <td><?= $this->utf2html($this->model->_mapping['surname']) ?></td>
                <td><input type="checkbox" checked="checked" name="columns[]" value="surname" \></td>
            </tr>
            <tr>
                <td><?= $this->utf2html($this->model->_mapping['name']) ?></td>
                <td><input type="checkbox" checked="checked" name="columns[]" value="name" \></td>
            </tr>
            <tr>
                <td><?= $this->utf2html($this->model->_mapping['career']) ?></td>
                <td><input type="checkbox" name="columns[]" value="career" \></td>
            </tr>
            <tr>
                <td><?= $this->utf2html($this->model->_mapping['phone']) ?></td>
                <td><input type="checkbox" name="columns[]" value="phone" \></td>
            </tr>
            <tr>
                <td><?= $this->utf2html($this->model->_mapping['cellphone']) ?></td>
                <td><input type="checkbox" name="columns[]" value="cellphone" \></td>
            </tr>
            <tr>
                <td colspan="2">(*) Campos obligatorios.</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>
                    <input type="submit" value="Exportar usuarios" />
                    <input type="button" value="Cancelar" onclick="location.href='<?= $this->lastPage() ?>'" />
                </td>
            </tr>
        </table>
    </form>
</center>
