<h1><?php echo $this->PAGE->label ?></h1>

<form method="post" action="" accept-charset="utf-8">
    <input type="hidden" name="return" value="<?php echo $this->currentPage() ?>" />

    <div>
<?php if ($this->acl('regions', 'list')) { ?><input type="button" name="list" value="Lista" onclick="location.href='<?php echo $this->url(array(), 'regions_list') ?>'" /><?php } ?>
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
        <tr class="<?php echo $key % 2 == 0 ? 'even' : 'odd' ?>">
            <td><?php echo $page->label ?></td>
            <td><?php echo $this->search('regions[' . $page->ident . '][search]', $this->regions_pages[$page->ident]['search']) ?></td>
            <td><?php echo $this->menubar('regions[' . $page->ident . '][menubar]', $this->regions_pages[$page->ident]['menubar']) ?></td>
            <td><?php echo $this->toolbar('regions[' . $page->ident . '][toolbar]', $this->regions_pages[$page->ident]['toolbar']) ?></td>
            <td><?php echo $this->footer('regions[' . $page->ident . '][footer]', $this->regions_pages[$page->ident]['footer']) ?></td>
        </tr>
    <?php } ?>
    </table>
<?php } else { ?>
    <p>No existen paginas registradas</p>
<?php } ?>

    <div>
<?php if ($this->acl('regions', 'list')) { ?><input type="button" name="list" value="Lista" onclick="location.href='<?php echo $this->url(array(), 'regions_list') ?>'" /><?php } ?>
<?php if ($this->acl('regions', 'manage')) { ?><input type="submit" value="Actualizar" /><?php } ?>
    </div>

</form>
