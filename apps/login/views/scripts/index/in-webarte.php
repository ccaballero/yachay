<h1><?php echo $this->route->label ?></h1>
<p>Para acceder al sistema, debe colocar su nombre de usuario y la contraseña que le haya sido provista.</p>

<form method="post" action="" accept-charset="utf-8">
    <input type="hidden" name="return" value="<?php echo $this->lastPage() ?>" />

    <p><label for="login_username">Usuario: </label><input id="login_username" name="username" class="login" type="text" value="<?php echo $this->values['username'] ?>" maxlength="32" /></p>
    <p><label for="login_password">Contraseña: </label><input id="login_username" name="password" class="login" type="password" maxlength="32" /></p>
    <p class="submit"><input type="submit" value="Ingresar" /></p>
    <p class="submit"><a href="<?php echo $this->url(array(), 'login_forgot') ?>">Olvide mi contraseña</a></p>
</form>

<script type="text/javascript">
window.onload = function() {
  document.getElementById("login_username").focus();
}
</script>
