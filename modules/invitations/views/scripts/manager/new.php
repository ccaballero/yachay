<h1><?= $this->PAGE->label ?></h1>

<form method="post" action="" accept-charset="utf-8">
    <input type="hidden" name="return" value="<?= $this->lastPage() ?>" />

    <p><label for="invitation_email">Correo electronico (*): </label><input id="invitation_email" name="email" type="text" value="<?= $this->invitation->email ?>" size="20" maxlength="20" /></p>
    <p><label for="invitation_message">Mensaje: </label><textarea id="invitation_message" name="message" cols="50" rows="5"><?= $this->invitation->message ?></textarea></p>
    <p>(*) Campos obligatorios.</p>
    <p class="submit"><input type="submit" value="Crear invitación" /><input type="button" value="Cancelar" onclick="location.href='<?= $this->lastPage() ?>'" /></p>
</form>
