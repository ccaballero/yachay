<h1><?= $this->PAGE->label ?></h1>
<p>En esta pagina usted debe establecer la informacion que es solicitada, asegurese de mantenerla siempre actualizada, para no tener problemas en el uso del sistema.</p>

<form method="post" action="" enctype="multipart/form-data" accept-charset="utf-8">
    <input type="hidden" name="return" value="<?= $this->lastPage() ?>" />

    <p><label for="profile_label">Nombre de usuario (*): </label><input id="profile_label" name="label" type="text" value="<?= $this->user->label ?>" maxlength="20" /></p>
    <p><label for="profile_email">Correo electronico: </label><input id="profile_email" name="email" type="text" value="<?= $this->user->email ?>" maxlength="50" /></p>
    <p><label for="profile_surname">Apellidos: </label><input id="profile_surname" name="surname" type="text" value="<?= $this->user->surname ?>" maxlength="128" /></p>
    <p><label for="profile_name">Nombres: </label><input id="profile_name" name="name" type="text" value="<?= $this->user->name ?>" maxlength="128" /></p>
    <p><label for="profile_date">Fecha de nacimiento: </label><?= $this->date('birthdate', $this->user->birthdate) ?></p>
    <p><label for="profile_career">Carrera: </label><?= $this->career('profile_career', 'career', $this->user->career) ?></p>
    <p><label for="profile_phone">Telefono: </label><input id="profile_phone" name="phone" type="text" value="<?= $this->user->phone ?>" maxlength="64" /></p>
    <p><label for="profile_cellphone">Celular: </label><input id="profile_cellphone" name="cellphone" type="text" value="<?= $this->user->cellphone ?>" maxlength="64" /></p>
    <p><label for="profile_photo">Avatar (jpg, png, gif): </label><?= $this->formFile('file') ?></p>
    <p><label for="profile_tags">Etiquetas (**): </label><input id="profile_tags" name="tags" type="text" value="<?= $this->tags ?>" maxlength="128" /></p>
    <p><label for="profile_hobbies">Pasatiempos: </label><input id="profile_hobbies" name="hobbies" type="text" value="<?= $this->user->hobbies ?>" maxlength="1024" /></p>
    <p><label for="profile_sign">Firma: </label><input id="profile_sign" name="sign" type="text" value="<?= $this->user->sign ?>" maxlength="1024" /></p>
    <p><label for="profile_description">Descripción personal: </label><textarea id="profile_description" name="description" cols="50" rows="5"><?= $this->user->description ?></textarea></p>
    <p>(*) Campos obligatorios.</p>
    <p>(**) Las etiquetas deben separarse con comas.</p>
    <p class="submit"><input type="submit" value="Actualizar perfil" /><input type="button" value="Cancelar" onclick="location.href='<?= $this->lastPage() ?>'" /></p>
</form>
