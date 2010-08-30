<h1>Importar calificaciones</h1>

<center>
    <form method="post" action="" enctype="multipart/form-data">
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
                    <input type="button" value="Cancelar" onclick="location.href='<?= $this->lastPage() ?>'" />
                </td>
            </tr>
        </table>
    </form>
</center>
