<h1><?php echo $this->PAGE->label ?></h1>

<form method="post" action="" accept-charset="utf-8">
    <input type="hidden" name="return" value="<?php echo $this->currentPage() ?>" />

    <div>
<?php if ($this->acl('pages', 'list')) { ?><input type="button" name="list" value="Lista" onclick="location.href='<?php echo $this->url(array(), 'pages_list') ?>'" /><?php } ?>
<?php if ($this->acl('pages', 'manage')) { ?><input type="submit" value="Actualizar" /><?php } ?>
    </div>

<?php if (count($this->pages)) { ?>
    <table>
        <tr>
            <th><?php echo $this->model_pages->_mapping['label'] ?></th>
            <th><?php echo $this->model_pages->_mapping['module'] ?></th>
            <th><?php echo $this->model_pages->_mapping['title'] ?></th>
            <th><?php echo $this->model_pages->_mapping['menutype'] ?></th>
            <th><?php echo $this->model_pages->_mapping['menuorder'] ?></th>
        </tr>
    <?php foreach ($this->pages as $key => $page) { ?>
        <tr class="<?php echo $key % 2 == 0 ? 'even' : 'odd' ?>">
            <td><a target="_BLANK" href="<?php echo $this->url(array(), $page->route ) ?>"><?php echo $page->label ?></a></td>
            <td><?php echo $page->module ?></td>
            <td><input type="text" name="pages[<?php echo $page->ident ?>][title]" value="<?php echo $page->title ?>" size="13" maxlength="16" /></td>
            <td><?php echo $this->menutype('pages[' . $page->ident . '][menutype]', $page->menutype) ?></td>
            <td><input class="number" type="text" name="pages[<?php echo $page->ident ?>][menuorder]" size="2" maxlength="2" value="<?php echo $page->menuorder ?>" /></td>
        </tr>
    <?php } ?>
    </table>
<?php } else { ?>
    <p>No existen paginas registradas</p>
<?php } ?>

    <div>
<?php if ($this->acl('pages', 'list')) { ?><input type="button" name="list" value="Lista" onclick="location.href='<?php echo $this->url(array(), 'pages_list') ?>'" /><?php } ?>
<?php if ($this->acl('pages', 'manage')) { ?><input type="submit" value="Actualizar" /><?php } ?>
    </div>
</form>
