<h1><?= $this->PAGE->label ?></h1>

<form method="post" action="" accept-charset="utf-8">
    <input type="hidden" name="return" value="<?= $this->currentPage() ?>" />

    <div>
<?php if ($this->acl('gestions', 'list')) { ?><input type="button" name="list" value="Lista" onclick="location.href='<?= $this->url(array(), 'gestions_list') ?>'" /><?php } ?>
<?php if ($this->acl('gestions', 'new')) { ?><input type="button" name="new" value="Nuevo" onclick="location.href='<?= $this->url(array(), 'gestions_new') ?>'" /><?php } ?>
<?php if ($this->acl('gestions', 'active')) { ?><input type="submit" name="update" value="Actualizar" /><?php } ?>
    </div>

<?php if (count($this->gestions)) { ?>
    <table>
        <tr>
            <th>&nbsp;</th>
            <th><?= $this->model_gestions->_mapping['label'] ?></th>
            <th><?= $this->model_gestions->_mapping['status'] ?></th>
            <th>Opciones</th>
            <th><?= $this->model_gestions->_mapping['tsregister'] ?></th>
        </tr>
    <?php foreach ($this->gestions as $key => $gestion) { ?>
        <tr class="<?= $key % 2 == 0 ? 'even' : 'odd' ?>">
            <td>
        <?php if ($this->acl('gestions', 'active')) { ?>
            <?php if ($gestion->status == 'active') { ?>
                <input type="radio" checked="checked" name="radio" value="<?= $gestion->ident ?>" />
            <?php } else { ?>
                <input type="radio" name="radio" value="<?= $gestion->ident ?>" />
            <?php } ?>
        <?php } ?>
            </td>
            <td><?= $gestion->label ?></td>
            <td class="center">
            <?php if ($gestion->status == 'active') { ?>
                <img src="<?= $this->TEMPLATE->htmlbase . 'images/tick.png' ?>" alt="Gestión activa" title="Gestión activa" />
            <?php } else { ?>
                <img src="<?= $this->TEMPLATE->htmlbase . 'images/cross.png' ?>" alt="Gestión inactiva" title="Gestión inactiva" />
            <?php } ?>
            </td>
            <td class="options">
                <?php if ($this->acl('gestions', 'view')) { ?>
                    <a href="<?= $this->url(array('gestion' => $gestion->url), 'gestions_gestion_view') ?>"><img src="<?= $this->TEMPLATE->htmlbase . 'images/page_white_text.png' ?>" alt="Ver" title="Ver" /></a>
                <?php } ?>
                <?php if ($this->acl('gestions', 'active') && $gestion->status == 'inactive') { ?>
                    <a href="<?= $this->url(array('gestion' => $gestion->url), 'gestions_gestion_active') ?>"><img src="<?= $this->TEMPLATE->htmlbase . 'images/key.png' ?>" alt="Activar" title="Activar" /></a>
                <?php } ?>
                <?php if ($this->acl('gestions', 'delete') && $gestion->status == 'inactive' && $gestion->isEmpty()) { ?>
                    <a href="<?= $this->url(array('gestion' => $gestion->url), 'gestions_gestion_delete') ?>"><img src="<?= $this->TEMPLATE->htmlbase . 'images/delete.png' ?>" alt="Eliminar" title="Eliminar" /></a>
                <?php } ?>
            </td>
            <td><center><?= $this->timestamp($gestion->tsregister) ?></center></td>
        </tr>
    <?php } ?>
    </table>
<?php } else { ?>
    <p>No existen gestiones registradas</p>
<?php } ?>

    <div>
<?php if ($this->acl('gestions', 'list')) { ?><input type="button" name="list" value="Lista" onclick="location.href='<?= $this->url(array(), 'gestions_list') ?>'" /><?php } ?>
<?php if ($this->acl('gestions', 'new')) { ?><input type="button" name="new" value="Nuevo" onclick="location.href='<?= $this->url(array(), 'gestions_new') ?>'" /><?php } ?>
<?php if ($this->acl('gestions', 'active')) { ?><input type="submit" name="update" value="Actualizar" /><?php } ?>
    </div>
</form>
