<p><?php echo $this->user->getFullName() ?> miembro de la comunidad <?php echo $this->site ?> ha querido compartir contigo una invitación
de acceso para formar parte de esta comunidad.</p>

<?php if (!empty($this->message)) { ?>
    <p>Ademas dejo el siguiente mensaje:</p>
    <center>&quot;<?php echo $this->message ?>&quot;</center>
<?php } ?>
<br />

<p>
    Te recomendamos que aceptes esta invitaci&oacute;n solo si conoces a este usuario y estas seguro que su intenci&oacute;n
    era concederte acceso al sistema.
</p>

<p>
    Esta es una invitaci&oacute;n que puedes aceptar en cualquier momento y no tiene fecha de expiraci&oacute;n, a no ser que el
    miembro que te invito revoque la invitaci&oacute;n antes que la hayas aceptado.
</p>
<br />

<p>
    Para continuar con tu proceso de registro, debes seguir el siguiente enlace:
</p>

<center>
    <a href="<?php echo $this->url ?>">Acceder al sistema</a>
</center>
