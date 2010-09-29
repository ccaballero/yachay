<h1>Archivo
<?php if ($this->resource->amAuthor()) { ?>
	[<i><a href="<?= $this->url(array('file' => $this->resource->ident), 'files_file_edit') ?>">Editar</a></i>]
<?php } ?>
</h1>

<table width="100%">
    <tr>
        <td rowspan="3" width="100px" valign="top">
        <?php if (Yeah_Acl::hasPermission('users', 'view')) { ?>
            <a href="<?= $this->url(array('user' => $this->resource->getAuthor()->url), 'users_user_view') ?>">
                <img src="<?= $this->media . '../users/thumbnail_medium/' . $this->resource->getAuthor()->getAvatar() ?>" />
            </a>
        <?php } else { ?>
            <img src="<?= $this->media . '../users/thumbnail_medium/' . $this->resource->getAuthor()->getAvatar() ?>" />
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
            <b>Fecha: </b><i><?= $this->timestamp($this->resource->tsregister) ?></i>
        </td>
    </tr>
</table>

<p><?= $this->utf2html($this->file->description) ?></p>

<center>
    <?= $this->mime($this->file->mime) ?>&nbsp;
    <a href="<?= $this->url(array('file' => $this->file->resource), 'files_file_download') ?>"><?= $this->utf2html($this->file->filename) ?></a>
    &nbsp;<?= $this->size($this->file->size) ?>
</center>

<?php if (Yeah_Acl::hasPermission('comments', 'view')) { ?>
    <h2>Comentarios</h2>
    <?= $this->partial('comments.php', array('resource' => $this->resource, 'route' => 'files_file_comment')) ?>
    <?php if (Yeah_Acl::hasPermission('comments', 'new')) { ?>
    <?= $this->partial('comment/post.php', array('resource' => $this->resource, 'route' => 'files_file_comment')) ?>
    <?php } ?>
<?php } ?>
