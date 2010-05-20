<h1>Lista de widgets por pagina</h1>

<center>
    <table width="100%">
        <tr>
            <th>Widget</th>
            <th>1&deg; Posici&oacute;n</th>
            <th>2&deg; Posici&oacute;n</th>
            <th>3&deg; Posici&oacute;n</th>
            <th>4&deg; Posici&oacute;n</th>
        </tr>
    <?php foreach ($this->pages as $page) { ?>
        <tr>
            <td><?= $this->utf2html($page->label) ?></td>
            <td><center><?= $this->widgets_pages[$page->ident]['1']->label ?></center></td>
            <td><center><?= $this->widgets_pages[$page->ident]['2']->label ?></center></td>
            <td><center><?= $this->widgets_pages[$page->ident]['3']->label ?></center></td>
            <td><center><?= $this->widgets_pages[$page->ident]['4']->label ?></center></td>
        </tr>
    <?php } ?>
    </table>
</center>
