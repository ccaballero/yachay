<?php
    $resource = $this->resource;
    $comments = $resource->findComments();
?>

<?php if (count($comments)) { ?>
    <table width="100%">
    <?php foreach ($comments as $comment) { ?>
        <?php $author = $comment->getAuthor(); ?>
        <tr>
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
        <?php } else if ($this->acl('comments', 'drop')) { ?>
            [<a href="<?= $this->url(array('comment' => $comment->ident), 'comments_drop') ?>">Eliminar</a>]
        <?php } ?>
            </td>
        </tr>
    <?php } ?>
    </table>

<?php } else { ?>
    <p>No se registraron comentarios aún.</p>
<?php } ?>
