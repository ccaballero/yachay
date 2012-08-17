<h1><?php echo $this->route->label ?></h1>

<form method="post" action="" accept-charset="utf-8">
    <input type="hidden" name="return" value="<?php echo $this->currentPage() ?>" />

    <div>
<?php if ($this->acl('routes', 'list')) { ?><input type="button" name="list" value="Lista" onclick="location.href='<?php echo $this->url(array(), 'routes_list') ?>'" /><?php } ?>
<?php if ($this->acl('routes', 'manage')) { ?><input type="submit" value="Actualizar" /><?php } ?>
    </div>

<?php if (count($this->routes)) { ?>
    <table>
        <tr>
            <th>Ruta</th>
            <th>Paquete</th>
            <th>Titulo</th>
            <th>Tipo</th>
        </tr>
    <?php foreach ($this->routes as $key => $route) { ?>
        <tr class="<?php echo $key % 2 == 0 ? 'even' : 'odd' ?>">
            <td><?php echo $route->route ?></td>
            <td><?php echo $route->module ?></td>
            <td><input type="text" name="routes[<?php echo $route->ident ?>][title]" value="<?php echo $route->label ?>" size="25" maxlength="32" /></td>
            <td><?php echo $this->menutype('routes[' . $route->ident . '][type]', $route->type) ?></td>
<?php /*            <td><input class="number" type="text" name="pages[<?php echo $page->ident ?>][menuorder]" size="2" maxlength="2" value="<?php echo $page->menuorder ?>" /></td>*/ ?>
        </tr>
    <?php } ?>
    </table>
<?php } else { ?>
    <p>No existen paginas registradas</p>
<?php } ?>

    <div>
<?php if ($this->acl('routes', 'list')) { ?><input type="button" name="list" value="Lista" onclick="location.href='<?php echo $this->url(array(), 'routes_list') ?>'" /><?php } ?>
<?php if ($this->acl('routes', 'manage')) { ?><input type="submit" value="Actualizar" /><?php } ?>
    </div>
</form>
