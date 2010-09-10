<h1>Importar miembros</h1>

<center>
    <form method="post" action="" enctype="multipart/form-data" accept-charset="utf-8">
        <input type="hidden" name="return" value="<?= $this->lastPage() ?>" />
        <table>
            <tr>
                <td><b>Archivo (.csv) (2 MiB max.) (*):</b></td>
                <td><?= $this->formFile('file')?></td>
            </tr>
            <tr>
                <td colspan="2">(*) Campos obligatorios.</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>
                    <input type="submit" value="Importar miembros" />
                    <a href="<?= $this->lastPage() ?>">Cancelar</a>
                </td>
            </tr>
        </table>
    </form>
</center>
