<p>Para importar usuarios se toman en cuenta las siguientes filas:</p>
<ul>
    <li>Código (Imprescindible)</li>
    <li>Nombre Completo (Imprescindible, útil para exportación de datos)</li>
    <li>Correo electrónico</li>
    <li>Rol (Si no se especifica, se usa el rol especificado mas abajo)</li>
    <li>Usuario (Si no se especifica, se usa el código)</li>
    <li>Apellidos</li>
    <li>Nombres</li>
    <li>Carrera</li>
</ul>

<form method="post" action="" enctype="multipart/form-data" accept-charset="utf-8">
    <input type="hidden" name="return" value="<?php echo $this->lastPage() ?>" />

    <p><label for="file">Archivo (.csv) (2 MiB max.) (*): </label><?php echo $this->formFile('file') ?></p>
    <?php $first = true; ?>
<?php foreach ($this->options as $key => $option) { ?>
    <p><label>&nbsp;</label><span><input type="radio" <?php echo $first ? 'checked="checked" ':'' ?>name="type" value="<?php echo $key ?>" /></span> <span class="form"><?php echo $option ?></span></p>
    <?php $first = false; ?>
<?php } ?>
    <p><label for="user_role">Rol: </label><?php echo $this->role('role', 'role') ?></p>
    <p><label for="user_password">Generador de contraseña: </label><?php echo $this->password('password', 'password') ?></p>
    <p>(*) Campos obligatorios.</p>
    <p class="submit"><input type="submit" value="Importar usuarios" /><input type="button" value="Cancelar" onclick="location.href='<?php echo $this->lastPage() ?>'" /></p>
</form>
