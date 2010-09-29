<?php global $CONFIG; ?>

<?php
    $resource = $this->resource;
    $comments = $resource->findmodules_comments_models_Comments();
?>

<?php if (count($comments)) { ?>
    <table width="100%">
    <?php foreach ($comments as $comment) { ?>
    <?php $author = $comment->getAuthor(); ?>
        <tr>
            <td rowspan="3" width="50px" valign="top">
                <?php if (Yeah_Acl::hasPermission('users', 'view')) { ?>
                    <a href="<?= $this->url(array('user' => $author->url), 'users_user_view') ?>">
                        <img src="<?= $CONFIG->wwwroot . 'media/users/thumbnail_small/' . $author->getAvatar() ?>" />
                    </a>
                <?php } else { ?>
                    <img src="<?= $CONFIG->wwwroot . 'media/users/thumbnail_small/' . $author->getAvatar() ?>" />
                <?php } ?>
            </td>
            <td valign="top"><b><?= $author->label ?></b>:</td>
            <td valign="top" align="right"><?= $this->timestamp($comment->tsregister) ?></td>
        </tr>
        <tr>
            <td colspan="2" valign="top">
                <?= $comment->comment ?>
            </td>
        </tr>
        <tr>
            <td>
        <?php if ($comment->amAuthor()) { ?>
            [<a href="<?= $this->url(array('resource' => $resource->ident, 'comment' => $comment->ident), $this->route . '_delete') ?>">Eliminar</a>]
        <?php } else if (Yeah_Acl::hasPermission('comments', 'drop')) { ?>
            [<a href="<?= $this->url(array('comment' => $comment->ident), 'comments_drop') ?>">Eliminar</a>]
        <?php } ?>
            </td>
        </tr>
    <?php } ?>
    </table>

<?php } else { ?>
    <p>No se registraron comentarios a&uacute;n.</p>
<?php } ?>
