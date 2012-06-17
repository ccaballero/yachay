<h1>Modulo: <?php echo $this->package->label ?></h1>

<p>
    <span class="bold">Estado: </span><?php echo $this->status($this->package->status) ?><br />
    <span class="bold">Tipo: </span><?php echo $this->type($this->package->type) ?><br />
    <span class="bold">Descripción: </span>
    <?php echo $this->package->description ?>
</p>

<h2>Rutas registradas</h2>

<?php if (isset($this->routes)) { ?>
<table>
    <tr>
        <th><?php echo $this->model_pages->_mapping['route'] ?></th>
        <th><?php echo $this->model_pages->_mapping['controller'] ?></th>
        <th><?php echo $this->model_pages->_mapping['action'] ?></th>
        <th>Url</th>
    </tr>
<?php $key = 0 ?>
<?php foreach($this->routes->routes as $label => $route) { ?>
    <tr class="<?php echo $key % 2 == 0 ? 'even' : 'odd' ?>">
        <td><?php echo $label ?></td>
        <td><?php echo $route[1]['controller'] ?></td>
        <td><?php echo $route[1]['action'] ?></td>
        <td><?php echo $route[0] ?></td>
    </tr>
    <?php $key++ ?>
<?php } ?>
</table>
<?php } else { ?>
    <p>No se registraron rutas para este modulo.</p>
<?php } ?>
