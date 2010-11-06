<h1><?= $this->PAGE->label ?></h1>
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
        <td><?= $page->label ?></td>
        <td><?= $page->module ?></td>
        <td><?= $page->title ?></td>
        <td><?= $page->menutype ?></td>
        <td class="center"><?= $page->menuorder ?></td>
    </tr>
<?php } ?>
</table>
