<h1>Olvide mi contrase&ntilde;a</h1>
<p>Escriba su direcci&oacute;n de correo electr&oacute;nico para que le enviemos una nueva contrase&ntilde;a.</p>

<center>
    <form method="post" action="#">
        <input type="hidden" name="return" value="<?= $this->lastPage() ?>" />
        <table width="60%">
            <tr>
                <td>Correo electr&oacute;nico:</td>
                <td><input type="text" name="email" value="<?= $this->values['email'] ?>" maxlength="64" /></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td><input type="submit" value="Enviar" /></td>
            </tr>
        </table>
    </form>
</center>
