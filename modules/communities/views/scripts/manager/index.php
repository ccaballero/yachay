<h1>Administrador de comunidades</h1>

<form method="post" action="">
    <input type="hidden" name="return" value="<?= $this->currentPage() ?>" />

    <table>
        <tr>
            <td><input type="button" value="Nuevo" onclick="location.href='<?= $this->url(array(), 'communities_new') ?>'" /></td>
            <td><input type="submit" name="delete" value="Eliminar" /></td>
        </tr>
    </table>

    <hr />
<?php if (count($this->communities)) { ?>
    <center>
        <table width="100%">
            <tr>
            	<th>&nbsp;</th>
                <th><?= $this->utf2html($this->model->_mapping['label']) ?></th>
                <th><?= $this->utf2html($this->model->_mapping['mode']) ?></th>
                <th><?= $this->utf2html($this->model->_mapping['members']) ?></th>
                <th>Opciones</th>
                <th><?= $this->utf2html($this->model->_mapping['tsregister']) ?></th>
            </tr>
        <?php foreach ($this->communities as $community) { ?>
            <tr>
            	<td><input type="checkbox" name="check[]" value="<?= $community->ident ?>" /></td>
                <td><?= $this->utf2html($community->label) ?></td>
                <td><center><?= $this->mode(NULL, $community->mode) ?></center></td>
                <td><center><?= $this->utf2html($community->members) ?></center></td>
                <td>
                    <center>
                        <a href="<?= $this->url(array('community' => $community->url), 'communities_community_view') ?>">Ver</a>
                        <a href="<?= $this->url(array('community' => $community->url), 'communities_community_edit') ?>">Editar</a>
                        <a href="<?= $this->url(array('community' => $community->url), 'communities_community_delete') ?>">Eliminar</a>
                    </center>
                </td>
                <td><center><?= $this->timestamp($community->tsregister) ?></center></td>
            </tr>
        <?php } ?>
        </table>
    </center>
<?php } else { ?>
    <p>No existen comunidades registradas</p>
<?php } ?>
    <hr />

    <table>
        <tr>
            <td><input type="button" value="Nuevo" onclick="location.href='<?= $this->url(array(), 'communities_new') ?>'" /></td>
            <td><input type="submit" name="delete" value="Eliminar" /></td>
        </tr>
    </table>
</form>
