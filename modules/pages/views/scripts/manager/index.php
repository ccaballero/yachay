<h1>Configuraci&oacute;n de paginas</h1>

<form method="post" action="">
    <input type="hidden" name="return" value="<?= $this->currentPage() ?>" />

    <table>
        <tr>
            <?php if (Yeah_Acl::hasPermission('pages', 'list')) { ?>
                <td><input type="button" value="Lista" onclick="location.href='<?= $this->url(array(), 'pages_list') ?>'" /></td>
            <?php } ?>
            <?php if (Yeah_Acl::hasPermission('pages', 'manage')) { ?>
                <td><input type="submit" value="Actualizar" /></td>
            <?php } ?>
        </tr>
    </table>

    <hr />
    <?php if (count($this->pages)) { ?>
        <center>
            <table width="100%">
                <tr>
                    <th><?= $this->utf2html($this->model->_mapping['label']) ?></th>
                    <th><?= $this->utf2html($this->model->_mapping['module']) ?></th>
                    <th><?= $this->utf2html($this->model->_mapping['title']) ?></th>
                    <th><?= $this->utf2html($this->model->_mapping['menutype']) ?></th>
                    <th><?= $this->utf2html($this->model->_mapping['menuorder']) ?></th>
                </tr>
            <?php foreach ($this->pages as $page) { ?>
                <tr>
                    <td>
                        <a target="_BLANK" href="<?= $this->url(array(), $page->route ) ?>"><?= $this->utf2html($page->label) ?></a>
                    </td>
                    <td><?= $page->module ?></td>
                    <td><input type="text" name="pages[<?= $page->ident ?>][title]" value="<?= $this->utf2html($page->title) ?>" /></td>
                    <td><?= $this->menutype('pages[' . $page->ident . '][menutype]', $page->menutype) ?></td>
                    <td><center><input type="text" name="pages[<?= $page->ident ?>][menuorder]" size="2" maxlength="2" value="<?= $page->menuorder ?>" /></center></td>
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
            <?php if (Yeah_Acl::hasPermission('pages', 'list')) { ?>
                <td><input type="button" value="Lista" onclick="location.href='<?= $this->url(array(), 'pages_list') ?>'" /></td>
            <?php } ?>
            <?php if (Yeah_Acl::hasPermission('pages', 'manage')) { ?>
                <td><input type="submit" value="Actualizar" /></td>
            <?php } ?>
        </tr>
    </table>    
</form>
