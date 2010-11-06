<h1><?= $this->PAGE->label ?></h1>
<p>En esta pagina usted puede configurar algunos aspectos del comportamiento del sistema, como por ejemplo: su contraseña, el aspecto, las notificaciones, los boletines y otros dependiendo de los modulos que esten instalados.</p>

<form method="post" action="" accept-charset="utf-8">
    <input type="hidden" name="return" value="<?= $this->lastPage() ?>" />

    <p><label>Cambio de contraseña</label>&nbsp;</p>
    <p><label>Nueva contraseña: </label><input type="password" name="password1" value="" /></p>
    <p><label>Repita la contraseña nueva: </label><input type="password" name="password2" value="" /></p>
    <p class="submit"><input type="submit" value="Actualizar preferencias" /><input type="button" value="Cancelar" onclick="location.href='<?= $this->lastPage() ?>'" /></p>
</form>
