<p>
    Usted ha pedido una renovaci&oacute;n de su contrase&ntilde;a en el servidor <?= $this->servername ?>.
</p>
<br />
<p>
    Ingrese la siguiente contrase&ntilde;a en el formulario de acceso:
</p>
<br />
    <center>
        <?= $this->code ?>
    </center>
<br />
<p>
    Recuerde que esta contrase&ntilde;a sirve para un acceso y tiene una validez de 24 horas a partir
    de la fecha de petici&oacute;n.
</p>
<br />
<p>
    <i><b>Fecha de petici&oacute;n:</b>&nbsp;<?= $this->timestamp($this->petition) ?></i>
    <br/>
    <i><b>Fecha de expiraci&oacute;n:</b>&nbsp;<?= $this->timestamp($this->expiration) ?></i>
</p>
