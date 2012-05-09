<h1><?php echo $this->page->label ?></h1>

<form method="post" action="" accept-charset="utf-8">
    <input type="hidden" name="return" value="<?php echo $this->currentPage() ?>" />

    <div>
<input type="button" name="list" value="Lista" onclick="location.href='<?php echo $this->url(array(), 'communities_list') ?>'" /><input type="button" name="new" value="Nuevo" onclick="location.href='<?php echo $this->url(array(), 'communities_new') ?>'" /><input type="submit" name="delete" value="Eliminar" />
    </div>

<?php if (count($this->communities)) { ?>
    <table>
        <tr>
            <th>&nbsp;</th>
            <th><?php echo $this->model_communities->_mapping['label'] ?></th>
            <th><?php echo $this->model_communities->_mapping['mode'] ?></th>
            <th><?php echo $this->model_communities->_mapping['members'] ?></th>
            <th>Opciones</th>
            <th><?php echo $this->model_communities->_mapping['tsregister'] ?></th>
        </tr>
    <?php foreach ($this->communities as $key => $community) { ?>
        <tr class="<?php echo $key % 2 == 0 ? 'even' : 'odd' ?>">
            <td><input type="checkbox" name="check[]" value="<?php echo $community->ident ?>" /></td>
            <td><?php echo $community->label ?></td>
            <td class="center">
                <?php if ($community->mode == 'close') { ?>
                    <img src="<?php echo $this->template->htmlbase . 'images/key.png' ?>" alt="Comunidad privada" title="Comunidad privada" />
                <?php } ?>
                <?php echo $this->mode(NULL, $community->mode) ?>
            </td>
            <td class="center"><?php echo $community->members ?></td>
            <td class="options">
                <a href="<?php echo $this->url(array('community' => $community->url), 'communities_community_view') ?>"><img src="<?php echo $this->template->htmlbase . 'images/page_white_text.png' ?>" alt="Ver" title="Ver" /></a>
                <a href="<?php echo $this->url(array('community' => $community->url), 'communities_community_edit') ?>"><img src="<?php echo $this->template->htmlbase . 'images/pencil.png' ?>" alt="Editar" title="Editar" /></a>
                <a href="<?php echo $this->url(array('community' => $community->url), 'communities_community_delete') ?>"><img src="<?php echo $this->template->htmlbase . 'images/delete.png' ?>" alt="Eliminar" title="Eliminar" /></a>
            </td>
            <td class="center"><?php echo $this->timestamp($community->tsregister) ?></td>
        </tr>
    <?php } ?>
    </table>
<?php } else { ?>
    <p>No existen comunidades registradas</p>
<?php } ?>

    <div>
<input type="button" name="list" value="Lista" onclick="location.href='<?php echo $this->url(array(), 'communities_list') ?>'" /><input type="button" name="new" value="Nuevo" onclick="location.href='<?php echo $this->url(array(), 'communities_new') ?>'" /><input type="submit" name="delete" value="Eliminar" />
    </div>
</form>
