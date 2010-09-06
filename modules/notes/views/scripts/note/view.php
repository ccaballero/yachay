<?php if ($this->note->priority) { ?>
	<h1>Aviso
<?php if ($this->resource->amAuthor()) { ?>
	[<i><a href="<?= $this->url(array('note' => $this->resource->ident), 'notes_note_edit') ?>">Editar</a></i>]
<?php } ?>
    </h1>
<?php } else {?>
	<h1>Nota
<?php if ($this->resource->amAuthor()) { ?>
	[<i><a href="<?= $this->url(array('note' => $this->resource->ident), 'notes_note_edit') ?>">Editar</a></i>]
<?php } ?>
	</h1>
<?php } ?>

<table width="100%">
    <tr>
        <td rowspan="3" width="50px" valign="top">
        <?php if (Yeah_Acl::hasPermission('users', 'view')) { ?>
            <a href="<?= $this->url(array('user' => $this->resource->getAuthor()->url), 'users_user_view') ?>">
                <img src="<?= $this->media . '../users/thumbnail_small/' . $this->resource->getAuthor()->getAvatar() ?>" />
            </a>
        <?php } else { ?>
            <img src="<?= $this->media . '../users/thumbnail_small/' . $this->resource->getAuthor()->getAvatar() ?>" />
        <?php } ?>
        </td>
        <td>
            <b>Autor: </b>
            <i>
            <?php if (Yeah_Acl::hasPermission('users', 'view')) { ?>
                <a href="<?= $this->url(array('user' => $this->resource->getAuthor()->url), 'users_user_view') ?>"><?= $this->resource->getAuthor()->label ?></a>
            <?php } else { ?>
                <?= $this->resource->getAuthor()->label ?>
            <?php } ?>
            </i>
        </td>
    </tr>
    <tr valign="top">
        <td>
            <b>Publicado en: </b><i><?= $this->recipient($this->resource->recipient) ?></i>
        </td>
    </tr>
    <tr valign="top">
        <td>
            <b>Fecha: </b><i><?= $this->timestamp($this->resource->tsregister) ?></i>
        </td>
    </tr>
</table>

<p><?= $this->utf2html($this->note->note) ?></p>
