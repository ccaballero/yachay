<h1><?= $this->PAGE->label ?></h1>

<form method="post" action="" accept-charset="utf-8">
    <input type="hidden" name="return" value="<?= $this->currentPage() ?>" />

    <div>
<?php if ($this->acl('careers', 'list')) { ?><input type="button" name="list" value="Lista" onclick="location.href='<?= $this->url(array(), 'careers_list') ?>'" /><?php } ?>
<?php if ($this->acl('careers', 'new')) { ?><input type="button" name="new" value="Nuevo" onclick="location.href='<?= $this->url(array(), 'careers_new') ?>'" /><?php } ?>
    </div>

<?php if (count($this->careers)) { ?>
    <table>
        <tr>
            <th><?= $this->model_careers->_mapping['label'] ?></th>
            <th>Opciones</th>
            <th><?= $this->model_careers->_mapping['tsregister'] ?></th>
        </tr>
    <?php foreach ($this->careers as $key => $career) { ?>
        <tr class="<?= $key % 2 == 0 ? 'even' : 'odd' ?>">
            <td><?= $career->label ?></td>
            <td class="options">
                <?php if ($this->acl('careers', 'view')) { ?>
                    <a href="<?= $this->url(array('career' => $career->url), 'careers_career_view') ?>"><img src="<?= $this->TEMPLATE->htmlbase . 'images/page_white_text.png' ?>" alt="Ver" title="Ver" /></a>
                <?php } ?>
                <?php if ($this->acl('careers', 'edit')) { ?>
                    <a href="<?= $this->url(array('career' => $career->url), 'careers_career_edit') ?>"><img src="<?= $this->TEMPLATE->htmlbase . 'images/pencil.png' ?>" alt="Editar" title="Editar" /></a>
                <?php } ?>
                <?php if ($this->acl('careers', 'delete')) { ?>
                    <?php if ($career->isEmpty()) { ?>
                    <a href="<?= $this->url(array('career' => $career->url), 'careers_career_delete') ?>"><img src="<?= $this->TEMPLATE->htmlbase . 'images/delete.png' ?>" alt="Eliminar" title="Eliminar" /></a>
                    <?php } ?>
                <?php } ?>
            </td>
            <td class="center"><?= $this->timestamp($career->tsregister) ?></td>
        </tr>
    <?php } ?>
    </table>
<?php } else { ?>
    <p>No existen carreras registradas</p>
<?php } ?>

    <div>
<?php if ($this->acl('careers', 'list')) { ?><input type="button" name="list" value="Lista" onclick="location.href='<?= $this->url(array(), 'careers_list') ?>'" /><?php } ?>
<?php if ($this->acl('careers', 'new')) { ?><input type="button" name="new" value="Nuevo" onclick="location.href='<?= $this->url(array(), 'careers_new') ?>'" /><?php } ?>
    </div>
</form>
