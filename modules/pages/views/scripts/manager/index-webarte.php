<h1><?= $this->PAGE->label ?></h1>

<form method="post" action="" accept-charset="utf-8">
    <input type="hidden" name="return" value="<?= $this->currentPage() ?>" />

    <div>
<?php if ($this->acl('pages', 'list')) { ?><input type="button" name="list" value="Lista" onclick="location.href='<?= $this->url(array(), 'pages_list') ?>'" /><?php } ?>
<?php if ($this->acl('pages', 'manage')) { ?><input type="submit" value="Actualizar" /><?php } ?>
    </div>

<?php if (count($this->pages)) { ?>
    <table>
        <tr>
            <th><?= $this->model_pages->_mapping['label'] ?></th>
            <th><?= $this->model_pages->_mapping['module'] ?></th>
            <th><?= $this->model_pages->_mapping['title'] ?></th>
            <th><?= $this->model_pages->_mapping['menutype'] ?></th>
            <th><?= $this->model_pages->_mapping['menuorder'] ?></th>
        </tr>
    <?php foreach ($this->pages as $key => $page) { ?>
        <tr class="<?= $key % 2 == 0 ? 'even' : 'odd' ?>">
            <td><a target="_BLANK" href="<?= $this->url(array(), $page->route ) ?>"><?= $page->label ?></a></td>
            <td><?= $page->module ?></td>
            <td><input type="text" name="pages[<?= $page->ident ?>][title]" value="<?= $page->title ?>" size="13" maxlength="16" /></td>
            <td><?= $this->menutype('pages[' . $page->ident . '][menutype]', $page->menutype) ?></td>
            <td><input class="number" type="text" name="pages[<?= $page->ident ?>][menuorder]" size="2" maxlength="2" value="<?= $page->menuorder ?>" /></td>
        </tr>
    <?php } ?>
    </table>
<?php } else { ?>
    <p>No existen paginas registradas</p>
<?php } ?>

    <div>
<?php if ($this->acl('pages', 'list')) { ?><input type="button" name="list" value="Lista" onclick="location.href='<?= $this->url(array(), 'pages_list') ?>'" /><?php } ?>
<?php if ($this->acl('pages', 'manage')) { ?><input type="submit" value="Actualizar" /><?php } ?>
    </div>
</form>
