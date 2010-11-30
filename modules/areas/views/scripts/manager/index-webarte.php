<h1><?= $this->PAGE->label ?></h1>

<form method="post" action="" accept-charset="utf-8">
    <input type="hidden" name="return" value="<?= $this->currentPage() ?>" />

    <div>
<?php if ($this->acl('areas', 'list')) { ?><input type="button" name="list" value="Lista" onclick="location.href='<?= $this->url(array(), 'areas_list') ?>'" /><?php } ?>
<?php if ($this->acl('areas', 'new')) { ?><input type="button" name="new" value="Nuevo" onclick="location.href='<?= $this->url(array(), 'areas_new') ?>'" /><?php } ?>
    </div>

<?php if (count($this->areas)) { ?>
    <table width="100%">
        <tr>
            <th><?= $this->model_areas->_mapping['label'] ?></th>
            <th>Opciones</th>
            <th><?= $this->model_areas->_mapping['tsregister'] ?></th>
        </tr>
    <?php foreach ($this->areas as $key => $area) { ?>
        <tr class="<?= $key % 2 == 0 ? 'even' : 'odd' ?>">
            <td><?= $area->label ?></td>
            <td class="options">
                <?php if ($this->acl('areas', 'view')) { ?>
                    <a href="<?= $this->url(array('area' => $area->url), 'areas_area_view') ?>"><img src="<?= $this->TEMPLATE->htmlbase . 'images/page_white_text.png' ?>" alt="Ver" title="Ver" /></a>
                <?php } ?>
                <?php if ($this->acl('areas', 'edit')) { ?>
                    <a href="<?= $this->url(array('area' => $area->url), 'areas_area_edit') ?>"><img src="<?= $this->TEMPLATE->htmlbase . 'images/pencil.png' ?>" alt="Editar" title="Editar" /></a>
                <?php } ?>
                <?php if ($this->acl('areas', 'delete')) { ?>
                    <?php if ($area->isEmpty()) { ?>
                    <a href="<?= $this->url(array('area' => $area->url), 'areas_area_delete') ?>"><img src="<?= $this->TEMPLATE->htmlbase . 'images/delete.png' ?>" alt="Eliminar" title="Eliminar" /></a>
                    <?php } ?>
                <?php } ?>
            </td>
            <td class="center"><?= $this->timestamp($area->tsregister) ?></td>
        </tr>
    <?php } ?>
    </table>
<?php } else { ?>
    <p>No existen areas registradas</p>
<?php } ?>

    <div>
<?php if ($this->acl('areas', 'list')) { ?><input type="button" name="list" value="Lista" onclick="location.href='<?= $this->url(array(), 'areas_list') ?>'" /><?php } ?>
<?php if ($this->acl('areas', 'new')) { ?><input type="button" name="new" value="Nuevo" onclick="location.href='<?= $this->url(array(), 'areas_new') ?>'" /><?php } ?>
    </div>
</form>
