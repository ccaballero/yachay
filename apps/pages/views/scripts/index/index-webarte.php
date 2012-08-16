<h1><?php echo $this->route->label ?></h1>
<table>
    <tr>
        <th><?php echo $this->model_pages->_mapping['label'] ?></th>
        <th><?php echo $this->model_pages->_mapping['package'] ?></th>
        <th><?php echo $this->model_pages->_mapping['title'] ?></th>
        <th><?php echo $this->model_pages->_mapping['menutype'] ?></th>
        <th><?php echo $this->model_pages->_mapping['menuorder'] ?></th>
    </tr>
<?php foreach ($this->pages as $key => $page) { ?>
    <tr class="<?php echo $key % 2 == 0 ? 'even' : 'odd' ?>">
        <td><?php echo $page->label ?></td>
        <td><?php echo $page->package ?></td>
        <td><?php echo $page->title ?></td>
        <td><?php echo $page->menutype ?></td>
        <td class="center"><?php echo $page->menuorder ?></td>
    </tr>
<?php } ?>
</table>
