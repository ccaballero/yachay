<?php if ($this->note->priority) { ?>
	<h1>Aviso
<?php if ($this->resource->amAuthor()) { ?>
	<i><a href="<?= $this->url(array('note' => $this->resource->ident), 'notes_note_edit') ?>">[Editar]</a></i>
<?php } ?>
    </h1>
<?php } else {?>
	<h1>Nota
<?php if ($this->resource->amAuthor()) { ?>
	<i><a href="<?= $this->url(array('note' => $this->resource->ident), 'notes_note_edit') ?>">[Editar]</a></i>
<?php } ?>
	</h1>
<?php } ?>

<b>Autor: </b><i>
<?php if (Yeah_Acl::hasPermission('users', 'view')) { ?>
	<a href="<?= $this->url(array('user' => $this->resource->getAuthor()->url), 'users_user_view') ?>"><?= $this->resource->getAuthor()->label ?></a>
<?php } else { ?>
	<?= $this->resource->getAuthor()->label ?>
<?php } ?>
</i>
<br/>
<b>Fecha: </b><i><?= $this->timestamp($this->resource->tsregister) ?></i>

<p><?= $this->utf2html($this->note->note) ?></p>
