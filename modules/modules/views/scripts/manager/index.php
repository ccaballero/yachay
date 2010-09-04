<h1>Administrador de modulos</h1>

<form method="post" action="">
    <input type="hidden" name="return" value="<?= $this->currentPage() ?>" />

    <table>
        <tr>
        <?php if (Yeah_Acl::hasPermission('modules', 'list')) { ?>
            <td>[<a href="<?= $this->url(array(), 'modules_list') ?>">Lista</a>]</td>
        <?php } ?>
        <?php if (Yeah_Acl::hasPermission('modules', 'new')) { ?>
            <td>[<a href="<?= $this->url(array(), 'modules_new') ?>">Nuevo</a>]</td>
        <?php } ?>
        <?php if (Yeah_Acl::hasPermission('modules', 'lock')) { ?>
            <td><input type="submit" name="unlock" value="Activar" /></td>
            <td><input type="submit" name="lock" value="Desactivar" /></td>
        <?php } ?>
        </tr>
    </table>

    <hr />
<?php if (count($this->modules)) { ?>
    <center>
        <table width="100%">
            <tr>
                <th>&nbsp;</th>
                <th><?= $this->utf2html($this->model->_mapping['label']) ?></th>
                <th><?= $this->utf2html($this->model->_mapping['type']) ?></th>
                <th>Opciones</th>
                <th><?= $this->utf2html($this->model->_mapping['tsregister']) ?></th>
            </tr>
        <?php foreach ($this->modules as $module) { ?>
            <tr>
                <td>
                <?php if (Yeah_Acl::hasPermission('modules', 'lock')) { ?>
                    <input type="checkbox" name="check[]" value="<?= $module->ident ?>" />
                <?php } ?>
                </td>
                <td><?= $this->utf2html($module->label) ?></td>
                <td><?= $this->utf2html($module->type) ?></td>
                <td>
                    <center>
                    <?php if (Yeah_Acl::hasPermission('modules', 'view')) { ?>
                        <a href="<?= $this->url(array('mod' => $module->url), 'modules_module_view') ?>">Ver</a>
                    <?php } ?>
                    <?php if (Yeah_Acl::hasPermission('modules', 'lock')) { ?>
                        <?php if ($module->status == 'active') { ?>
                            <a href="<?= $this->url(array('mod' => $module->url), 'modules_module_lock') ?>">Desactivar</a>
                        <?php } else { ?>
                            <a href="<?= $this->url(array('mod' => $module->url), 'modules_module_unlock') ?>">Activar</a>
                        <?php } ?>
                    <?php } ?>
                    </center>
                </td>
                <td><center><?= $this->timestamp($module->tsregister) ?></center></td>
            </tr>
            <?php } ?>
        </table>
    </center>
<?php } else { ?>
    <p>No existen modulos registrados</p>
<?php } ?>
    <hr />

    <table>
        <tr>
        <?php if (Yeah_Acl::hasPermission('modules', 'list')) { ?>
            <td>[<a href="<?= $this->url(array(), 'modules_list') ?>">Lista</a>]</td>
        <?php } ?>
        <?php if (Yeah_Acl::hasPermission('modules', 'new')) { ?>
            <td>[<a href="<?= $this->url(array(), 'modules_new') ?>">Nuevo</a>]</td>
        <?php } ?>
        <?php if (Yeah_Acl::hasPermission('modules', 'lock')) { ?>
            <td><input type="submit" name="unlock" value="Activar" /></td>
            <td><input type="submit" name="lock" value="Desactivar" /></td>
        <?php } ?>
        </tr>
    </table>
</form>
