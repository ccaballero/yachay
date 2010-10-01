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
        <td rowspan="4" width="100px" valign="top">
        <?php if (Yeah_Acl::hasPermission('users', 'view')) { ?>
            <a href="<?= $this->url(array('user' => $this->resource->getAuthor()->url), 'users_user_view') ?>">
                <img src="<?= $this->media . '../users/thumbnail_medium/' . $this->resource->getAuthor()->getAvatar() ?>" alt="<?= $this->resource->getAuthor()->getFullName() ?>" />
            </a>
        <?php } else { ?>
            <img src="<?= $this->media . '../users/thumbnail_medium/' . $this->resource->getAuthor()->getAvatar() ?>" alt="<?= $this->resource->getAuthor()->getFullName() ?>" />
        <?php } ?>
        </td>
        <td valign="top">
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
            <b>Valoración: </b>
            <a href="<?= $this->url(array('resource' => $this->resource->ident), 'notes_note_rating_down') ?>"><b>&laquo;</b></a>
                <i><?= $this->resource->ratings ?> / <?= $this->resource->raters ?></i>
            <a href="<?= $this->url(array('resource' => $this->resource->ident), 'notes_note_rating_up') ?>"><b>&raquo;</b></a>
        </td>
    </tr>
    <tr valign="top">
        <td>
            <b>Fecha: </b><i><?= $this->timestamp($this->resource->tsregister) ?></i>
        </td>
    </tr>
</table>

<p><?= $this->utf2html($this->note->note) ?></p>

<?php if (Yeah_Acl::hasPermission('comments', 'view')) { ?>
    <h2>Comentarios</h2>
    <?= $this->partial('comments.php', array('resource' => $this->resource, 'route' => 'notes_note_comment')) ?>
    <?php if (Yeah_Acl::hasPermission('comments', 'new')) { ?>
    <?= $this->partial('comment/post.php', array('resource' => $this->resource, 'route' => 'notes_note_comment')) ?>
    <?php } ?>
<?php } ?>
