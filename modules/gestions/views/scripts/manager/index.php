<h1>Administrador de gestiones</h1>

<form method="post" action="">
    <input type="hidden" name="return" value="<?= $this->currentPage() ?>" />

    <table>
        <tr>
        <?php if (Yeah_Acl::hasPermission('gestions', 'list')) { ?>
            <td>[<a href="<?= $this->url(array(), 'gestions_list') ?>">Lista</a>]</td>
        <?php } ?>
        <?php if (Yeah_Acl::hasPermission('gestions', 'new')) { ?>
            <td>[<a href="<?= $this->url(array(), 'gestions_new') ?>">Nuevo</a>]</td>
        <?php } ?>
        <?php if (Yeah_Acl::hasPermission('gestions', 'active')) { ?>
            <td><input type="submit" value="Actualizar" /></td>
        <?php } ?>
        </tr>
    </table>

    <hr />
<?php if (count($this->gestions)) { ?>
    <center>
        <table width="100%">
            <tr>
                <th>&nbsp;</th>
                <th><?= $this->utf2html($this->model->_mapping['label']) ?></th>
                <th><?= $this->utf2html($this->model->_mapping['status']) ?></th>
                <th>Opciones</th>
                <th><?= $this->utf2html($this->model->_mapping['tsregister']) ?></th>
            </tr>
        <?php foreach ($this->gestions as $gestion) { ?>
            <tr>
                <td>
                <?php if (Yeah_Acl::hasPermission('gestions', 'active')) { ?>
                <?php if ($gestion->status == 'active') { ?>
                    <input type="radio" checked="checked" name="radio" value="<?= $gestion->ident ?>" />
                <?php } else { ?>
                    <input type="radio" name="radio" value="<?= $gestion->ident ?>" />
                <?php } ?>
                <?php } ?>
                </td>
                <td><?= $this->utf2html($gestion->label) ?></td>
                <td><?= $this->status($gestion->status) ?></td>
                <td>
                    <center>
                    <?php if (Yeah_Acl::hasPermission('gestions', 'view')) { ?>
                        <a href="<?= $this->url(array('gestion' => $gestion->url), 'gestions_gestion_view') ?>">Ver</a>
                    <?php } ?>
                    <?php if (Yeah_Acl::hasPermission('gestions', 'delete')) { ?>
                        <?php if ($gestion->status == 'inactive') { ?>
                        <?php if ($gestion->isEmpty()) { ?>
                        <a href="<?= $this->url(array('gestion' => $gestion->url), 'gestions_gestion_delete') ?>">Eliminar</a>
                        <?php } ?>
                        <?php } ?>
                    <?php } ?>
                    <?php if (Yeah_Acl::hasPermission('gestions', 'active')) { ?>
                        <?php if ($gestion->status == 'inactive') { ?>
                        <a href="<?= $this->url(array('gestion' => $gestion->url), 'gestions_gestion_active') ?>">Activar</a>
                        <?php } ?>
                    <?php } ?>
                    </center>
                </td>
                <td><center><?= $this->timestamp($gestion->tsregister) ?></center></td>
            </tr>
        <?php } ?>
        </table>
    </center>
<?php } else { ?>
    <p>No existen gestiones registradas</p>
<?php } ?>
    <hr />

    <table>
        <tr>
        <?php if (Yeah_Acl::hasPermission('gestions', 'list')) { ?>
            <td>[<a href="<?= $this->url(array(), 'gestions_list') ?>">Lista</a>]</td>
        <?php } ?>
        <?php if (Yeah_Acl::hasPermission('gestions', 'new')) { ?>
            <td>[<a href="<?= $this->url(array(), 'gestions_new') ?>">Nuevo</a>]</td>
        <?php } ?>
        <?php if (Yeah_Acl::hasPermission('gestions', 'active')) { ?>
            <td><input type="submit" value="Actualizar" /></td>
        <?php } ?>
        </tr>
    </table>
</form>
