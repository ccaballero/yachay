<p>Por favor, revise la información siguiente, si la presentación no es correcta, por favor corrija su fichero y vuelva a subirlo:</p>

<form method="post" action="" accept-charset="utf-8">

    <p><label class="form">Modalidad: </label><span class="form"><?= $this->options[$this->type] ?></span></p>

    <div>
<input type="button" name="import" value="Subir nuevamente" onclick="location.href='<?= $this->url(array(), 'subjects_import') ?>'" /><input type="submit" name="finish" value="Importar materias" />
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
            <input type="checkbox" name="subjects[]" <?= ($results['CHECKED'] && isset($results['MODERADOR_OBJ'])) ? 'checked="checked" ' : '' ?>value="<?= $results['CODIGO']?>" />
            <div class="result">
            <?php if (!$result) { ?>
                <img src="<?= $this->TEMPLATE->htmlbase . 'images/error.png' ?>" alt="<?= $message ?>" title="<?= $message ?>" />
            <?php } else if (!isset($results['MODERADOR_OBJ'])) { ?>
                <img src="<?= $this->TEMPLATE->htmlbase . 'images/error.png' ?>" alt="<?= $results['MODERADOR_MES'] ?>" title="<?= $results['MODERADOR_MES'] ?>" />
            <?php } ?>
            <?php if ($type == 'new') { ?>
                <img src="<?= $this->TEMPLATE->htmlbase . 'images/user_add.png' ?>" alt="Nueva materia" title="Nueva materia" />
            <?php } else { ?>
                <img src="<?= $this->TEMPLATE->htmlbase . 'images/user_edit.png' ?>" alt="Edición de materia" title="Edición de materia" />
            <?php } ?>
            </div>
            <p><span class="title"><?= $results['MATERIA'] ?></span></p>
            <p><label>Codigo: </label><?= $results['CODIGO'] ?></p>
            <p><label>Moderador: </label>
            <?php if (isset($results['MODERADOR_OBJ'])) { ?>
                <a href="<?= $this->url(array('user' => $results['MODERADOR_OBJ']->url), 'users_user_view') ?>" target="_USERS_VIEW"><?= $results['MODERADOR'] ?></a>
            <?php } else { ?>
                <?= $results['MODERADOR'] ?>
            <?php } ?>
            </p>
            <p><label>Visibilidad: </label><?= $this->visibility(NULL, NULL, $results['VISIBILIDAD']) ?></p>
            <p><label>Descripción: </label><?= $this->none($results['DESCRIPCION']) ?></p>
        </div>
    <?php } ?>
    </div>
    <div class="clear"></div>
    <div>
<input type="button" name="import" value="Subir nuevamente" onclick="location.href='<?= $this->url(array(), 'subjects_import') ?>'" /><input type="submit" name="finish" value="Importar materias" />
    </div>
</form>