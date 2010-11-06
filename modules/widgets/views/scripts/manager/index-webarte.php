<h1><?= $this->PAGE->label ?></h1>

<form method="post" action="" accept-charset="utf-8">
    <input type="hidden" name="return" value="<?= $this->currentPage() ?>" />

    <div>
<?php if ($this->acl('widgets', 'list')) { ?><input type="button" name="list" value="Lista" onclick="location.href='<?= $this->url(array(), 'widgets_list') ?>'" /><?php } ?>
<?php if ($this->acl('widgets', 'manage')) { ?><input type="submit" value="Actualizar" /><?php } ?>
    </div>

<?php if (count($this->pages)) { ?>
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
            <td><?= $this->widget('widgets[' . $page->ident . '][1]', $this->widgets_pages[$page->ident]['1']) ?></td>
            <td><?= $this->widget('widgets[' . $page->ident . '][2]', $this->widgets_pages[$page->ident]['2']) ?></td>
            <td><?= $this->widget('widgets[' . $page->ident . '][3]', $this->widgets_pages[$page->ident]['3']) ?></td>
            <td><?= $this->widget('widgets[' . $page->ident . '][4]', $this->widgets_pages[$page->ident]['4']) ?></td>
        </tr>
    <?php } ?>
    </table>
<?php } else { ?>
    <p>No existen paginas registradas</p>
<?php } ?>

    <div>
<?php if ($this->acl('widgets', 'list')) { ?><input type="button" name="list" value="Lista" onclick="location.href='<?= $this->url(array(), 'widgets_list') ?>'" /><?php } ?>
<?php if ($this->acl('widgets', 'manage')) { ?><input type="submit" value="Actualizar" /><?php } ?>
    </div>
</form>
