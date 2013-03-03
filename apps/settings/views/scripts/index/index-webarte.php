<h1><?php echo $this->route->label ?></h1>
<p>En esta pagina usted puede configurar algunos aspectos del comportamiento del sistema, como por ejemplo: su contraseña, las notificaciones, los boletines y otros dependiendo de los modulos que esten instalados.</p>

<h2>Cambios de contraseña</h2>
<form method="post" action="" accept-charset="utf-8">
    <input type="hidden" name="return" value="<?php echo $this->lastPage() ?>" />

    <p><label>Cambio de contraseña</label>&nbsp;</p>
    <p><label>Nueva contraseña: </label><input type="password" name="password1" value="" /></p>
    <p><label>Repita la contraseña nueva: </label><input type="password" name="password2" value="" /></p>
    <p class="submit"><input name="passwd" type="submit" value="Actualizar preferencias" /><input type="button" value="Cancelar" onclick="location.href='<?php echo $this->lastPage() ?>';" /></p>
</form>

<br />
<h2>Notificaciones por correo electronico</h2>
<form method="post" action="" accept-charset="utf-8">
    <input type="hidden" name="return" value="<?php echo $this->lastPage() ?>" />

<?php $list_spaces = $this->context(NULL, 'matrix'); ?>
<?php if (count($list_spaces)) { ?>
    <dl>
    <?php foreach ($list_spaces as $category => $spaces) { ?>
        <?php if (count($spaces) <> 0) { ?>
            <dt><?php echo $this->typeSpace($category) ?></dt>
            <dd>
                <ul>
            <?php foreach ($spaces as $space) { ?>
                <li>
                <?php if ($this->user->role <> 1) { ?>
                    <input type="checkbox" name="spaces[]"
                           value="<?php echo $space ?>" <?php echo in_array($space, explode(',', $this->user->newsletter)) ? 'checked="checked"':'' ?>/>&nbsp;
                <?php } ?>
                    <?php echo $this->recipient($space) ?>
                </li>
            <?php } ?>
                </ul>
            </dd>
        <?php } ?>
    <?php } ?>
        <dt>Sugerencias</dt>
        <dd>
            <ul>
                <li>
                    <input type="checkbox" name="spaces[]"
                           value="feedback" <?php echo in_array('feedback', explode(',', $this->user->newsletter)) ? 'checked="checked"':'' ?>/>&nbsp;
                    <a href="<?php echo $this->url(array(), 'feedback_list') ?>">Sugerencias
                </li>
            </ul>
        </dd>
    </dl>
    <?php if ($this->user->role <> 1) { ?>
        <p class="center top_space"><input name="newsletter" type="submit" value="Configurar notificaciones" /></p>
    <?php } ?>
<?php } ?>
</form>
