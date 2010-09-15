<h1>Importar materias</h1>

<?php if ($this->step == 1) { ?>

    <p>Para importar materias se toman en cuenta las siguientes filas:</p>
    <ul>
        <li>Código (Imprescindible)</li>
        <li>Materia (Imprescindible)</li>
        <li>Moderador (Debe tener permiso de moderador)</li>
        <li>Visibilidad (Los valores posibles son 'public', 'register', 'private', el valor por omision es 'private')</li>
        <li>Descripción</li>
    </ul>

    <form method="post" action="" enctype="multipart/form-data" accept-charset="utf-8">
        <input type="hidden" name="return" value="<?= $this->lastPage() ?>" />
        <table>
            <tr>
                <td><b>Archivo (.csv) (2 MiB max.) (*):</b></td>
                <td><?= $this->formFile('file')?></td>
            </tr>
        <?php $first = true; ?>
        <?php foreach ($this->options as $key => $option) { ?>
            <tr>
                <td><?= $option ?></td>
                <td><input type="radio" <?= $first ? 'checked="checked" ':'' ?>name="type" value="<?= $key ?>"/></td>
            </tr>
            <?php $first = false; ?>
        <?php } ?>
            <tr>
                <td colspan="2">(*) Campos obligatorios.</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>
                    <input type="submit" value="Importar materias" />
                    <a href="<?= $this->lastPage() ?>">Cancelar</a>
                </td>
            </tr>
        </table>
    </form>

<?php } else { ?>

    <p>Por favor, revise la información siguiente, si la presentación no es correcta, por favor corrija su fichero y vuelva a subirlo:</p>

    <form method="post" action="" accept-charset="utf-8">
        <a href="<?= $this->url(array(), 'subjects_import') ?>">Subir nuevamente</a>
        <input type="submit" value="Importar materias" />
        <hr />

        <p><b>Modalidad: </b><?= $this->options[$this->type] ?></p>
        <table width="100%">
        <?php foreach ($this->results as $results) { ?>
            <tr>
                <td rowspan="4" valign="top" width="18px">
                    <input type="checkbox" name="subjects[]" <?= (($this->type == 'CREATE_NOEDIT' && $results['CODIGO_NUE']) || ($this->type == 'NOCREATE_EDIT' && !$results['CODIGO_NUE']) || ($this->type == 'CREATE_EDIT')) ? 'checked="checked"':''?> value="<?= $results['CODIGO']?>" />
                </td>
                <td><b>[<?= $results['CODIGO'] ?>] <?= $results['MATERIA'] ?></b></td>
                <td align="right">
                <?php if ($results['CODIGO_NUE']) { ?>
                    [NUEVO]&nbsp;<?php if (Yeah_Acl::hasPermission('subjects', 'new')) { ?><b>[OK]</b><?php } else { ?>No tienes permiso para crear materias.&bnsp;<b>FALLO</b><?php } ?>
                <?php } else { ?>
                    <a href="<?= $this->url(array('subject' => $results['MATERIA_OBJ']->url), 'subjects_subject_view') ?>" target="_BLANK">Ver Materia</a>
                    &nbsp;[EDICION]&nbsp;<?php if (Yeah_Acl::hasPermission('subjects', 'edit')) { ?><b>[OK]</b><?php } else { ?>No tienes permiso para editar materias.&nbsp;<b>FALLO</b><?php } ?>
                <?php } ?>
                </td>
            </tr>
            <tr>
                <td><b>Moderador: </b><?= $results['MODERADOR'] ?></td>
                <td align="right">
                <?php if (isset($results['MODERADOR_OBJ'])) { ?>
                    <a href="<?= $this->url(array('user' => $results['MODERADOR_OBJ']->url), 'users_user_view') ?>" target="_BLANK">Ver Usuario</a>&nbsp;<b>[OK]</b>
                <?php } else { ?>
                    <?= $results['MODERADOR_MES'] ?>&nbsp;<b>[FALLO]</b>
                <?php } ?>
            </tr>
            <tr>
                <td colspan="2"><b>Visibilidad: </b><?= $this->visibility(NULL, $results['VISIBILIDAD']) ?></td>
            </tr>
            <tr>
                <td colspan="2"><b>Descripción: </b><?= $results['DESCRIPCION'] ?></td>
            </tr>
        <?php } ?>
        </table>

        <hr />
        <a href="<?= $this->url(array(), 'subjects_import') ?>">Subir nuevamente</a>
        <input type="submit" value="Importar materias" />
    </form>

<?php } ?>
