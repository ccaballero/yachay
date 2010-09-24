<h1>Importar miembros</h1>

<?php if ($this->step == 1) { ?>

    <p>Para importar la asignación de usuarios se toman en cuenta las siguientes filas:</p>
    <ul>
        <li>Código o Usuario (Imprescindible)</li>
        <li>Cargo (Si no se especifica, se usa el cargo especificado mas abajo)</li>
    </ul>

    <form method="post" action="" enctype="multipart/form-data" accept-charset="utf-8">
        <input type="hidden" name="return" value="<?= $this->lastPage() ?>" />
        <table>
            <tr>
                <td><b>Archivo (.csv) (2 MiB max.) (*):</b></td>
                <td><?= $this->formFile('file')?></td>
            </tr>
            <tr>
                <td><b>Cargo:</b></td>
                <td><?= $this->assignement(NULL, NULL, NULL, 'type') ?></td>
            </tr>
            <tr>
                <td colspan="2">(*) Campos obligatorios.</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>
                    <input type="submit" value="Importar miembros" />
                    <a href="<?= $this->lastPage() ?>">Cancelar</a>
                </td>
            </tr>
        </table>
    </form>

<?php } else { ?>

    <p>Por favor, revise la información siguiente, si la presentación no es correcta, por favor corrija su fichero y vuelva a subirlo:</p>

    <form method="post" action="" accept-charset="utf-8">
        <a href="<?= $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url), 'groups_group_assign_import') ?>">Subir nuevamente</a>
        <input type="submit" value="Importar usuarios" />
        <hr />

        <p>
            <b>Cargo: </b><?= $this->assignement(NULL, NULL, NULL, NULL, $this->type) ?>
        </p>

        <table width="100%">
    <?php foreach ($this->results as $results) { ?>
        <?php if ($results['ERROR']) { ?>
            <tr>
                <td rowspan="2" valign="top" width="18px">
                    <input type="checkbox" disabled="disabled" />
                </td>
                <td><b><?= $results['USUARIO'] ?></b></td>
                <td align="right">El usuario no existe <b>[FALLO]</b></td>
            </tr>
        <?php } else { ?>
            <tr>
                <td rowspan="2" valign="top" width="18px">
                    <input type="checkbox" name="users[]" <?= !($results['ERROR'] || $results['ASSIGN_RES']) ? 'checked="checked"':''?> value="<?= $results['CODIGO']?>" />
                </td>
                <td><b>[<?= $results['CODIGO'] ?>] <?= $results['USUARIO_OBJ']->label ?></b></td>
                <td align="right"><a href="<?= $this->url(array('user' => $results['USUARIO_OBJ']->url), 'users_user_view') ?>" target="_BLANK">Ver Usuario</a> <b>[OK]</b></td>
            </tr>
            <tr>
                <td><b>Cargo: </b><?= $results['CARGO'] ?></td>
                <td align="right">
                <?php if (isset($results['TYPE'])) { ?>
                    <b>[OK]</b>
                <?php } else {?>
                    <?= $results['CARGO_MES'] ?> <b>[FALLO]</b>
                <?php } ?>
                </td>
            </tr>
        <?php } ?>
    <?php } ?>
        </table>

        <hr />
        <a href="<?= $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url), 'groups_group_assign_import') ?>">Subir nuevamente</a>
        <input type="submit" value="Importar usuarios" />

    </form>

<?php } ?>
