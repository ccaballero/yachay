<?php if (Yeah_Acl::hasPermission('resources', 'new')) { ?>
<table>
    <tr>
    	<td>
		    [<a href="<?= $this->url(array('filter' => 'notes'), 'resources_filtered') ?>">Notas</a>]
		    &nbsp;<small>[<a href="<?= $this->url(array(), 'notes_new') ?>">Crear</a>]</small>
		</td>
	</tr>
	<tr>
    	<td>
    		[<a href="<?= $this->url(array('filter' => 'files'), 'resources_filtered') ?>">Archivos</a>]
		    &nbsp;<small>[<a href="<?= $this->url(array(), 'files_new') ?>">Crear</a>]</small>
	    </td>
	</tr>
	<tr>
    	<td>
		    [<a href="<?= $this->url(array('filter' => 'events'), 'resources_filtered') ?>">Eventos</a>]
		    &nbsp;<small>[<a href="<?= $this->url(array(), 'events_new') ?>">Crear</a>]</small>
		</td>
	</tr>
<?php if (Yeah_Acl::hasPermission('subjects', 'teach')) { ?>
	<tr>
    	<td>
		    [<a href="<?= $this->url(array('filter' => 'evaluations'), 'resources_filtered') ?>">Evaluaciones</a>]
		    &nbsp;<small>[<a href="<?= $this->url(array(), 'evaluations_new') ?>">Crear</a>]</small>
		</td>
	</tr>
	<tr>
    	<td>
		    [<a href="<?= $this->url(array(), 'groupsets_manager') ?>">Conjuntos</a>]
		    &nbsp;<small>[<a href="<?= $this->url(array(), 'groupsets_new') ?>">Crear</a>]</small>
		</td>
	</tr>
<?php } ?>
	<tr>
    	<td>
		    [<a href="<?= $this->url(array(), 'resources_list') ?>">Ver todos</a>]
		</td>
	</tr>
</table>
<?php }?>