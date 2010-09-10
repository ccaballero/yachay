<h1>Importar calificaciones</h1>

<center>
    <form method="post" action="" enctype="multipart/form-data" accept-charset="utf-8">
        <input type="hidden" name="return" value="<?= $this->lastPage() ?>" />
        <table>
            <tr>
                <td><b>Archivo (.csv) (2 MiB max.) (*):</b></td>
                <td><?= $this->formFile('file')?></td>
            </tr>
        <?php $first = true; ?>
        <?php foreach ($this->options as $key => $option) { ?>
            <tr>
                <td><?= $option ?></td>
                <td><input type="radio" <?= $first ? 'checked="checked "':'' ?>name="type" value="<?= $key ?>" /></td>
            </tr>
            <?php $first = false; ?>
        <?php } ?>
            <tr>
                <td colspan="2">(*) Campos obligatorios.</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>
                    <input type="submit" value="Importar calificaciones" />
                    <a href="<?= $this->lastPage() ?>">Cancelar</a>
                </td>
            </tr>
        </table>
    </form>
</center>
