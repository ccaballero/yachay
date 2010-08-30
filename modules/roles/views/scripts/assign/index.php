<h1>Asignacion de roles a usuarios</h1>

<center>
    <form method="post" action="">
        <input type="hidden" name="return" value="<?= $this->lastPage() ?>" />
        <table width="100%">
            <tr>
                <td>&nbsp;</td>
            <?php foreach ($this->roles as $role) { ?>
                <td><b><?= $this->utf2html($role->label) ?></b></td>
            <?php } ?>
            </tr>
        <?php foreach ($this->users as $user) { ?>
            <tr>
                <td><b><?= $user->label ?></b></td>
            <?php foreach ($this->roles as $role) { ?>
                <td>
                    <center>
                        <input type="radio" <?= ($user->role == $role->ident) ? 'checked="checked" ' : ' ' ?>name="radio[<?= $user->ident ?>]" value="<?= $role->ident ?>" />
                    </center>
                </td>
            <?php } ?>
            </tr>
        <?php } ?>
        </table>
        <input type="submit" value="Actualizar asignacion" />
        <input type="button" value="Cancelar" onclick="location.href='<?= $this->lastPage() ?>'" />
    </form>
</center>
