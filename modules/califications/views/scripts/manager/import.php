<h1>Importar calificaciones</h1>

<?php if ($this->step == 1) { ?>

    <p>Para importar las calificaciones de los usuarios se toman en cuenta las siguientes filas:</p>
    <ul>
        <li>Código (Imprescindible)</li>
        <li>Los codigos definidos por el sistema de evaluación</li>
        <li>En caso de presentarse valores cualitativos, debe ingresar el valor numerico</li>
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
                <td><input type="radio" <?= $first ? 'checked="checked "':'' ?>name="type" value="<?= $key ?>" /></td>
            </tr>
            <?php $first = false; ?>
        <?php } ?>
            <tr>
                <td colspan="2">(*) Campos obligatorios.</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>
                    <input type="submit" value="Importar calificaciones" />
                    <a href="<?= $this->lastPage() ?>">Cancelar</a>
                </td>
            </tr>
        </table>
    </form>

<?php } else { ?>

    <p>Por favor, revise la información siguiente, si la presentación no es correcta, por favor corrija su fichero y vuelva a subirlo,
       los numeros encerrados entre parentesis representan calificaciones existentes que serán reemplazadas, según se establezca en la condición:
    </p>

    <form method="post" action="" accept-charset="utf-8">
        <a href="<?= $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url), 'califications_import') ?>">Subir nuevamente</a>
        <input type="submit" value="Importar calificaciones" />
        <hr />

        <p>
            <b>Condición: </b><?= $this->options[$this->type] ?>
        </p>

        <table width="100%">
            <tr>
                <td>&nbsp;</td>
                <td><b>Código</b></td>
            <?php foreach ($this->tests as $test) { ?>
                <td><b><?= $test->key ?></b></td>
            <?php } ?>
                <td>&nbsp;</td>
            </tr>
    <?php foreach ($this->results as $results) { ?>
            <tr>
                <td width="18px">
                    <input type="checkbox" name="student[]" <?= $results['RES'] == '[OK]' ? 'checked="checked"':''?> value="<?= $results['CODIGO']?>" />
                </td>
            <?php if (isset($results['USER_OBJ'])) { ?>
                <td><a href="<?= $this->url(array('user' => $results['USER_OBJ']->url), 'users_user_view') ?>"><?= $results['CODIGO'] ?></a></td>
            <?php } else { ?>
                <td><?= $results['CODIGO'] ?></td>
            <?php } ?>
            <?php foreach ($this->tests as $test) { ?>
                <?php if (isset($results['CALIF'][$test->key])) { ?>
                    <td><?= $results['EXIST'][$test->key] ? '(':'' ?><?= $results['CALIF'][$test->key] ?><?= $results['EXIST'][$test->key] ? ')':'' ?></td>
                <?php } else { ?>
                    <td>--</td>
                <?php } ?>
            <?php } ?>
                <td align="right"><?= $results['MESS'] ?>&nbsp;<b><?= $results['RES'] ?></b></td>
            </tr>
    <?php } ?>
        </table>

        <hr />
        <a href="<?= $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url), 'califications_import') ?>">Subir nuevamente</a>
        <input type="submit" value="Importar calificaciones" />
    </form>

<?php } ?>
