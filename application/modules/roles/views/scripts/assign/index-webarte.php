<h1><?php echo $this->PAGE->label ?></h1>

<form method="post" action="" accept-charset="utf-8">
    <input type="hidden" name="return" value="<?php echo $this->lastPage() ?>" />

    <div><input type="submit" value="Actualizar" /><input type="button" name="cancel" value="Cancelar" onclick="location.href='<?php echo $this->lastPage() ?>'" /></div>

    <table>
        <tr>
            <th>&nbsp;</th>
        <?php foreach ($this->roles as $role) { ?>
            <th><?php echo $role->label ?></th>
        <?php } ?>
        </tr>
    <?php foreach ($this->users as $key => $user) { ?>
        <tr class="<?php echo $key % 2 == 0 ? 'even' : 'odd' ?>">
            <td><b><?php echo $user->label ?></b></td>
        <?php foreach ($this->roles as $role) { ?>
            <td class="center"><input type="radio" <?php echo ($user->role == $role->ident) ? 'checked="checked" ' : ' ' ?>name="radio[<?php echo $user->ident ?>]" value="<?php echo $role->ident ?>" /></td>
        <?php } ?>
        </tr>
    <?php } ?>
    </table>

    <div><input type="submit" value="Actualizar" /><input type="button" name="cancel" value="Cancelar" onclick="location.href='<?php echo $this->lastPage() ?>'" /></div>
</form>
