<?php global $CONFIG; ?>

<h1>Recursos registrados</h1>

<table>
    <tr>
    <?php if (isset($this->newroute)) { ?>
        <td>[<a href="<?= $this->url(array(), $this->newroute) ?>">Nuevo</a>]</td>
        <td>&nbsp;|&nbsp;</td>
    <?php } ?>
    	<td>[<a href="<?= $this->url(array(), 'resources_list') ?>">Todas</a>]</td>
        <td>[<a href="<?= $this->url(array('filter' => 'notes'),       'resources_filtered') ?>">Notas</a>]</td>
        <td>[<a href="<?= $this->url(array('filter' => 'files'),       'resources_filtered') ?>">Archivos</a>]</td>
        <td>[<a href="<?= $this->url(array('filter' => 'events'),      'resources_filtered') ?>">Eventos</a>]</td>
    <?php if (Yeah_Acl::hasPermission('subjects', 'teach')) { ?>
        <td>[<a href="<?= $this->url(array('filter' => 'evaluations'), 'resources_filtered') ?>">Evaluaciones</a>]</td>
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
            <td align="right"><?= $this->timestamp($resource->tsregister) ?></td>
		</tr>
		<tr>
			<td colspan="2">
				<?php $extended = $resource->getExtended(); ?>
				<?= $this->partial($extended->__type . '.php', array($extended->__type => $extended)) ?>
			</td>
		</tr>
		<tr>
			<td>
				[<a href="<?= $this->url(array($extended->__type => $resource->ident), $extended->__element . '_' . $extended->__type . '_view') ?>">Ver mas</a>]
            <?php if ($resource->amAuthor()) { ?>
				[<a href="<?= $this->url(array($extended->__type => $resource->ident), $extended->__element . '_' . $extended->__type . '_edit') ?>">Editar</a>]
				[<a href="<?= $this->url(array($extended->__type => $resource->ident), $extended->__element . '_' . $extended->__type . '_delete') ?>">Eliminar</a>]
            <?php } ?>
			</td>
            <td align="right">
            <?php if (isset($resource->recipient)) { ?>
                <?= $this->recipient($resource->recipient) ?>
            <?php } ?>
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
        <td>[<a href="<?= $this->url(array(), $this->newroute) ?>">Nuevo</a>]</td>
        <td>&nbsp;|&nbsp;</td>
    <?php } ?>
    	<td>[<a href="<?= $this->url(array(), 'resources_list') ?>">Todas</a>]</td>
        <td>[<a href="<?= $this->url(array('filter' => 'notes'),       'resources_filtered') ?>">Notas</a>]</td>
        <td>[<a href="<?= $this->url(array('filter' => 'files'),       'resources_filtered') ?>">Archivos</a>]</td>
        <td>[<a href="<?= $this->url(array('filter' => 'events'),      'resources_filtered') ?>">Eventos</a>]</td>
    <?php if (Yeah_Acl::hasPermission('subjects', 'teach')) { ?>
        <td>[<a href="<?= $this->url(array('filter' => 'evaluations'), 'resources_filtered') ?>">Evaluaciones</a>]</td>
    <?php } ?>
	</tr>
</table>
