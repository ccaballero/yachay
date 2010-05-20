<?php global $CONFIG; ?>

<h1>Recursos registrados</h1>

<table>
    <tr>
    <?php if (isset($this->newroute)) { ?>
        <td><input type="button" value="Nuevo"        onclick="location.href='<?= $this->url(array(), $this->newroute) ?>'" /></td>
        <td>&nbsp;|&nbsp;</td>
    <?php } ?>
    	<td><input type="button" value="Todas"        onclick="location.href='<?= $this->url(array(), 'resources_list') ?>'" /></td>
        <td><input type="button" value="Notas"        onclick="location.href='<?= $this->url(array('filter' => 'notes'),       'resources_filtered') ?>'" /></td>
        <td><input type="button" value="Archivos"     onclick="location.href='<?= $this->url(array('filter' => 'files'),       'resources_filtered') ?>'" /></td>
        <td><input type="button" value="Eventos"      onclick="location.href='<?= $this->url(array('filter' => 'events'),      'resources_filtered') ?>'" /></td>
    <?php if (Yeah_Acl::hasPermission('subjects', 'teach')) { ?>
        <td><input type="button" value="Evaluaciones" onclick="location.href='<?= $this->url(array('filter' => 'evaluations'), 'resources_filtered') ?>'" /></td>
    <?php } ?>
	</tr>
</table>

    <hr />
<?php if (count($this->resources)) { ?>
    <center>
		<?php foreach ($this->resources as $resource) { ?>
	<table width="90%">
		<tr>
			<td rowspan="3" valign="top" width="50px"><img src="<?= $CONFIG->wwwroot . 'media/users/thumbnail_small/' . $resource->getAuthor()->getAvatar() ?>" /></td>
			<td><?= $this->utf2html($resource->getAuthor()->getFullName()) ?></td>
			<td><?= $this->timestamp($resource->tsregister) ?></td>
		</tr>
		<tr>
			<td colspan="2">
				<?php $extended = $resource->getExtended(); ?>
				<?= $this->partial($extended->__type . '.php', array($extended->__type => $extended)) ?>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<a href="<?= $this->url(array($extended->__type => $resource->ident), $extended->__element . '_' . $extended->__type . '_view') ?>">[Ver mas]</a>
			</td>
		</tr>
	</table>
	<br />
<?php } ?>
    </center>
<?php } else { ?>
    <p>No existen recursos registrados</p>
<?php } ?>
    <hr />

<table>
    <tr>
    <?php if (isset($this->newroute)) { ?>
        <td><input type="button" value="Nuevo"        onclick="location.href='<?= $this->url(array(), $this->newroute) ?>'" /></td>
        <td>&nbsp;|&nbsp;</td>
    <?php } ?>
    	<td><input type="button" value="Todas"        onclick="location.href='<?= $this->url(array(), 'resources_list') ?>'" /></td>
        <td><input type="button" value="Notas"        onclick="location.href='<?= $this->url(array('filter' => 'notes'),       'resources_filtered') ?>'" /></td>
        <td><input type="button" value="Archivos"     onclick="location.href='<?= $this->url(array('filter' => 'files'),       'resources_filtered') ?>'" /></td>
        <td><input type="button" value="Eventos"      onclick="location.href='<?= $this->url(array('filter' => 'events'),      'resources_filtered') ?>'" /></td>
    <?php if (Yeah_Acl::hasPermission('subjects', 'teach')) { ?>
        <td><input type="button" value="Evaluaciones" onclick="location.href='<?= $this->url(array('filter' => 'evaluations'), 'resources_filtered') ?>'" /></td>
    <?php } ?>
	</tr>
</table>
