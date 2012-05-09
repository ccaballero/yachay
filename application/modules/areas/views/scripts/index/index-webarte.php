<h1><?php echo $this->page->label ?></h1>
<?php if (count($this->areas)) { ?>
    <dl>
    <?php foreach ($this->areas as $area) { ?>
        <dt>
            <?php if ($this->acl('areas', 'view')) { ?>
                <a href="<?php echo $this->url(array('area' => $area->url), 'areas_area_view') ?>"><?php echo $area->label ?></a>
            <?php } else { ?>
                <?php echo $area->label ?>
            <?php } ?>
            <?php if ($this->acl('areas', 'edit')) { ?>
                <a href="<?php echo $this->url(array('area' => $area->url), 'areas_area_edit') ?>"><img src="<?php echo $this->template->htmlbase . 'images/pencil.png' ?>" alt="Editar" title="Editar" /></a>
            <?php } ?>
        </dt>
        <dd><p><?php echo $area->description ?></p></dd>
    <?php } ?>
    </dl>
<?php } else { ?>
    <p>No existen areas registradas</p>
<?php } ?>
