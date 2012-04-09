<h1><?php echo $this->PAGE->label ?></h1>

<form method="post" action="" accept-charset="utf-8">
    <input type="hidden" name="return" value="<?php echo $this->lastPage() ?>" />

    <p><label for="invitation_email">Correo electronico (*): </label><input id="invitation_email" name="email" type="text" value="<?php echo $this->invitation->email ?>" size="64" maxlength="64" /></p>
    <p><label for="invitation_message">Mensaje: </label><textarea id="invitation_message" name="message" cols="50" rows="5"><?php echo $this->invitation->message ?></textarea></p>
    <p>(*) Campos obligatorios.</p>
    <p class="submit"><input type="submit" value="Crear invitación" /><input type="button" value="Cancelar" onclick="location.href='<?php echo $this->lastPage() ?>'" /></p>
</form>
