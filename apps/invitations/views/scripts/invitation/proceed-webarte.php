<h1><?php echo $this->route->label ?></h1>
<p>Para finalizar el proceso de registro, debe escoger su nombre de usuario y sus datos personales.</p>

<form method="post" action="" accept-charset="utf-8">
    <input type="hidden" name="return" value="<?php echo $this->lastPage() ?>" />

    <p><label for="user_label">Nombre de usuario (*): </label><input id="user_label" name="label" type="text" value="<?php echo $this->user->label ?>" maxlength="20" /></p>
    <p><label for="user_surname">Apellidos: </label><input id="user_surname" name="surname" type="text" value="<?php echo $this->user->surname ?>" maxlength="128" /></p>
    <p><label for="user_name">Nombres: </label><input id="user_name" name="name" type="text" value="<?php echo $this->user->name ?>" maxlength="128" /></p>
    <p><label for="user_date">Fecha de nacimiento: </label><?php echo $this->date('birthdate', $this->user->birthdate, 'BEFORE') ?></p>
    <p>(*) Campos obligatorios.</p>
    <p class="submit"><input type="submit" value="Registrar usuario" /></p>
</form>
