<?php

echo '<h1>' . $this->PAGE->label . '</h1>';
echo '<form method="post" action="" accept-charset="utf-8">';
echo '<input type="hidden" name="return" value="' . $this->currentPage() . '" />';

echo '<table><tr>';
if (Yeah_Acl::hasPermission('modules', 'list')) {
    echo '<td>[<a href="' . $this->url(array(), 'modules_list') . '">Lista</a>]</td>';
}
if (Yeah_Acl::hasPermission('modules', 'new')) {
    echo '<td>[<a href="' . $this->url(array(), 'modules_new') . '">Nuevo</a>]</td>';
}
if (Yeah_Acl::hasPermission('modules', 'lock')) {
    echo '<td><input type="submit" name="unlock" value="Activar" /></td>';
    echo '<td><input type="submit" name="lock" value="Desactivar" /></td>';
}
echo '</tr></table>';

echo '<hr />';

if (count($this->modules)) {
    echo '<center>';
    echo '<table width="100%"><tr><th>&nbsp;</th>';
    echo '<th>' . $this->model_modules->_mapping['label'] . '</th>';
    echo '<th>' . $this->model_modules->_mapping['type'] . '</th>';
    echo '<th>Opciones</th>';
    echo '<th>' . $this->model_modules->_mapping['tsregister'] . '</th>';
    echo '</tr>';

    foreach ($this->modules as $module) {
        echo '<tr><td>';
        if (Yeah_Acl::hasPermission('modules', 'lock')) {
            echo '<input type="checkbox" name="check[]" value="' . $module->ident . '" />';
        }
        echo '</td>';
        echo '<td>' . $module->label . '</td>';
        echo '<td>' . $module->type . '</td>';
        echo '<td><center>';

        if (Yeah_Acl::hasPermission('modules', 'view')) {
            echo '<a href="' . $this->url(array('mod' => $module->url), 'modules_module_view') . '">Ver</a> ';
        }
        if (Yeah_Acl::hasPermission('modules', 'lock')) {
            if ($module->status == 'active') {
                echo '<a href="' . $this->url(array('mod' => $module->url), 'modules_module_lock') . '">Desactivar</a>';
            } else {
                echo '<a href="' . $this->url(array('mod' => $module->url), 'modules_module_unlock') . '">Activar</a>';
            }
        }

        echo '</center></td>';
        echo '<td><center>' . $this->timestamp($module->tsregister) . '</center></td>';
        echo '</tr>';
    }

    echo '</table></center>';
} else {
    echo '<p>No existen modulos registrados</p>';
}
echo '<hr />';

echo '<table><tr>';
if (Yeah_Acl::hasPermission('modules', 'list')) {
    echo '<td>[<a href="' . $this->url(array(), 'modules_list') . '">Lista</a>]</td>';
}
if (Yeah_Acl::hasPermission('modules', 'new')) {
    echo '<td>[<a href="' . $this->url(array(), 'modules_new') . '">Nuevo</a>]</td>';
}
if (Yeah_Acl::hasPermission('modules', 'lock')) {
    echo '<td><input type="submit" name="unlock" value="Activar" /></td>';
    echo '<td><input type="submit" name="lock" value="Desactivar" /></td>';
}
echo '</tr></table>';
echo '</form>';
