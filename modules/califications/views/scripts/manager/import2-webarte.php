<p>Por favor, revise la información siguiente, si la presentación no es correcta, por favor corrija su fichero y vuelva a subirlo, los numeros encerrados entre parentesis representan calificaciones existentes que serán reemplazadas, según se establezca en la condición:</p>

<form method="post" action="" accept-charset="utf-8">
    <p><label class="form">Condición: </label><span class="form"><?= $this->options[$this->type] ?></span></p>

    <div>
<input type="button" name="import" value="Subir nuevamente" onclick="location.href='<?= $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url), 'califications_import') ?>'" /><input type="submit" name="finish" value="Importar calificaciones" />
    </div>
    <table>
        <tr>
            <th>&nbsp;</th>
            <th>Código</th>
        <?php foreach ($this->tests as $test) { ?>
            <th><?= $test->key ?></th>
        <?php } ?>
            <th>&nbsp;</th>
        </tr>
    <?php foreach ($this->results as $key => $results) { ?>
        <tr class="<?= $key % 2 == 0 ? 'even' : 'odd' ?>">
            <td><input type="checkbox" name="student[]" <?= $results['RES'] == '[OK]' ? 'checked="checked"':''?> value="<?= $results['CODIGO']?>" /></td>
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
                <td align="right"><?= $results['MESS'] ?>&nbsp;<span class="bold"><?= $results['RES'] ?></span></td>
        </tr>
    <?php } ?>
    </table>
    <div>
<input type="button" name="import" value="Subir nuevamente" onclick="location.href='<?= $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url), 'califications_import') ?>'" /><input type="submit" name="finish" value="Importar calificaciones" />
    </div>

</form>
