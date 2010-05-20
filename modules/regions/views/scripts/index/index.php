<h1>Lista de regiones por pagina</h1>

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
            <td><center><?= $this->regions_pages[$page->ident]['search']->label ?></center></td>
            <td><center><?= $this->regions_pages[$page->ident]['menubar']->label ?></center></td>
            <td><center><?= $this->regions_pages[$page->ident]['toolbar']->label ?></center></td>
            <td><center><?= $this->regions_pages[$page->ident]['footer']->label ?></center></td>
        </tr>
	<?php } ?>
	</table>
</center>
