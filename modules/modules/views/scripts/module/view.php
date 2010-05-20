<h1>Modulo: <?= $this->utf2html($this->module->label) ?></h1>

<i><b>Estado:</b><?= $this->utf2html($this->status($this->module->status)) ?></i>
<br />
<i><b>Tipo:</b><?= $this->utf2html($this->type($this->module->type)) ?></i>

<p><?= $this->utf2html($this->module->description) ?></p>

<h2>Rutas registradas</h2>
<?php if (isset($this->model)) { ?>
<center>
	<table border="1">
	    <tr>
	        <th>Ruta</th>
	        <th>Modulo</th>
	        <th>Controlador</th>
	        <th>Accion</th>
	        <th>Url</th>
	    </tr>
	<?php foreach($this->model->routes as $label => $route) { ?>
	    <tr>
	        <td><?= $label ?></td>
	        <td><?= $route[1]['module'] ?></td>
	        <td><?= $route[1]['controller'] ?></td>
	        <td><?= $route[1]['action'] ?></td>
	        <td><?= $route[0] ?></td>
	    </tr>
	<?php } ?>
	</table>
</center>
<?php } else { ?>
    <p>No se registraron rutas para este modulo.</p>
<?php } ?>
