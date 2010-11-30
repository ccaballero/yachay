<h1><?= $this->PAGE->label ?></h1>
<?php if (count($this->areas)) { ?>
    <dl>
    <?php foreach ($this->areas as $area) { ?>
        <dt>
            <?php if ($this->acl('areas', 'view')) { ?>
                <a href="<?= $this->url(array('area' => $area->url), 'areas_area_view') ?>"><?= $area->label ?></a>
            <?php } else { ?>
                <?= $area->label ?>
            <?php } ?>
            <?php if ($this->acl('areas', 'edit')) { ?>
                <a href="<?= $this->url(array('area' => $area->url), 'areas_area_edit') ?>"><img src="<?= $this->TEMPLATE->htmlbase . 'images/pencil.png' ?>" alt="Editar" title="Editar" /></a>
            <?php } ?>
        </dt>
        <dd><p><?= $area->description ?></p></dd>
    <?php } ?>
    </dl>
<?php } else { ?>
    <p>No existen areas registradas</p>
<?php } ?>
