<h1>Acceso al sistema</h1>
<p>Para acceder al sistema, debe colocar su nombre de usuario y la contrase&ntilde;a que le haya sido provista.</p>

<center>
    <form method="post" action="" accept-charset="utf-8">
        <input type="hidden" name="return" value="<?= $this->lastPage() ?>" />
        <table width="60%">
            <tr>
                <td>Usuario:</td>
                <td><input type="text" name="username" value="<?= $this->values['username'] ?>" maxlength="32" /></td>
            </tr>
            <tr>
                <td>Contrase&ntilde;a:</td>
                <td><input type="password" name="password" maxlength="32" /></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td><input type="submit" value="Ingresar" /></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>
                    <a href="<?= $this->url(array(), 'login_forgot') ?>">Olvide mi contrase&ntilde;a</a>
                </td>
            </tr>
        </table>
    </form>
</center>
