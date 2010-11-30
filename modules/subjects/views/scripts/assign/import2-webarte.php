<p>Por favor, revise la información siguiente, si la presentación no es correcta, por favor corrija su fichero y vuelva a subirlo:</p>

<form method="post" action="" accept-charset="utf-8">

    <p><label class="form">Cargo: </label><span class="form"><?= $this->assignement(NULL, NULL, $this->type) ?></span></p>

    <div>
<input type="button" name="import" value="Subir nuevamente" onclick="location.href='<?= $this->url(array('subject' => $this->subject->url), 'subjects_subject_assign_import') ?>'" /><input type="submit" name="finish" value="Importar miembros" />
    </div>

    <div id="block">
    <?php foreach ($this->results as $results) { ?>
        <div class="import">
        <?php if ($results['ERROR']) { ?>
            <input type="checkbox" disabled="disabled" />
            <div class="result">
                <img src="<?= $this->TEMPLATE->htmlbase . 'images/error.png' ?>" alt="El usuario no existe" title="El usuario no existe" />
            </div>
            <p><span class="title"><?= $results['USUARIO'] ?></span></p>
        <?php } else { ?>
            <input type="checkbox" name="users[]" <?= !$results['ERROR'] ? 'checked="checked" ' : '' ?>value="<?= $results['CODIGO']?>" />
            <div class="result">
            <?php if (isset($results['TYPE'])) { ?>
                <img src="<?= $this->TEMPLATE->htmlbase . 'images/tick.png' ?>" alt="Información valida y lista para importar" title="Información valida y lista para importar" />
            <?php } else {?>
                <img src="<?= $this->TEMPLATE->htmlbase . 'images/cross.png' ?>" alt="<?= $results['CARGO_MES'] ?>" title="<?= $results['CARGO_MES'] ?>" />
            <?php } ?>
            </div>
            <p><span class="title"><?= $results['USUARIO_OBJ']->url ?></span></p>
            <p><label>Codigo: </label><?= $results['CODIGO'] ?></p>
            <p><label>Usuario: </label><a href="<?= $this->url(array('user' => $results['USUARIO_OBJ']->url), 'users_user_view') ?>" target="_USERS_VIEW"><?= $results['USUARIO_OBJ']->label ?></a></p>
            <p><label>Cargo: </label><?= $results['CARGO'] ?></p>
        <?php } ?>
        </div>
    <?php } ?>
    </div>
    <div class="clear"></div>
    <div>
<input type="button" name="import" value="Subir nuevamente" onclick="location.href='<?= $this->url(array('subject' => $this->subject->url), 'subjects_subject_assign_import') ?>'" /><input type="submit" name="finish" value="Importar miembros" />
    </div>
</form>