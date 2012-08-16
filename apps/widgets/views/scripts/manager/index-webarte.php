<h1><?php echo $this->route->label ?></h1>

<form method="post" action="" accept-charset="utf-8">
    <input type="hidden" name="return" value="<?php echo $this->currentPage() ?>" />

    <div>
<?php if ($this->acl('widgets', 'list')) { ?><input type="button" name="list" value="Lista" onclick="location.href='<?php echo $this->url(array(), 'widgets_list') ?>'" /><?php } ?>
<?php if ($this->acl('widgets', 'manage')) { ?><input type="submit" value="Actualizar" /><?php } ?>
    </div>

<?php if (count($this->routes)) { ?>
    <table>
        <tr>
            <th>Widget</th>
            <th>1ª Posición</th>
            <th>2ª Posición</th>
            <th>3ª Posición</th>
            <th>4ª Posición</th>
        </tr>
    <?php foreach ($this->routes as $key => $route) { ?>
        <tr class="<?php echo $key % 2 == 0 ? 'even' : 'odd' ?>">
            <td><?php echo $route->label ?></td>
            <td><?php echo $this->widget('widgets[' . $route->ident . '][1]', $this->widgets_routes[$route->ident]['1']) ?></td>
            <td><?php echo $this->widget('widgets[' . $route->ident . '][2]', $this->widgets_routes[$route->ident]['2']) ?></td>
            <td><?php echo $this->widget('widgets[' . $route->ident . '][3]', $this->widgets_routes[$route->ident]['3']) ?></td>
            <td><?php echo $this->widget('widgets[' . $route->ident . '][4]', $this->widgets_routes[$route->ident]['4']) ?></td>
        </tr>
    <?php } ?>
    </table>
<?php } else { ?>
    <p>No existen paginas registradas</p>
<?php } ?>

    <div>
<?php if ($this->acl('widgets', 'list')) { ?><input type="button" name="list" value="Lista" onclick="location.href='<?php echo $this->url(array(), 'widgets_list') ?>'" /><?php } ?>
<?php if ($this->acl('widgets', 'manage')) { ?><input type="submit" value="Actualizar" /><?php } ?>
    </div>
</form>
