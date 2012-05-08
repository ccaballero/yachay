<p>Por favor, revise la información siguiente, si la presentación no es correcta, por favor corrija su fichero y vuelva a subirlo:</p>

<form method="post" action="" accept-charset="utf-8">

    <p><label class="form">Modalidad: </label><span class="form"><?php echo $this->options[$this->type] ?></span></p>
    <p><label class="form">Generador de contraseña: </label><span class="form"><?php echo $this->password(NULL, NULL, $this->password) ?></span></p>

    <div>
<input type="button" name="import" value="Subir nuevamente" onclick="location.href='<?php echo $this->url(array(), 'users_import') ?>'" /><input type="submit" name="finish" value="Importar usuarios" />
    </div>

    <div id="block">
    <?php foreach ($this->results as $results) { ?>
        <?php
            $result = true;
            if ($results['CODIGO_NUE']) {
                $type = 'new';
                if (!$this->acl('users', 'new')) {
                    $result = false;
                    $message = 'No tienes permiso para crear usuarios.';
                }
            } else {
                $type = 'edit';
                if (!$this->acl('users', 'edit')) {
                    $result = false;
                    $message = 'No tienes permiso para editar usuarios.';
                }
            }
        ?>

        <div class="import">
            <input type="checkbox" name="users[]" <?php echo ($results['CHECKED'] && isset($results['ROL_OBJ'])) ? 'checked="checked" ' : '' ?>value="<?php echo $results['CODIGO'] ?>" />
            <div class="result">
            <?php if (!$result) { ?>
                <img src="<?php echo $this->TEMPLATE->htmlbase . 'images/error.png' ?>" alt="<?php echo $message ?>" title="<?php echo $message ?>" />
            <?php } else if (!isset($results['ROL_OBJ'])) { ?>
                <img src="<?php echo $this->TEMPLATE->htmlbase . 'images/error.png' ?>" alt="No se ha definido un rol" title="No se ha definido un rol" />
            <?php } ?>
            <?php if ($type == 'new') { ?>
                <img src="<?php echo $this->TEMPLATE->htmlbase . 'images/user_add.png' ?>" alt="Nuevo usuario" title="Nuevo usuario" />
            <?php } else { ?>
                <img src="<?php echo $this->TEMPLATE->htmlbase . 'images/user_edit.png' ?>" alt="Edición de usuario" title="Edición de usuario" />
            <?php } ?>
            </div>
            <p><span class="title"><?php echo $results['NOMBRE COMPLETO'] ?></span></p>
            <p><label>Codigo: </label><?php echo $results['CODIGO'] ?></p>
            <p><label>Rol: </label>
            <?php if (isset($results['ROL_OBJ'])) { ?>
                <a href="<?php echo $this->url(array('role' => $results['ROL_OBJ']->url), 'roles_role_view') ?>" target="_ROLES_VIEW"><?php echo $results['ROL'] ?></a>
            <?php } else { ?>
                <?php echo $results['ROL'] ?>
            <?php } ?>
            </p>
        <?php if (isset($results['USUARIO_OBJ'])) { ?>
            <p><label>Usuario: </label><a href="<?php echo $this->url(array('user' => $results['USUARIO_OBJ']->url), 'users_user_view') ?>" target="_USERS_VIEW"><?php echo $results['USUARIO'] ?></a></p>
        <?php } else { ?>
            <p><label>Usuario: </label><?php echo $results['USUARIO'] ?></p>
        <?php } ?>
            <p><label>Correo electrónico: </label><?php echo $this->none($results['CORREO ELECTRONICO']) ?></p>
            <p><label>Apellidos: </label><?php echo $this->none($results['APELLIDOS']) ?></p>
            <p><label>Nombres: </label><?php echo $this->none($results['NOMBRES']) ?></p>
            <p><label>Carrera: </label>
            <?php if (!empty($results['CARRERA'])) { ?>
                <a href="<?php echo $this->url(array('career' => $results['CARRERA']->url), 'careers_career_view') ?>" target="_CAREERS_VIEW"><?php echo $results['CARRERA']->label ?></a>
            <?php } else { ?>
                <?php echo $this->none($results['CARRERA']) ?>
            <?php } ?>
            </p>
        </div>
    <?php } ?>
    </div>
    <div class="clear"></div>
    <div>
<input type="button" name="import" value="Subir nuevamente" onclick="location.href='<?php echo $this->url(array(), 'users_import') ?>'" /><input type="submit" name="finish" value="Importar usuarios" />
    </div>
</form>
