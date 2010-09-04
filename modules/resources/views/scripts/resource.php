<?php global $CONFIG; ?>

<h2>Publicaciones</h2>
<?php if (count($this->resources)) { ?>
<center>
    <?= $this->paginator($this->resources, $this->route) ?>
    <hr />
    <table width="90%">
    <?php foreach ($this->resources as $resource) { ?>
		<tr>
			<td rowspan="3" valign="top" width="50px"><img src="<?= $CONFIG->wwwroot . 'media/users/thumbnail_small/' . $resource->getAuthor()->getAvatar() ?>" /></td>
			<td><b><?= $this->utf2html($resource->getAuthor()->getFullName()) ?></b></td>
            <td width="150px" align="right"><?= $this->timestamp($resource->tsregister) ?></td>
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
        <tr>
            <td colspan="3">&nbsp;</td>
        </tr>
    <?php } ?>
	</table>
	<hr />
    <?= $this->paginator($this->resources, $this->route) ?>
</center>
<?php } else { ?>
<p>No se registraron recursos a&uacute;n.</p>
<?php } ?>
