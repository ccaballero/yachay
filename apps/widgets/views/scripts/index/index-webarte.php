<h1><?php echo $this->route->label ?></h1>
<table>
    <tr>
        <th>Ruta</th>
        <th>1ª Posición</th>
        <th>2ª Posición</th>
        <th>3ª Posición</th>
        <th>4ª Posición</th>
    </tr>
<?php foreach ($this->routes as $key => $route) { ?>
    <tr class="<?php echo $key % 2 == 0 ? 'even' : 'odd' ?>">
        <td><?php echo $route->label ?></td>
        <td><?php echo $this->widgets_routes[$route->ident]['1']->label ?></td>
        <td><?php echo $this->widgets_routes[$route->ident]['2']->label ?></td>
        <td><?php echo $this->widgets_routes[$route->ident]['3']->label ?></td>
        <td><?php echo $this->widgets_routes[$route->ident]['4']->label ?></td>
    </tr>
<?php } ?>
</table>
