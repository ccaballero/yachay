<?php

if ($this->pageCount > 1) {
    echo '<b>';
    if (isset($this->previous)) {
        echo '<a href="' . $this->url(array_merge(array('page' => $this->previous), $this->pager['params']), $this->pager['key']) . '?page=' . $this->previous . '">&laquo; Anterior</a> | ';
    }

    foreach ($this->pagesInRange as $page) {
        if ($page != $this->current) {
            echo '<a href="' . $this->url(array_merge(array('page' => $page), $this->pager['params']), $this->pager['key']) . '?page=' . $page . '">' . $page . '</a> | ';
        } else {
            echo $page . ' | ';
        }
    }

    if (isset($this->next)) {
        echo '<a href="' . $this->url(array_merge(array('page' => $this->next), $this->pager['params']), $this->pager['key']) . '?page=' . $this->next . '">Siguiente &raquo;</a>';
    }
    echo '</b>';
}
