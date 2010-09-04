<h1>Configuraci&oacute;n de regiones por pagina</h1>

<form method="post" action="">
    <input type="hidden" name="return" value="<?= $this->currentPage() ?>" />

    <table>
        <tr>
            <?php if (Yeah_Acl::hasPermission('regions', 'list')) { ?>
                <td>[<a href="<?= $this->url(array(), 'regions_list') ?>">Lista</a>]</td>
            <?php } ?>
            <?php if (Yeah_Acl::hasPermission('regions', 'manage')) { ?>
                <td><input type="submit" value="Actualizar" /></td>
            <?php } ?>
        </tr>
    </table>

    <hr />
<?php if (count($this->pages)) { ?>
    <center>
        <table width="100%">
            <tr>
                <th>Pagina</th>
                <th>Region de busqueda</th>
                <th>Barra de menus</th>
                <th>Barra de tareas</th>
                <th>Barra inferior</th>
            </tr>
	    <?php foreach ($this->pages as $page) { ?>
            <tr>
                <td><?= $this->utf2html($page->label) ?></td>
                <td><center><?= $this->search('regions[' . $page->ident . '][search]', $this->regions_pages[$page->ident]['search']) ?></center></td>
                <td><center><?= $this->menubar('regions[' . $page->ident . '][menubar]', $this->regions_pages[$page->ident]['menubar']) ?></center></td>
                <td><center><?= $this->toolbar('regions[' . $page->ident . '][toolbar]', $this->regions_pages[$page->ident]['toolbar']) ?></center></td>
                <td><center><?= $this->footer('regions[' . $page->ident . '][footer]', $this->regions_pages[$page->ident]['footer']) ?></center></td>
            </tr>
        <?php } ?>
        </table>
    </center>
<?php } else { ?>
    <p>No existen paginas registradas</p>
<?php } ?>
    <hr />

    <table>
        <tr>
            <?php if (Yeah_Acl::hasPermission('regions', 'list')) { ?>
                <td>[<a href="<?= $this->url(array(), 'regions_list') ?>">Lista</a>]</td>
            <?php } ?>
            <?php if (Yeah_Acl::hasPermission('regions', 'manage')) { ?>
                <td><input type="submit" value="Actualizar" /></td>
            <?php } ?>
        </tr>
    </table>
</form>
