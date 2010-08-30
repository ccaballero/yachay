<h1>Configuraci&oacute;n de widgets por pagina</h1>

<form method="post" action="">
    <input type="hidden" name="return" value="<?= $this->currentPage() ?>" />

    <table>
        <tr>
            <?php if (Yeah_Acl::hasPermission('widgets', 'list')) { ?>
                <td><input type="button" value="Lista" onclick="location.href='<?= $this->url(array(), 'widgets_list') ?>'" /></td>
            <?php } ?>
            <?php if (Yeah_Acl::hasPermission('widgets', 'manage')) { ?>
                <td><input type="submit" value="Actualizar" /></td>
            <?php } ?>
        </tr>
    </table>

    <hr />
<?php if (count($this->pages)) { ?>
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
                <td><center><?= $this->widget('widgets[' . $page->ident . '][1]', $this->widgets_pages[$page->ident]['1']) ?></center></td>
                <td><center><?= $this->widget('widgets[' . $page->ident . '][2]', $this->widgets_pages[$page->ident]['2']) ?></center></td>
                <td><center><?= $this->widget('widgets[' . $page->ident . '][3]', $this->widgets_pages[$page->ident]['3']) ?></center></td>
                <td><center><?= $this->widget('widgets[' . $page->ident . '][4]', $this->widgets_pages[$page->ident]['4']) ?></center></td>
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
            <?php if (Yeah_Acl::hasPermission('widgets', 'list')) { ?>
                <td><input type="button" value="Lista" onclick="location.href='<?= $this->url(array(), 'widgets_list') ?>'" /></td>
            <?php } ?>
            <?php if (Yeah_Acl::hasPermission('widgets', 'manage')) { ?>
                <td><input type="submit" value="Actualizar" /></td>
            <?php } ?>
        </tr>
    </table>
</form>
