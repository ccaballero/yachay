<h1><?php echo $this->PAGE->label ?></h1>
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
        <td class="center"><?php echo $this->regions_pages[$page->ident]['search']->label ?></td>
        <td class="center"><?php echo $this->regions_pages[$page->ident]['menubar']->label ?></td>
        <td class="center"><?php echo $this->regions_pages[$page->ident]['toolbar']->label ?></td>
        <td class="center"><?php echo $this->regions_pages[$page->ident]['footer']->label ?></td>
    </tr>
<?php } ?>
</table>
