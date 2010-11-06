<?php

echo '<h1>' . $this->PAGE->label . '</h1>';
echo '<center><table width="100%"><tr>';
echo '<th>' . $this->model_pages->_mapping['label'] . '</th>';
echo '<th>' . $this->model_pages->_mapping['module'] . '</th>';
echo '<th>' . $this->model_pages->_mapping['title'] . '</th>';
echo '<th>' . $this->model_pages->_mapping['menutype'] . '</th>';
echo '<th>' . $this->model_pages->_mapping['menuorder'] . '</th>';
echo '</tr>';

foreach ($this->pages as $page) {
    echo '<tr>';
    echo '<td>' . $page->label . '</td>';
    echo '<td>' . $page->module . '</td>';
    echo '<td>' . $page->title . '</td>';
    echo '<td>' . $page->menutype . '</td>';
    echo '<td><center>' . $page->menuorder . '</center></td>';
    echo '</tr>';
}

echo '</table></center>';
