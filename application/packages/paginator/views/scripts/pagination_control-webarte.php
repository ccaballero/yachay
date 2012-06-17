<div class="pagination">
<?php if ($this->pageCount > 1) { ?>
<?php if (isset($this->previous)) { ?><a href="<?php echo $this->url(array_merge(array('page' => $this->previous), $this->route['params']), $this->route['key']) . '?page=' . $this->previous ?>">&laquo; Anterior</a><?php } ?>
<?php foreach ($this->pagesInRange as $page) { ?><?php if ($page != $this->current) { ?><a href="<?php echo $this->url(array_merge(array('page' => $page), $this->route['params']), $this->route['key']) . '?page=' . $page ?>"><?php echo $page ?></a><?php } else { ?><span><?php echo $page ?></span><?php } ?><?php } ?>
<?php if (isset($this->next)) { ?><a href="<?php echo $this->url(array_merge(array('page' => $this->next), $this->route['params']), $this->route['key']) . '?page=' . $this->next ?>">Siguiente &raquo;</a><?php } ?>
<?php } ?>
</div>
