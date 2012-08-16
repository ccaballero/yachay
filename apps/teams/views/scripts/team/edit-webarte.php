<h1><?php echo $this->route->label ?></h1>
<p>
    <span class="mark">Dictada por:</span> <?php echo $this->group->getTeacher()->getFullName() ?><br />
    <span class="mark">Grupo:</span> <?php echo $this->group->label ?><br />
    <span class="mark">Materia:</span> <?php echo $this->subject->label ?><br />
    <span class="mark">Gestion:</span> <?php echo $this->gestion->label ?>
</p>

<form method="post" action="" accept-charset="utf-8">
    <input type="hidden" name="return" value="<?php echo $this->lastPage() ?>" />

    <p><label for="team_label">Nombre del equipo (*): </label><input id="team_label" name="label" type="text" value="<?php echo $this->team->label ?>" size="20" maxlength="20" /></p>
    <p><label for="team_description">Descripción: </label><textarea id="team_description" name="description" cols="50" rows="5"><?php echo $this->team->description ?></textarea></p>
    <p>(*) Campos obligatorios.</p>
    <p class="submit"><input type="submit" value="Editar equipo" /><input type="button" value="Cancelar" onclick="location.href='<?php echo $this->lastPage() ?>'" /></p>
</form>
