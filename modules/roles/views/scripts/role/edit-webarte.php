<h1>Editar rol: <?= $this->role->label ?></h1>

<form method="post" action="" accept-charset="utf-8">
    <input type="hidden" name="return" value="<?= $this->lastPage() ?>" />

    <p><label for="role_label">Rol (*): </label><input name="label" type="text" value="<?= $this->role->label ?>" maxlength="50" /></p>
    <p><label for="role_description">Descripción: </label><textarea name="description" cols="50" rows="5"><?= $this->role->description ?></textarea></p>
    <p><label>Privilegios:</label>&nbsp;</p>
<?php foreach ($this->privileges as $privilege) { ?>
    <p>
        <label>&nbsp;</label>
        <input type="checkbox" <?= in_array($privilege->ident, $this->role_privilege) ? 'checked="checked" ' : '' ?>name="privileges[]" value="<?= $privilege->ident ?>" />
        <span class="mark form"><?= $privilege->module ?></span><span class="form"><?= $privilege->label ?></span>
    </p>
<?php } ?>
    <p>(*) Campos obligatorios.</p>
    <p class="submit"><input type="submit" value="Actualizar rol" /><input type="button" value="Cancelar" onclick="location.href='<?= $this->lastPage() ?>'" /></p>
</form>
