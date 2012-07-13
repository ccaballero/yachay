<?php

echo '<h1>' . $this->page->label . '</h1>';
echo '<ul>';
foreach ($this->templates as $template) {
    echo '<li>';
    echo '<b>';
    echo $template->label;
    if ($this->user->template != $template->label) {
        echo '[<a href="' . $this->url(array('template' => $template->label), 'templates_template_switch') . '">Cambiar</a>]';
    } else if ($this->acl('templates', 'configure')) {
        echo '[<a href="' . $this->url(array('template' => $template->label), 'templates_template_view') . '">Configurar</a>]';
    }
    echo '</b>';
    echo '<br/>';
    echo $template->description;
    echo '</li>';
}
echo '</ul>';
