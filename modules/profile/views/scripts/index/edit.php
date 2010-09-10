<h1><?= $this->utf2html($this->none($this->user->getFullName())) ?></h1>

<p>
    En esta pagina usted debe establecer la informacion que es solicitada, asegurese de mantenerla siempre 
    actualizada, para no tener problemas en el uso del sistema.
</p>

<center>
    <form method="post" action="" enctype="multipart/form-data" accept-charset="utf-8">
        <input type="hidden" name="return" value="<?= $this->lastPage() ?>" />
        <table>
            <tr>
                <td><b>Nombre de usuario (*):</b></td>
                <td><input type="text" name="label" value="<?= $this->user->label ?>" maxlength="20" /></td>
            </tr>
            <tr>
                <td><b>Correo electronico (*):</b></td>
                <td><input type="text" name="email" value="<?= $this->user->email ?>" maxlength="50" /></td>
            </tr>
            <tr>
                <td><b>Apellidos (*):</b></td>
                <td><input type="text" name="surname" value="<?= $this->utf2html($this->user->surname) ?>" maxlength="128" /></td>
            </tr>
            <tr>
                <td><b>Nombres (*):</b></td>
                <td><input type="text" name="name" value="<?= $this->utf2html($this->user->name) ?>" maxlength="128" /></td>
            </tr>
            <tr>
                <td><b>Fecha de nacimiento:</b></td>
                <td><?= $this->date('birthdate', $this->user->birthdate) ?></td>
            </tr>
            <tr>
                <td><b>Carrera:</b></td>
                <td><?= $this->career('career', $this->user->career) ?></td>
            </tr>
            <tr>
                <td><b>Telefono:</b></td>
                <td><input type="text" name="phone" value="<?= $this->user->phone ?>" maxlength="64" /></td>
            </tr>
            <tr>
                <td><b>Celular:</b></td>
                <td><input type="text" name="cellphone" value="<?= $this->user->cellphone ?>" maxlength="64" /></td>
            </tr>
            <tr>
                <td><b>Avatar:</b></td>
                <td><?= $this->formFile('file')?></td>
            </tr>
            <tr>
                <td><b>Intereses:</b></td>
                <td><input type="text" name="interests" value="<?= $this->utf2html($this->user->interests) ?>" maxlength="1024" /></td>
            </tr>
            <tr>
                <td><b>Pasatiempos:</b></td>
                <td><input type="text" name="hobbies" value="<?= $this->utf2html($this->user->hobbies) ?>" maxlength="1024" /></td>
            </tr>
            <tr>
                <td><b>Firma:</b></td>
                <td><input type="text" name="sign" value="<?= $this->utf2html($this->user->sign) ?>" maxlength="1024" /></td>
            </tr>
            <tr>
                <td colspan="2"><b>Descripcion personal:</b></td>
            </tr>
            <tr>
                <td colspan="2"><textarea name="description"><?= $this->utf2html($this->user->description) ?></textarea></td>
            </tr>
            <tr>
                <td colspan="2">(*) Campos obligatorios.</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>
                    <input type="submit" value="Actualizar" />
                    <a href="<?= $this->lastPage() ?>">Cancelar</a>
                </td>
            </tr>
        </table>
    </form>
</center>
