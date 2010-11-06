<h1><?= $this->PAGE->label ?></h1>
<table>
    <tr>
        <th>Widget</th>
        <th>1ª Posición</th>
        <th>2ª Posición</th>
        <th>3ª Posición</th>
        <th>4ª Posición</th>
    </tr>
<?php foreach ($this->pages as $key => $page) { ?>
    <tr class="<?= $key % 2 == 0 ? 'even' : 'odd' ?>">
        <td><?= $page->label ?></td>
        <td><?= $this->widgets_pages[$page->ident]['1']->label ?></td>
        <td><?= $this->widgets_pages[$page->ident]['2']->label ?></td>
        <td><?= $this->widgets_pages[$page->ident]['3']->label ?></td>
        <td><?= $this->widgets_pages[$page->ident]['4']->label ?></td>
    </tr>
<?php } ?>
</table>
