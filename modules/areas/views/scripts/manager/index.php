<h1>Administrador de areas</h1>

<form method="post" action="" accept-charset="utf-8">
    <input type="hidden" name="return" value="<?= $this->currentPage() ?>" />

    <table>
        <tr>
        <?php if (Yeah_Acl::hasPermission('areas', 'list')) { ?>
            <td>[<a href="<?= $this->url(array(), 'areas_list') ?>">Lista</a>]</td>
        <?php } ?>
        <?php if (Yeah_Acl::hasPermission('areas', 'new')) { ?>
            <td>[<a href="<?= $this->url(array(), 'areas_new') ?>">Nuevo</a>]</td>
        <?php } ?>
        </tr>
    </table>

    <hr />
<?php if (count($this->areas)) { ?>
    <center>
        <table width="100%">
            <tr>
                <th><?= $this->utf2html($this->model->_mapping['label']) ?></th>
                <th>Opciones</th>
                <th><?= $this->utf2html($this->model->_mapping['tsregister']) ?></th>
            </tr>
        <?php foreach ($this->areas as $area) { ?>
            <tr>
                <td><?= $this->utf2html($area->label) ?></td>
                <td>
                    <center>
                    <?php if (Yeah_Acl::hasPermission('areas', 'view')) { ?>
                        <a href="<?= $this->url(array('area' => $area->url), 'areas_area_view') ?>">Ver</a>
                    <?php } ?>
                    <?php if (Yeah_Acl::hasPermission('areas', 'edit')) { ?>
                        <a href="<?= $this->url(array('area' => $area->url), 'areas_area_edit') ?>">Editar</a>
                    <?php } ?>
                    <?php if (Yeah_Acl::hasPermission('areas', 'delete')) { ?>
                        <?php if ($area->isEmpty()) { ?>
                        <a href="<?= $this->url(array('area' => $area->url), 'areas_area_delete') ?>">Eliminar</a>
                        <?php } ?>
                    <?php } ?>
                    </center>
                </td>
                <td><center><?= $this->timestamp($area->tsregister) ?></center></td>
            </tr>
        <?php } ?>
        </table>
    </center>
<?php } else { ?>
    <p>No existen areas registradas</p>
<?php } ?>
    <hr />

    <table>
        <tr>
        <?php if (Yeah_Acl::hasPermission('areas', 'list')) { ?>
            <td>[<a href="<?= $this->url(array(), 'areas_list') ?>">Lista</a>]</td>
        <?php } ?>
        <?php if (Yeah_Acl::hasPermission('areas', 'new')) { ?>
            <td>[<a href="<?= $this->url(array(), 'areas_new') ?>">Nuevo</a>]</td>
        <?php } ?>
        </tr>
    </table>
</form>
