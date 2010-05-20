<h1><?= $this->event->label ?>
<?php if ($this->resource->amAuthor()) { ?>
	<i><a href="<?= $this->url(array('event' => $this->resource->ident), 'events_event_edit') ?>">[Editar]</a></i>
<?php } ?>
</h1>

<b>Autor: </b><i>
<?php if (Yeah_Acl::hasPermission('users', 'view')) { ?>
	<a href="<?= $this->url(array('user' => $this->resource->getAuthor()->url), 'users_user_view') ?>"><?= $this->resource->getAuthor()->label ?></a>
<?php } else { ?>
	<?= $this->resource->getAuthor()->label ?>
<?php } ?>
</i>
<br/>
<b>Fecha: </b><i><?= $this->timestamp($this->resource->tsregister) ?></i>

<br />
<?php if ($this->event->duration == 0) { ?>
	<b>A partir del:</b> <?= $this->timestamp($this->event->event) ?>
<?php } else { ?>
	<b>Del</b> <?= $this->timestamp($this->event->event) ?> <b>al</b> <?= $this->timestamp($this->event->event + $this->event->duration) ?>
<?php } ?>
<br />
<br />
<?= $this->event->message ?>
