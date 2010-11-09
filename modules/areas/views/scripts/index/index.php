<h1><?= $this->PAGE->label ?></h1>

<?php if (count($this->areas)) { ?>
    <ul>
    <?php foreach ($this->areas as $area) { ?>
        <li>
            <?php if ($this->acl('areas', 'view')) { ?>
            <a href="<?= $this->url(array('area' => $area->url), 'areas_area_view') ?>">
                <b><?= $area->label ?></b>
            </a>
            <?php } else { ?>
                <b><?= $area->label ?></b>
            <?php } ?>
            &nbsp;
            <?php if ($this->acl('areas', 'edit')) { ?>
                <b><i>[<a href="<?= $this->url(array('area' => $area->url), 'areas_area_edit') ?>">Editar</a>]</i></b>
            <?php } ?>
            <br />
            <i><?= $area->description ?></i>
        </li>
    <?php } ?>
    </ul>
<?php } else { ?>
<p>No existen areas registradas</p>
<?php } ?>
