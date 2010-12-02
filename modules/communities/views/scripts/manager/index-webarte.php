<h1><?= $this->PAGE->label ?></h1>

<form method="post" action="" accept-charset="utf-8">
    <input type="hidden" name="return" value="<?= $this->currentPage() ?>" />

    <div>
<input type="button" name="list" value="Lista" onclick="location.href='<?= $this->url(array(), 'communities_list') ?>'" /><input type="button" name="new" value="Nuevo" onclick="location.href='<?= $this->url(array(), 'communities_new') ?>'" /><input type="submit" name="delete" value="Eliminar" />
    </div>

<?php if (count($this->communities)) { ?>
    <table>
        <tr>
            <th>&nbsp;</th>
            <th><?= $this->model_communities->_mapping['label'] ?></th>
            <th><?= $this->model_communities->_mapping['mode'] ?></th>
            <th><?= $this->model_communities->_mapping['members'] ?></th>
            <th>Opciones</th>
            <th><?= $this->model_communities->_mapping['tsregister'] ?></th>
        </tr>
    <?php foreach ($this->communities as $key => $community) { ?>
        <tr class="<?= $key % 2 == 0 ? 'even' : 'odd' ?>">
            <td><input type="checkbox" name="check[]" value="<?= $community->ident ?>" /></td>
            <td><?= $community->label ?></td>
            <td class="center">
                <?php if ($community->mode == 'close') { ?>
                    <img src="<?= $this->TEMPLATE->htmlbase . 'images/key.png' ?>" alt="Comunidad privada" title="Comunidad privada" />
                <?php } ?>
                <?= $this->mode(NULL, $community->mode) ?>
            </td>
            <td class="center"><?= $community->members ?></td>
            <td class="options">
                <a href="<?= $this->url(array('community' => $community->url), 'communities_community_view') ?>"><img src="<?= $this->TEMPLATE->htmlbase . 'images/page_white_text.png' ?>" alt="Ver" title="Ver" /></a>
                <a href="<?= $this->url(array('community' => $community->url), 'communities_community_edit') ?>"><img src="<?= $this->TEMPLATE->htmlbase . 'images/pencil.png' ?>" alt="Editar" title="Editar" /></a>
                <a href="<?= $this->url(array('community' => $community->url), 'communities_community_delete') ?>"><img src="<?= $this->TEMPLATE->htmlbase . 'images/delete.png' ?>" alt="Eliminar" title="Eliminar" /></a>
            </td>
            <td class="center"><?= $this->timestamp($community->tsregister) ?></td>
        </tr>
    <?php } ?>
    </table>
<?php } else { ?>
    <p>No existen comunidades registradas</p>
<?php } ?>

    <div>
<input type="button" name="list" value="Lista" onclick="location.href='<?= $this->url(array(), 'communities_list') ?>'" /><input type="button" name="new" value="Nuevo" onclick="location.href='<?= $this->url(array(), 'communities_new') ?>'" /><input type="submit" name="delete" value="Eliminar" />
    </div>
</form>
