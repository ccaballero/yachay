<?php

$list_spaces = $this->context(NULL, 'matrix');
if (count($list_spaces)) {
    echo '<table width="100%">';
    foreach ($list_spaces as $category => $spaces) {
        if (count($spaces) <> 0) {
            echo '<tr><td><b>[' . $this->typeSpace($category) . ']</b></td></tr>';
            foreach ($spaces as $space) {
                echo '<tr><td>[' . $this->recipient($space) . ']</td></tr>';
            }
        }
    }
    echo '</table>';
}

