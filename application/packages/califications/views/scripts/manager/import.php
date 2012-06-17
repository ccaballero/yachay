<?php

echo '<h1>' . $this->page->label . '</h1>';
if ($this->step == 1) {
    echo '<p>Para importar las calificaciones de los usuarios se toman en cuenta las siguientes filas:</p>';
    echo '<ul><li>Código (Imprescindible)</li><li>Los codigos definidos por el sistema de evaluación</li><li>En caso de presentarse valores cualitativos, debe ingresar el valor numerico</li></ul>';
    echo '<form method="post" action="" enctype="multipart/form-data" accept-charset="utf-8">';
    echo '<input type="hidden" name="return" value="' . $this->lastPage() . '" />';
    echo '<table><tr><td><b>Archivo (.csv) (2 MiB max.) (*):</b></td><td>' . $this->formFile('file') . '</td></tr>';
    $first = true;
    foreach ($this->options as $key => $option) {
        echo '<tr><td>' . $option . '</td><td><input type="radio" ' . ($first ? 'checked="checked "' : '') . 'name="type" value="' . $key . '" /></td></tr>';
        $first = false;
    }
    echo '<tr><td colspan="2">(*) Campos obligatorios.</td></tr>';
    echo '<tr><td>&nbsp;</td><td><input type="submit" value="Importar calificaciones" /> <a href="' . $this->lastPage() . '">Cancelar</a></td></tr>';
    echo '</table></form>';
} else {
    echo '<p>Por favor, revise la información siguiente, si la presentación no es correcta, por favor corrija su fichero y vuelva a subirlo, los numeros encerrados entre parentesis representan calificaciones existentes que serán reemplazadas, según se establezca en la condición:</p>';
    echo '<form method="post" action="" accept-charset="utf-8">';
    echo '<a href="' . $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url), 'califications_import') . '">Subir nuevamente</a> <input type="submit" value="Importar calificaciones" /><hr />';
    echo '<p><b>Condición: </b>' . $this->options[$this->type] . '</p>';
    echo '<table width="100%">';
    echo '<tr><td>&nbsp;</td><td><b>Código</b></td>';
    foreach ($this->tests as $test) {
        echo '<td><b>' . $test->key . '</b></td>';
    }
    echo '<td>&nbsp;</td></tr>';
    foreach ($this->results as $results) {
        echo '<tr><td width="18px"><input type="checkbox" name="student[]" ' . $results['RES'] == '[OK]' ? 'checked="checked"':''. ' value="' . $results['CODIGO']. '" /></td>';
        if (isset($results['USER_OBJ'])) {
            echo '<td><a href="' . $this->url(array('user' => $results['USER_OBJ']->url), 'users_user_view') . '">' . $results['CODIGO'] . '</a></td>';
        } else {
            echo '<td>' . $results['CODIGO'] . '</td>';
        }
        foreach ($this->tests as $test) {
            if (isset($results['CALIF'][$test->key])) {
                echo '<td>' . $results['EXIST'][$test->key] ? '(':'' . '' . $results['CALIF'][$test->key] . '' . $results['EXIST'][$test->key] ? ')':'' . '</td>';
            } else {
                echo '<td>--</td>';
            }
        }
        echo '<td align="right">' . $results['MESS'] . '&nbsp;<b>' . $results['RES'] . '</b></td></tr>';
    }
    echo '</table><hr />';
    echo '<a href="' . $this->url(array('subject' => $this->subject->url, 'group' => $this->group->url), 'califications_import') . '">Subir nuevamente</a> <input type="submit" value="Importar calificaciones" />';
    echo '</form>';
}
