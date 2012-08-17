<h1><?php echo $this->route->label ?></h1>
<table>
    <tr>
        <th>Ruta</th>
        <th>Paquete</th>
        <th>Etiqueta</th>
        <th>Tipo</th>
    </tr>
<?php foreach ($this->routes as $key => $route) { ?>
    <tr class="<?php echo $key % 2 == 0 ? 'even' : 'odd' ?>">
        <td><?php echo $route->route ?></td>
        <td><?php echo $route->module ?></td>
        <td><?php echo $route->label ?></td>
        <td><?php echo $route->type ?></td>
    </tr>
<?php } ?>
</table>
