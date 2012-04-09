<h1><?php echo $this->PAGE->label ?></h1>
<p>Escriba su dirección de correo electrónico para que le enviemos una nueva contraseña.</p>

<form method="post" action="" accept-charset="utf-8">
    <input type="hidden" name="return" value="<?php echo $this->lastPage() ?>" />

    <p><label for="forgot_email">Correo electrónico: </label><input id="forgot_email" name="email" type="text" value="<?php echo $this->values['email'] ?>" maxlength="64" /></p>
    <p class="submit"><input type="submit" value="Enviar" /></p>
</form>
