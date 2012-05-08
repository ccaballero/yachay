<?php

if ($this->user->role <> 1) {
    echo '<form method="post" action="' . $this->config->resources->frontController->baseUrl . '/filter_spaces" accept-charset="utf-8"><input type="hidden" name="return" value="' . $this->currentPage() . '" />';
}

$list_spaces = $this->context(NULL, 'matrix');
if (count($list_spaces)) {
    echo '<table width="100%">';
    foreach ($list_spaces as $category => $spaces) {
        if (count($spaces) <> 0) {
            echo '<tr><td><b>[' . $this->typeSpace($category) . ']</b></td></tr>';
            foreach ($spaces as $space) {
                echo '<tr><td>';
                if ($this->user->role <> 1) {
                    echo '<input type="checkbox" name="spaces[]" value="' . $space . '" ' . (!in_array($space, explode(',', $this->user->spaces)) ? 'checked="checked"' : '') . '/>';
                }

                echo '[' . $this->recipient($space) . ']</td></tr>';
            }
        }
    }
    echo '</table>';
    if ($this->user->role <> 1) {
        echo '<p><input type="submit" value="Filtrar espacios" /></p>';
    }
}

if ($this->user->role <> 1) {
    echo '</form>';
}
