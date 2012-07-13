<p>Por favor, revise la información siguiente, si la presentación no es correcta, por favor corrija su fichero y vuelva a subirlo, los numeros encerrados entre parentesis representan calificaciones existentes que serán reemplazadas, según se establezca en la condición:</p>

<form method="post" action="" accept-charset="utf-8">
    <p><label class="form">Condición: </label><span class="form"><?php echo $this->options[$this->type] ?></span></p>

    <div>
<input type="button" name="import" value="Subir nuevamente" onclick="location.href='<?php echo $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url), 'califications_import') ?>'" /><input type="submit" name="finish" value="Importar calificaciones" />
    </div>
    <table>
        <tr>
            <th>&nbsp;</th>
            <th>Código</th>
        <?php foreach ($this->tests as $test) { ?>
            <th><?php echo $test->key ?></th>
        <?php } ?>
            <th>&nbsp;</th>
        </tr>
    <?php foreach ($this->results as $key => $results) { ?>
        <tr class="<?php echo $key % 2 == 0 ? 'even' : 'odd' ?>">
            <td><input type="checkbox" name="student[]" <?php echo $results['RES'] == '[OK]' ? 'checked="checked"':''?> value="<?php echo $results['CODIGO']?>" /></td>
        <?php if (isset($results['USER_OBJ'])) { ?>
            <td><a href="<?php echo $this->url(array('user' => $results['USER_OBJ']->url), 'users_user_view') ?>"><?php echo $results['CODIGO'] ?></a></td>
        <?php } else { ?>
            <td><?php echo $results['CODIGO'] ?></td>
        <?php } ?>
    <?php foreach ($this->tests as $test) { ?>
            <?php if (isset($results['CALIF'][$test->key])) { ?>
                <td><?php echo $results['EXIST'][$test->key] ? '(':'' ?><?php echo $results['CALIF'][$test->key] ?><?php echo $results['EXIST'][$test->key] ? ')':'' ?></td>
            <?php } else { ?>
                <td>--</td>
            <?php } ?>
        <?php } ?>
                <td align="right"><?php echo $results['MESS'] ?>&nbsp;<span class="bold"><?php echo $results['RES'] ?></span></td>
        </tr>
    <?php } ?>
    </table>
    <div>
<input type="button" name="import" value="Subir nuevamente" onclick="location.href='<?php echo $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url), 'califications_import') ?>'" /><input type="submit" name="finish" value="Importar calificaciones" />
    </div>

</form>
