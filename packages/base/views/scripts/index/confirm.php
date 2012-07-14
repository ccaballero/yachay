<h1>Confirmación</h1>

<form method="post" action="<?php echo $this->return ?>" accept-charset="utf-8">
    <p><?php echo $this->message ?></p>
    <p class="submit">
        <input type="submit" value="Aceptar" />
        <input type="button" value="Cancelar" onclick="location.href='<?php echo $this->currentPage() ?>'" />
        <input type="hidden" name="return" value="<?php echo $this->currentPage() ?>" />
    </p>
</form>
