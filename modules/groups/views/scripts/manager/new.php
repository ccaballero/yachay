<h1>Nuevo grupo</h1>

<center>
    <form method="post" action="">
        <input type="hidden" name="return" value="<?= $this->lastPage() ?>" />
        <table>
            <tr>
                <td><b>Nombre/Numero de grupo (*):</b></td>
                <td><input type="text" name="label" value="<?= $this->group->label ?>" maxlength="64" /></td>
            </tr>
            <tr>
                <td><b>Docente (*):</b></td>
                <td><?= $this->teacher('teacher', $this->group->teacher, $this->subject) ?></td>
            </tr>
            <tr>
                <td><b>Metodo de evaluaci&oacute;n (*):</b></td>
                <td><?= $this->evaluation('evaluation', $this->group->evaluation) ?></td>
            </tr>
            <tr>
                <td colspan="2"><b>Descripci&oacute;n :</b></td>
            </tr>
            <tr>
                <td colspan="2">
                    <textarea name="description"><?= $this->utf2html($this->group->description) ?></textarea>
                </td>
            </tr>
            <tr>
                <td colspan="2">(*) Campos obligatorios.</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>
                    <input type="submit" value="Crear grupo" />
                    <a href="<?= $this->lastPage() ?>">Cancelar</a>
                </td>
            </tr>
        </table>
    </form>
</center>
