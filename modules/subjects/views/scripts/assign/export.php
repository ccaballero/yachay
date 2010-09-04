<h1>Exportar miembros</h1>

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
                <td colspan="2">(*) Campos obligatorios.</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>
                    <input type="submit" value="Exportar miembros" />
                    <a href="<?= $this->lastPage() ?>">Cancelar</a>
                </td>
            </tr>
        </table>
    </form>
</center>
