<h1><?= $this->PAGE->label ?></h1>

<form method="post" action="" accept-charset="utf-8">
    <input type="hidden" name="return" value="<?= $this->lastPage() ?>" />

    <div><input type="submit" value="Actualizar" /><input type="button" name="cancel" value="Cancelar" onclick="location.href='<?= $this->lastPage() ?>'" /></div>

    <table>
        <tr>
            <th>&nbsp;</th>
        <?php foreach ($this->roles as $role) { ?>
            <th><?= $role->label ?></th>
        <?php } ?>
        </tr>
    <?php foreach ($this->users as $key => $user) { ?>
        <tr class="<?= $key % 2 == 0 ? 'even' : 'odd' ?>">
            <td><b><?= $user->label ?></b></td>
        <?php foreach ($this->roles as $role) { ?>
            <td class="center"><input type="radio" <?= ($user->role == $role->ident) ? 'checked="checked" ' : ' ' ?>name="radio[<?= $user->ident ?>]" value="<?= $role->ident ?>" /></td>
        <?php } ?>
        </tr>
    <?php } ?>
    </table>

    <div><input type="submit" value="Actualizar" /><input type="button" name="cancel" value="Cancelar" onclick="location.href='<?= $this->lastPage() ?>'" /></div>
</form>
