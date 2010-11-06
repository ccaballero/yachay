<h1>Modulo: <?= $this->module->label ?></h1>

<p>
    <span class="bold">Estado: </span><?= $this->status($this->module->status) ?><br />
    <span class="bold">Tipo: </span><?= $this->type($this->module->type) ?><br />
    <span class="bold">Descripción: </span>
    <?= $this->module->description ?>
</p>

<h2>Rutas registradas</h2>

<?php if (isset($this->routes)) { ?>
<table>
    <tr>
        <th><?= $this->model_pages->_mapping['route'] ?></th>
        <th><?= $this->model_pages->_mapping['controller'] ?></th>
        <th><?= $this->model_pages->_mapping['action'] ?></th>
        <th>Url</th>
    </tr>
<?php $key = 0 ?>
<?php foreach($this->routes->routes as $label => $route) { ?>
    <tr class="<?= $key % 2 == 0 ? 'even' : 'odd' ?>">
        <td><?= $label ?></td>
        <td><?= $route[1]['controller'] ?></td>
        <td><?= $route[1]['action'] ?></td>
        <td><?= $route[0] ?></td>
    </tr>
    <?php $key++ ?>
<?php } ?>
</table>
<?php } else { ?>
    <p>No se registraron rutas para este modulo.</p>
<?php } ?>
