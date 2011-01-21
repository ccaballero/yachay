<h1><?= $this->PAGE->label ?></h1>

<form method="post" action="" accept-charset="utf-8">
    <input type="hidden" name="return" value="<?= $this->lastPage() ?>" />

    <p><label for="groupset_label">Nombre del conjunto (*): </label><input id="groupset_label" name="label" type="text" value="<?= $this->groupset->label ?>" size="20" maxlength="20" /></p>
    <p><label>Grupos: </label>&nbsp;</p>
<?php if (count($this->subjects)) { ?>
    <?php foreach ($this->subjects as $subject) { ?>
        <p>
            <label>&nbsp;</label>
            <span class="mark form"><?= $subject->label ?></span>
        </p>
        <?php foreach ($this->groups[$subject->ident] as $group) { ?>
            <p>
                <label>&nbsp;</label>
                <input type="checkbox" <?= in_array($group->ident, $this->checks) ? 'checked="checked" ' : '' ?>name="groups[]" value="<?= $group->ident ?>" />
                <span class="form"><a href="<?= $this->url(array('subject' => $subject->url, 'group' => $group->url), 'groups_group_view') ?>">Grupo <?= $group->label ?></a></span>
            </p>
        <?php } ?>
    <?php } ?>
<?php } else { ?>
    <p>No existen asignaciones suyas en ninguna materia.</p>
<?php } ?>
    <p>(*) Campos obligatorios.</p>
    <p class="submit"><input type="submit" value="Crear conjunto" /><input type="button" value="Cancelar" onclick="location.href='<?= $this->lastPage() ?>'" /></p>
</form>
