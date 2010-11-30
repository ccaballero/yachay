<p>Por favor, revise la información siguiente, si la presentación no es correcta, por favor corrija su fichero y vuelva a subirlo:</p>

<form method="post" action="" accept-charset="utf-8">

    <p><label class="form">Cargo: </label><span class="form"><?= $this->assignement(NULL, NULL, NULL, NULL, $this->type) ?></span></p>
    <p><label class="form">Inclusión: </label><span class="form"><?= $this->include == 'yes' ? 'Incluyendo a los usuarios a la materia, en caso de no estar.' : 'Si los usuarios no estan en la materia, se ignoran.' ?></span></p>

    <div>
<input type="button" name="import" value="Subir nuevamente" onclick="location.href='<?= $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url), 'groups_group_assign_import') ?>'" /><input type="submit" name="finish" value="Importar miembros" />
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
            <input type="checkbox" name="users[]" <?= !($results['ERROR'] || $results['ASSIGN_RES']) ? 'checked="checked"':''?> value="<?= $results['CODIGO']?>" />
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
<input type="button" name="import" value="Subir nuevamente" onclick="location.href='<?= $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url), 'groups_group_assign_import') ?>'" /><input type="submit" name="finish" value="Importar miembros" />
    </div>
</form>
