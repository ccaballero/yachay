<h1><?php echo $this->PAGE->label ?></h1>

<form method="post" action="" accept-charset="utf-8">
    <input type="hidden" name="return" value="<?php echo $this->currentPage() ?>" />

    <div>
<?php if ($this->acl('gestions', 'list')) { ?><input type="button" name="list" value="Lista" onclick="location.href='<?php echo $this->url(array(), 'gestions_list') ?>'" /><?php } ?>
<?php if ($this->acl('gestions', 'new')) { ?><input type="button" name="new" value="Nuevo" onclick="location.href='<?php echo $this->url(array(), 'gestions_new') ?>'" /><?php } ?>
<?php if ($this->acl('gestions', 'active')) { ?><input type="submit" name="update" value="Actualizar" /><?php } ?>
    </div>

<?php if (count($this->gestions)) { ?>
    <table>
        <tr>
            <th>&nbsp;</th>
            <th><?php echo $this->model_gestions->_mapping['label'] ?></th>
            <th><?php echo $this->model_gestions->_mapping['status'] ?></th>
            <th>Opciones</th>
            <th><?php echo $this->model_gestions->_mapping['tsregister'] ?></th>
        </tr>
    <?php foreach ($this->gestions as $key => $gestion) { ?>
        <tr class="<?php echo $key % 2 == 0 ? 'even' : 'odd' ?>">
            <td>
        <?php if ($this->acl('gestions', 'active')) { ?>
            <?php if ($gestion->status == 'active') { ?>
                <input type="radio" checked="checked" name="radio" value="<?php echo $gestion->ident ?>" />
            <?php } else { ?>
                <input type="radio" name="radio" value="<?php echo $gestion->ident ?>" />
            <?php } ?>
        <?php } ?>
            </td>
            <td><?php echo $gestion->label ?></td>
            <td class="center">
            <?php if ($gestion->status == 'active') { ?>
                <img src="<?php echo $this->TEMPLATE->htmlbase . 'images/tick.png' ?>" alt="Gestión activa" title="Gestión activa" />
            <?php } else { ?>
                <img src="<?php echo $this->TEMPLATE->htmlbase . 'images/cross.png' ?>" alt="Gestión inactiva" title="Gestión inactiva" />
            <?php } ?>
            </td>
            <td class="options">
                <?php if ($this->acl('gestions', 'view')) { ?>
                    <a href="<?php echo $this->url(array('gestion' => $gestion->url), 'gestions_gestion_view') ?>"><img src="<?php echo $this->TEMPLATE->htmlbase . 'images/page_white_text.png' ?>" alt="Ver" title="Ver" /></a>
                <?php } ?>
                <?php if ($this->acl('gestions', 'active') && $gestion->status == 'inactive') { ?>
                    <a href="<?php echo $this->url(array('gestion' => $gestion->url), 'gestions_gestion_active') ?>"><img src="<?php echo $this->TEMPLATE->htmlbase . 'images/key.png' ?>" alt="Activar" title="Activar" /></a>
                <?php } ?>
                <?php if ($this->acl('gestions', 'delete') && $gestion->status == 'inactive' && $gestion->isEmpty()) { ?>
                    <a href="<?php echo $this->url(array('gestion' => $gestion->url), 'gestions_gestion_delete') ?>"><img src="<?php echo $this->TEMPLATE->htmlbase . 'images/delete.png' ?>" alt="Eliminar" title="Eliminar" /></a>
                <?php } ?>
            </td>
            <td><center><?php echo $this->timestamp($gestion->tsregister) ?></center></td>
        </tr>
    <?php } ?>
    </table>
<?php } else { ?>
    <p>No existen gestiones registradas</p>
<?php } ?>

    <div>
<?php if ($this->acl('gestions', 'list')) { ?><input type="button" name="list" value="Lista" onclick="location.href='<?php echo $this->url(array(), 'gestions_list') ?>'" /><?php } ?>
<?php if ($this->acl('gestions', 'new')) { ?><input type="button" name="new" value="Nuevo" onclick="location.href='<?php echo $this->url(array(), 'gestions_new') ?>'" /><?php } ?>
<?php if ($this->acl('gestions', 'active')) { ?><input type="submit" name="update" value="Actualizar" /><?php } ?>
    </div>
</form>
