<h1><?= $this->PAGE->label ?></h1>

<form method="post" action="" accept-charset="utf-8">
    <input type="hidden" name="return" value="<?= $this->lastPage() ?>" />

    <p><label for="user_label">Nombre de usuario (*): </label><input id="user_label" name="label" type="text" value="<?= $this->user->label ?>" maxlength="20" /></p>
    <p><label for="user_password">Generador de contraseña: </label><?= $this->password('user_password', 'password', $this->user->password) ?></p>
    <p><label for="user_code">Codigo SISS (*): </label><input id="user_code" name="code" type="text" value="<?= $this->user->code ?>" maxlength="9" /></p>
    <p><label for="user_formalname">Nombre Formal (*): </label><input id="user_formalname" name="formal" type="text" value="<?= $this->user->formalname ?>" maxlength="128" /></p>
    <p><label for="user_role">Rol (*): </label><?= $this->role('user_role', 'role', $this->user->role) ?></p>
    <p><label for="user_email">Correo electrónico: </label><input id="user_email" name="email" type="text" value="<?= $this->user->email ?>" maxlength="50" /></p>
    <p><label for="user_surname">Apellidos: </label><input id="user_surname" name="surname" type="text" value="<?= $this->user->surname ?>" maxlength="128" /></p>
    <p><label for="user_name">Nombres: </label><input id="user_name" name="name" type="text" value="<?= $this->user->name ?>" maxlength="128" /></p>
    <p><label for="user_date">Fecha de nacimiento: </label><?= $this->date('birthdate', $this->user->birthdate) ?></p>
    <p><label for="user_career">Carrera: </label><?= $this->career('user_career', 'career', $this->user->career) ?></p>
    <p><label for="user_phone">Telefono: </label><input id="user_phone" name="phone" type="text" value="<?= $this->user->phone ?>" maxlength="64" /></p>
    <p><label for="user_cellphone">Celular: </label><input id="user_cellphone" name="cellphone" type="text" value="<?= $this->user->cellphone ?>" maxlength="64" /></p>
    <p>(*) Campos obligatorios.</p>
    <p class="submit"><input type="submit" value="Crear usuario" /><input type="button" value="Cancelar" onclick="location.href='<?= $this->lastPage() ?>'" /></p>
</form>
