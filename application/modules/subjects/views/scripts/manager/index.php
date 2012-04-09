<?php

echo '<h1>' . $this->PAGE->label . '</h1>';
if (!empty($this->gestion)) {
    echo '<i><b>Gestion: </b>' . $this->gestion->label . '</i>';
}

echo '<form method="post" action="" accept-charset="utf-8">';
echo '<input type="hidden" name="return" value="' . $this->currentPage() . '" />';

echo '<table><tr>';
if ($this->acl('subjects', 'list')) {
    echo '<td>[<a href="' . $this->url(array(), 'subjects_list') . '">Lista</a>]</td>';
}
if ($this->acl('subjects', 'new')) {
    echo '<td>[<a href="' . $this->url(array(), 'subjects_new') . '">Nuevo</a>]</td>';
}
if ($this->acl('subjects', 'lock')) {
    echo '<td><input type="submit" name="unlock" value="Activar" /></td>';
    echo '<td><input type="submit" name="lock" value="Desactivar" /></td>';
}
if ($this->acl('subjects', 'delete')) {
    echo '<td><input type="submit" name="delete" value="Eliminar" /></td>';
}
if ($this->acl('subjects', 'import')) {
    echo '<td>[<a href="' . $this->url(array(), 'subjects_import') . '">Importar</a>]</td>';
}
if ($this->acl('subjects', 'export')) {
    echo '<td>[<a href="' . $this->url(array(), 'subjects_export') . '">Exportar</a>]</td>';
}
echo '</tr></table>';
echo '<hr />';

if (count($this->subjects)) {
    echo '<center><table width="100%"><tr>';
    echo '<th>&nbsp;</th><th>' . $this->model_subjects->_mapping['code'] . '</th><th>' . $this->model_subjects->_mapping['label'] . '</th><th>Opciones</th>';
    echo '<th>' . $this->model_subjects->_mapping['tsregister'] . '</th></tr>';

    foreach ($this->subjects as $subject) {
        echo '<tr><td>';

        if ($this->acl('subjects', array('lock', 'delete'))) {
            echo '<input type="checkbox" name="check[]" value="' . $subject->ident . '" />';
        }

        echo '</td><td><center>' . $subject->code . '</center></td>';
        echo '<td>' . $subject->label . '</td><td>';

        if ($this->acl('subjects', 'view')) {
            echo '<a href="' . $this->url(array('subject' => $subject->url), 'subjects_subject_view') . '">Ver</a> ';
        }
        if ($this->acl('subjects', 'edit')) {
            echo '<a href="' . $this->url(array('subject' => $subject->url), 'subjects_subject_edit') . '">Editar</a> ';
        }
        if ($this->acl('subjects', 'lock')) {
            if ($subject->status == 'inactive') {
                echo '<a href="' . $this->url(array('subject' => $subject->url), 'subjects_subject_unlock') . '">Activar</a> ';
            } else {
                echo '<a href="' . $this->url(array('subject' => $subject->url), 'subjects_subject_lock') . '">Desactivar</a> ';
            }
        }
        if ($this->acl('subjects', 'delete') && $subject->isEmpty()) {
            echo '<a href="' . $this->url(array('subject' => $subject->url), 'subjects_subject_delete') . '">Eliminar</a>';
        }
        echo '</td><td><center>' . $this->timestamp($subject->tsregister) . '</center></td></tr>';
    }
    echo '</table></center>';
} else {
    echo '<p>No existen materias registradas en la gestión</p>';
}

echo '<hr />';
echo '<table><tr>';
if ($this->acl('subjects', 'list')) {
    echo '<td>[<a href="' . $this->url(array(), 'subjects_list') . '">Lista</a>]</td>';
}
if ($this->acl('subjects', 'new')) {
    echo '<td>[<a href="' . $this->url(array(), 'subjects_new') . '">Nuevo</a>]</td>';
}
if ($this->acl('subjects', 'lock')) {
    echo '<td><input type="submit" name="unlock" value="Activar" /></td>';
    echo '<td><input type="submit" name="lock" value="Desactivar" /></td>';
}
if ($this->acl('subjects', 'delete')) {
    echo '<td><input type="submit" name="delete" value="Eliminar" /></td>';
}
if ($this->acl('subjects', 'import')) {
    echo '<td>[<a href="' . $this->url(array(), 'subjects_import') . '">Importar</a>]</td>';
}
if ($this->acl('subjects', 'export')) {
    echo '<td>[<a href="' . $this->url(array(), 'subjects_export') . '">Exportar</a>]</td>';
}
echo '</tr></table>';

echo '</form>';
