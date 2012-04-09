<p>Por favor, revise la información siguiente, si la presentación no es correcta, por favor corrija su fichero y vuelva a subirlo:</p>

<form method="post" action="" accept-charset="utf-8">

    <p><label class="form">Modalidad: </label><span class="form"><?php echo $this->options[$this->type] ?></span></p>

    <div>
<input type="button" name="import" value="Subir nuevamente" onclick="location.href='<?php echo $this->url(array(), 'subjects_import') ?>'" /><input type="submit" name="finish" value="Importar materias" />
    </div>

    <div id="block">
    <?php foreach ($this->results as $results) { ?>
        <?php
            $result = true;
            if ($results['CODIGO_NUE']) {
                $type = 'new';
                if (!$this->acl('subjects', 'new')) {
                    $result = false;
                    $message = 'No tienes permiso para crear materias.';
                }
            } else {
                $type = 'edit';
                if (!$this->acl('users', 'edit')) {
                    $result = false;
                    $message = 'No tienes permiso para editar materias.';
                }
            }
        ?>

        <div class="import">
            <input type="checkbox" name="subjects[]" <?php echo ($results['CHECKED'] && isset($results['MODERADOR_OBJ'])) ? 'checked="checked" ' : '' ?>value="<?php echo $results['CODIGO']?>" />
            <div class="result">
            <?php if (!$result) { ?>
                <img src="<?php echo $this->TEMPLATE->htmlbase . 'images/error.png' ?>" alt="<?php echo $message ?>" title="<?php echo $message ?>" />
            <?php } else if (!isset($results['MODERADOR_OBJ'])) { ?>
                <img src="<?php echo $this->TEMPLATE->htmlbase . 'images/error.png' ?>" alt="<?php echo $results['MODERADOR_MES'] ?>" title="<?php echo $results['MODERADOR_MES'] ?>" />
            <?php } ?>
            <?php if ($type == 'new') { ?>
                <img src="<?php echo $this->TEMPLATE->htmlbase . 'images/user_add.png' ?>" alt="Nueva materia" title="Nueva materia" />
            <?php } else { ?>
                <img src="<?php echo $this->TEMPLATE->htmlbase . 'images/user_edit.png' ?>" alt="Edición de materia" title="Edición de materia" />
            <?php } ?>
            </div>
            <p><span class="title"><?php echo $results['MATERIA'] ?></span></p>
            <p><label>Codigo: </label><?php echo $results['CODIGO'] ?></p>
            <p><label>Moderador: </label>
            <?php if (isset($results['MODERADOR_OBJ'])) { ?>
                <a href="<?php echo $this->url(array('user' => $results['MODERADOR_OBJ']->url), 'users_user_view') ?>" target="_USERS_VIEW"><?php echo $results['MODERADOR'] ?></a>
            <?php } else { ?>
                <?php echo $results['MODERADOR'] ?>
            <?php } ?>
            </p>
            <p><label>Visibilidad: </label><?php echo $this->visibility(NULL, NULL, $results['VISIBILIDAD']) ?></p>
            <p><label>Descripción: </label><?php echo $this->none($results['DESCRIPCION']) ?></p>
        </div>
    <?php } ?>
    </div>
    <div class="clear"></div>
    <div>
<input type="button" name="import" value="Subir nuevamente" onclick="location.href='<?php echo $this->url(array(), 'subjects_import') ?>'" /><input type="submit" name="finish" value="Importar materias" />
    </div>
</form>