<?php global $CONFIG; ?>

<h2>Publicaciones</h2>
<?php if (count($this->resources)) { ?>
<center>
    <?= $this->paginator($this->resources, $this->route) ?>
    <hr />
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
				<a href="<?= $this->url(array($extended->__type => $extended->resource), $extended->__element . '_' . $extended->__type . '_view') ?>">[Ver mas]</a>
			</td>
		</tr>
	</table>
	<br />
<?php } ?>
	<hr />
    <?= $this->paginator($this->resources, $this->route) ?>
</center>
<?php } else { ?>
<p>No se registraron recursos a&uacute;n.</p>
<?php } ?>
