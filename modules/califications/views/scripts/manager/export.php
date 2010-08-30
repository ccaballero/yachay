<h1>Exportar calificaciones</h1>

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
                <td colspan="2"><b>Seleccione los valores que desea exportar</b></td>
            </tr>
        <?php foreach ($this->tests as $test) { ?>
            <tr>
                <td><b>[<?= $test->key ?>]</b>&nbsp;<?= $this->utf2html($test->label) ?></td>
                <td><input type="checkbox" checked="checked" name="columns[]" value="<?= $test->key ?>" \></td>
            </tr>
        <?php } ?>
            <tr>
                <td colspan="2">(*) Campos obligatorios.</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>
                    <input type="submit" value="Exportar calificaciones" />
                    <input type="button" value="Cancelar" onclick="location.href='<?= $this->lastPage() ?>'" />
                </td>
            </tr>
        </table>
    </form>
</center>
