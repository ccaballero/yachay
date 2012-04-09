<h1><?php echo $this->PAGE->label ?></h1>

<form method="post" action="" accept-charset="utf-8">
    <input type="hidden" name="return" value="<?php echo $this->currentPage() ?>" />

    <div>
<?php if ($this->acl('careers', 'list')) { ?><input type="button" name="list" value="Lista" onclick="location.href='<?php echo $this->url(array(), 'careers_list') ?>'" /><?php } ?>
<?php if ($this->acl('careers', 'new')) { ?><input type="button" name="new" value="Nuevo" onclick="location.href='<?php echo $this->url(array(), 'careers_new') ?>'" /><?php } ?>
    </div>

<?php if (count($this->careers)) { ?>
    <table>
        <tr>
            <th><?php echo $this->model_careers->_mapping['label'] ?></th>
            <th>Opciones</th>
            <th><?php echo $this->model_careers->_mapping['tsregister'] ?></th>
        </tr>
    <?php foreach ($this->careers as $key => $career) { ?>
        <tr class="<?php echo $key % 2 == 0 ? 'even' : 'odd' ?>">
            <td><?php echo $career->label ?></td>
            <td class="options">
                <?php if ($this->acl('careers', 'view')) { ?>
                    <a href="<?php echo $this->url(array('career' => $career->url), 'careers_career_view') ?>"><img src="<?php echo $this->TEMPLATE->htmlbase . 'images/page_white_text.png' ?>" alt="Ver" title="Ver" /></a>
                <?php } ?>
                <?php if ($this->acl('careers', 'edit')) { ?>
                    <a href="<?php echo $this->url(array('career' => $career->url), 'careers_career_edit') ?>"><img src="<?php echo $this->TEMPLATE->htmlbase . 'images/pencil.png' ?>" alt="Editar" title="Editar" /></a>
                <?php } ?>
                <?php if ($this->acl('careers', 'delete')) { ?>
                    <?php if ($career->isEmpty()) { ?>
                    <a href="<?php echo $this->url(array('career' => $career->url), 'careers_career_delete') ?>"><img src="<?php echo $this->TEMPLATE->htmlbase . 'images/delete.png' ?>" alt="Eliminar" title="Eliminar" /></a>
                    <?php } ?>
                <?php } ?>
            </td>
            <td class="center"><?php echo $this->timestamp($career->tsregister) ?></td>
        </tr>
    <?php } ?>
    </table>
<?php } else { ?>
    <p>No existen carreras registradas</p>
<?php } ?>

    <div>
<?php if ($this->acl('careers', 'list')) { ?><input type="button" name="list" value="Lista" onclick="location.href='<?php echo $this->url(array(), 'careers_list') ?>'" /><?php } ?>
<?php if ($this->acl('careers', 'new')) { ?><input type="button" name="new" value="Nuevo" onclick="location.href='<?php echo $this->url(array(), 'careers_new') ?>'" /><?php } ?>
    </div>
</form>
