<p>Por favor, revise la información siguiente, si la presentación no es correcta, por favor corrija su fichero y vuelva a subirlo:</p>

<form method="post" action="" accept-charset="utf-8">

    <p><label class="form">Cargo: </label><span class="form"><?php echo $this->assignement(NULL, NULL, NULL, NULL, $this->type) ?></span></p>
    <p><label class="form">Inclusión: </label><span class="form"><?php echo $this->include == 'yes' ? 'Incluyendo a los usuarios a la materia, en caso de no estar.' : 'Si los usuarios no estan en la materia, se ignoran.' ?></span></p>

    <div>
<input type="button" name="import" value="Subir nuevamente" onclick="location.href='<?php echo $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url), 'groups_group_assign_import') ?>'" /><input type="submit" name="finish" value="Importar miembros" />
    </div>

    <div id="block">
    <?php foreach ($this->results as $results) { ?>
        <div class="import">
        <?php if ($results['ERROR']) { ?>
            <input type="checkbox" disabled="disabled" />
            <div class="result">
                <img src="<?php echo $this->TEMPLATE->htmlbase . 'images/error.png' ?>" alt="El usuario no existe" title="El usuario no existe" />
            </div>
            <p><span class="title"><?php echo $results['USUARIO'] ?></span></p>
        <?php } else { ?>
            <input type="checkbox" name="users[]" <?php echo !($results['ERROR'] || $results['ASSIGN_RES']) ? 'checked="checked"':''?> value="<?php echo $results['CODIGO']?>" />
            <div class="result">
            <?php if (isset($results['TYPE'])) { ?>
                <img src="<?php echo $this->TEMPLATE->htmlbase . 'images/tick.png' ?>" alt="Información valida y lista para importar" title="Información valida y lista para importar" />
            <?php } else {?>
                <img src="<?php echo $this->TEMPLATE->htmlbase . 'images/cross.png' ?>" alt="<?php echo $results['CARGO_MES'] ?>" title="<?php echo $results['CARGO_MES'] ?>" />
            <?php } ?>
            </div>
            <p><span class="title"><?php echo $results['USUARIO_OBJ']->url ?></span></p>
            <p><label>Codigo: </label><?php echo $results['CODIGO'] ?></p>
            <p><label>Usuario: </label><a href="<?php echo $this->url(array('user' => $results['USUARIO_OBJ']->url), 'users_user_view') ?>" target="_USERS_VIEW"><?php echo $results['USUARIO_OBJ']->label ?></a></p>
            <p><label>Cargo: </label><?php echo $results['CARGO'] ?></p>
        <?php } ?>
        </div>
    <?php } ?>
    </div>
    <div class="clear"></div>

    <div>
<input type="button" name="import" value="Subir nuevamente" onclick="location.href='<?php echo $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url), 'groups_group_assign_import') ?>'" /><input type="submit" name="finish" value="Importar miembros" />
    </div>
</form>
