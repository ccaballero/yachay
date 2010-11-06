<h1><?= $this->PAGE->label ?></h1>

<form method="post" action="" accept-charset="utf-8">
    <input type="hidden" name="return" value="<?= $this->currentPage() ?>" />

    <div>
<?php if ($this->acl('regions', 'list')) { ?><input type="button" name="list" value="Lista" onclick="location.href='<?= $this->url(array(), 'regions_list') ?>'" /><?php } ?>
<?php if ($this->acl('regions', 'manage')) { ?><input type="submit" value="Actualizar" /><?php } ?>
    </div>

<?php if (count($this->pages)) { ?>
    <table>
        <tr>
            <th>Pagina</th>
            <th>Busqueda</th>
            <th>Menus</th>
            <th>Tareas</th>
            <th>Inferior</th>
        </tr>
    <?php foreach ($this->pages as $key => $page) { ?>
        <tr class="<?= $key % 2 == 0 ? 'even' : 'odd' ?>">
            <td><?= $page->label ?></td>
            <td><?= $this->search('regions[' . $page->ident . '][search]', $this->regions_pages[$page->ident]['search']) ?></td>
            <td><?= $this->menubar('regions[' . $page->ident . '][menubar]', $this->regions_pages[$page->ident]['menubar']) ?></td>
            <td><?= $this->toolbar('regions[' . $page->ident . '][toolbar]', $this->regions_pages[$page->ident]['toolbar']) ?></td>
            <td><?= $this->footer('regions[' . $page->ident . '][footer]', $this->regions_pages[$page->ident]['footer']) ?></td>
        </tr>
    <?php } ?>
    </table>
<?php } else { ?>
    <p>No existen paginas registradas</p>
<?php } ?>

    <div>
<?php if ($this->acl('regions', 'list')) { ?><input type="button" name="list" value="Lista" onclick="location.href='<?= $this->url(array(), 'regions_list') ?>'" /><?php } ?>
<?php if ($this->acl('regions', 'manage')) { ?><input type="submit" value="Actualizar" /><?php } ?>
    </div>

</form>
