<?php
    $resource = $this->resource;
    $comments = $resource->findComments();
?>

<?php if (count($comments)) { ?>
    <?php foreach ($comments as $comment) { ?>
        <?php $author = $comment->getAuthor(); ?>
        <div class="resource">
            <span class="label"><?= $author->getFullName() ?></span>
            <div class="avatar">
            <?php if ($this->acl('users', 'view')) { ?>
                <a href="<?= $this->url(array('user' => $author->url), 'users_user_view') ?>"><img src="<?= $this->CONFIG->wwwroot . 'media/users/thumbnail_small/' . $author->getAvatar() ?>" alt="<?= $author->getFullName() ?>" title="<?= $author->getFullName() ?>" /></a>
            <?php } else { ?>
                <img src="<?= $this->CONFIG->wwwroot . 'media/users/thumbnail_small/' . $author->getAvatar() ?>" alt="<?= $author->getFullName() ?>" title="<?= $author->getFullName() ?>" />
            <?php } ?>
            </div>
            <div class="message"><p><?= $comment->comment ?></p></div>
            <span class="addon">
                <span class="viewall">
            <?php if ($comment->amAuthor()) { ?>
                <img src="<?= $this->TEMPLATE->htmlbase . 'images/delete.png' ?>" alt="" title="" />
                <a href="<?= $this->url(array('resource' => $resource->ident, 'comment' => $comment->ident), $this->route . '_delete') ?>">Eliminar</a>
            <?php } else if ($this->acl('comments', 'drop')) { ?>
                <img src="<?= $this->TEMPLATE->htmlbase . 'images/error.png' ?>" alt="" title="" />
                <a href="<?= $this->url(array('comment' => $comment->ident), 'comments_drop') ?>">Eliminar</a>
            <?php } ?>
                </span>
            </span>
            <span class="timestamp"><?= $this->timestamp($comment->tsregister) ?></span>
        </div>
    <?php } ?>
<?php } else { ?>
    <p>No se registraron comentarios aún.</p>
<?php } ?>
