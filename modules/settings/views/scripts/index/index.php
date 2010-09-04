<h1>Preferencias de usuario</h1>

<p>
    En esta pagina usted puede configurar algunos aspectos del comportamiento del sistema, como por ejemplo: 
    su contrase&ntilde;a, el aspecto, las notificaciones, los boletines y otros dependiendo de los modulos que use.
</p>

<center>
    <form method="post" action="">
        <input type="hidden" name="return" value="<?= $this->lastPage() ?>" />
        <table>
            <tr>
                <td colspan="2"><b>Cambio de contrase&ntilde;a:</b></td>
            </tr>
            <tr>
                <td>Nueva contrase&ntilde;a:</td>
                <td><input type="password" name="password1" value="" /></td>
            </tr>
            <tr>
                <td>Repita la contrase&ntilde;a nueva:</td>
                <td><input type="password" name="password2" value="" /></td>
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
