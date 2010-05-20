<h1>Editar usuario</h1>

<center>
    <form method="post" action="#">
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
                <td><b>Rol (*):</b></td>
                <td><?= $this->role('role', $this->user->role) ?></td>
            </tr>
            <tr>
                <td><b>Codigo SISS (*):</b></td>
                <td><input type="text" name="code" value="<?= $this->user->code ?>" maxlength="9" /></td>
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
                <td colspan="2">(*) Campos obligatorios.</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>
                    <input type="submit" value="Guardar" />
                    <input type="button" value="Cancelar" onclick="location.href='<?= $this->lastPage() ?>'" />
                </td>
            </tr>
        </table>
    </form>
</center>
