<h1>Lista de paginas</h1>

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
            <td><?= $this->utf2html($page->label) ?></td>
            <td><center><?= $this->utf2html($page->module) ?></center></td>
            <td><center><?= $this->utf2html($page->title) ?></center></td>
            <td><center><?= $this->utf2html($page->menutype) ?></center></td>
            <td><center><?= $this->utf2html($page->menuorder) ?></center></td>
        </tr>
        <?php } ?>
    </table>
</center>
