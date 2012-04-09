<h1><?php echo $this->PAGE->label ?></h1>

<form method="post" action="" accept-charset="utf-8">
    <input type="hidden" name="return" value="<?php echo $this->lastPage() ?>" />

    <p><label for="groupset_label">Nombre del conjunto (*): </label><input id="groupset_label" name="label" type="text" value="<?php echo $this->groupset->label ?>" size="20" maxlength="20" /></p>
    <p><label>Grupos: </label>&nbsp;</p>
<?php if (count($this->subjects)) { ?>
    <?php foreach ($this->subjects as $subject) { ?>
        <p>
            <label>&nbsp;</label>
            <span class="mark form"><?php echo $subject->label ?></span>
        </p>
        <?php foreach ($this->groups[$subject->ident] as $group) { ?>
            <p>
                <label>&nbsp;</label>
                <input type="checkbox" <?php echo in_array($group->ident, $this->checks) ? 'checked="checked" ' : '' ?>name="groups[]" value="<?php echo $group->ident ?>" />
                <span class="form"><a href="<?php echo $this->url(array('subject' => $subject->url, 'group' => $group->url), 'groups_group_view') ?>">Grupo <?php echo $group->label ?></a></span>
            </p>
        <?php } ?>
    <?php } ?>
<?php } else { ?>
    <p>No existen asignaciones suyas en ninguna materia.</p>
<?php } ?>
    <p>(*) Campos obligatorios.</p>
    <p class="submit"><input type="submit" value="Guardar conjunto" /><input type="button" value="Cancelar" onclick="location.href='<?php echo $this->lastPage() ?>'" /></p>
</form>
