<h1>Lista de areas</h1>

<?php if (count($this->areas)) { ?>
    <ul>
    <?php foreach ($this->areas as $area) { ?>
        <li>
            <?php if (Yeah_Acl::hasPermission('areas', 'view')) { ?>
            <a href="<?= $this->url(array('area' => $area->url), 'areas_area_view') ?>">
                <b><?= $this->utf2html($area->label) ?></b>
            </a>
            <?php } else { ?>
                <b><?= $this->utf2html($area->label) ?></b>
            <?php } ?>
            &nbsp;
            <?php if (Yeah_Acl::hasPermission('areas', 'edit')) { ?>
                <b><i>[<a href="<?= $this->url(array('area' => $area->url), 'areas_area_edit') ?>">Editar</a>]</i></b>
            <?php } ?>
            <br />
            <i><?= $this->utf2html($area->description) ?></i>
        </li>
    <?php } ?>
    </ul>
<?php } else { ?>
<p>No existen areas registradas</p>
<?php } ?>
