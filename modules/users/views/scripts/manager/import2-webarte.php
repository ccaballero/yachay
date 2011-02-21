<p>Por favor, revise la información siguiente, si la presentación no es correcta, por favor corrija su fichero y vuelva a subirlo:</p>

<form method="post" action="" accept-charset="utf-8">

    <p><label class="form">Modalidad: </label><span class="form"><?= $this->options[$this->type] ?></span></p>
    <p><label class="form">Generador de contraseña: </label><span class="form"><?= $this->password(NULL, NULL, $this->password) ?></span></p>

    <div>
<input type="button" name="import" value="Subir nuevamente" onclick="location.href='<?= $this->url(array(), 'users_import') ?>'" /><input type="submit" name="finish" value="Importar usuarios" />
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
            <input type="checkbox" name="users[]" <?= ($results['CHECKED'] && isset($results['ROL_OBJ'])) ? 'checked="checked" ' : '' ?>value="<?= $results['CODIGO'] ?>" />
            <div class="result">
            <?php if (!$result) { ?>
                <img src="<?= $this->TEMPLATE->htmlbase . 'images/error.png' ?>" alt="<?= $message ?>" title="<?= $message ?>" />
            <?php } else if (!isset($results['ROL_OBJ'])) { ?>
                <img src="<?= $this->TEMPLATE->htmlbase . 'images/error.png' ?>" alt="No se ha definido un rol" title="No se ha definido un rol" />
            <?php } ?>
            <?php if ($type == 'new') { ?>
                <img src="<?= $this->TEMPLATE->htmlbase . 'images/user_add.png' ?>" alt="Nuevo usuario" title="Nuevo usuario" />
            <?php } else { ?>
                <img src="<?= $this->TEMPLATE->htmlbase . 'images/user_edit.png' ?>" alt="Edición de usuario" title="Edición de usuario" />
            <?php } ?>
            </div>
            <p><span class="title"><?= $results['NOMBRE COMPLETO'] ?></span></p>
            <p><label>Codigo: </label><?= $results['CODIGO'] ?></p>
            <p><label>Rol: </label>
            <?php if (isset($results['ROL_OBJ'])) { ?>
                <a href="<?= $this->url(array('role' => $results['ROL_OBJ']->url), 'roles_role_view') ?>" target="_ROLES_VIEW"><?= $results['ROL'] ?></a>
            <?php } else { ?>
                <?= $results['ROL'] ?>
            <?php } ?>
            </p>
        <?php if (isset($results['USUARIO_OBJ'])) { ?>
            <p><label>Usuario: </label><a href="<?= $this->url(array('user' => $results['USUARIO_OBJ']->url), 'users_user_view') ?>" target="_USERS_VIEW"><?= $results['USUARIO'] ?></a></p>
        <?php } else { ?>
            <p><label>Usuario: </label><?= $results['USUARIO'] ?></p>
        <?php } ?>
            <p><label>Correo electrónico: </label><?= $this->none($results['CORREO ELECTRONICO']) ?></p>
            <p><label>Apellidos: </label><?= $this->none($results['APELLIDOS']) ?></p>
            <p><label>Nombres: </label><?= $this->none($results['NOMBRES']) ?></p>
            <p><label>Carrera: </label>
            <?php if (!empty($results['CARRERA'])) { ?>
                <a href="<?= $this->url(array('career' => $results['CARRERA']->url), 'careers_career_view') ?>" target="_CAREERS_VIEW"><?= $results['CARRERA']->label ?></a>
            <?php } else { ?>
                <?= $this->none($results['CARRERA']) ?>
            <?php } ?>
            </p>
        </div>
    <?php } ?>
    </div>
    <div class="clear"></div>
    <div>
<input type="button" name="import" value="Subir nuevamente" onclick="location.href='<?= $this->url(array(), 'users_import') ?>'" /><input type="submit" name="finish" value="Importar usuarios" />
    </div>

</form>
