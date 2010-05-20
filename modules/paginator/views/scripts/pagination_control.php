<?php if ($this->pageCount > 1) { ?>
    <b>
    <!-- Previous page link -->
    <?php if (isset($this->previous)) { ?>
        <a href="<?= $this->url(array_merge(array('page' => $this->previous), $this->route['params']), $this->route['key']) . '?page=' . $this->previous ?>">&laquo; Anterior</a> |
    <?php } ?>

    <!-- Numbered page links -->
    <?php foreach ($this->pagesInRange as $page) { ?>
        <?php if ($page != $this->current) { ?>
            <a href="<?= $this->url(array_merge(array('page' => $page), $this->route['params']), $this->route['key']) . '?page=' . $page ?>"><?= $page ?></a> |
        <?php } else { ?>
            <?= $page ?> |
        <?php } ?>
    <?php } ?>

    <!-- Next page link -->
    <?php if (isset($this->next)) { ?>
        <a href="<?= $this->url(array_merge(array('page' => $this->next), $this->route['params']), $this->route['key']) . '?page=' . $this->next ?>">Siguiente &raquo;</a>
    <?php } ?>
    </b>
<?php } ?>
