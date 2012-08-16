<?php
    $resource = $this->resource;
    $comments = $resource->findComments();
?>

<?php if (count($comments)) { ?>
    <?php foreach ($comments as $comment) { ?>
        <?php $author = $comment->getAuthor(); ?>
        <div class="resource">
            <span class="label"><?php echo $author->getFullName() ?></span>
            <div class="avatar">
            <?php if ($this->acl('users', 'view')) { ?>
                <a href="<?php echo $this->url(array('user' => $author->url), 'users_user_view') ?>"><img src="<?php echo $this->config->resources->frontController->baseUrl . '/media/users/thumbnail_small/' . $author->getAvatar() ?>" alt="<?php echo $author->getFullName() ?>" title="<?php echo $author->getFullName() ?>" /></a>
            <?php } else { ?>
                <img src="<?php echo $this->config->resources->frontController->baseUrl . '/media/users/thumbnail_small/' . $author->getAvatar() ?>" alt="<?php echo $author->getFullName() ?>" title="<?php echo $author->getFullName() ?>" />
            <?php } ?>
            </div>
            <div class="message">
                <p><?php echo $this->specialEscape($this->escape($comment->comment)) ?></p>
            </div>
            <span class="addon">
                <span class="viewall">
            <?php if ($comment->amAuthor()) { ?>
                <img src="<?php echo $this->template->htmlbase . 'images/delete.png' ?>" alt="" title="" />
                <a href="<?php echo $this->url(array('resource' => $resource->ident, 'comment' => $comment->ident), $this->comment_route . '_delete') ?>">Eliminar</a>
            <?php } else if ($this->acl('comments', 'drop')) { ?>
                <img src="<?php echo $this->template->htmlbase . 'images/error.png' ?>" alt="" title="" />
                <a href="<?php echo $this->url(array('comment' => $comment->ident), 'comments_drop') ?>">Eliminar</a>
            <?php } ?>
                </span>
            </span>
            <span class="timestamp"><?php echo $this->timestamp($comment->tsregister) ?></span>
        </div>
    <?php } ?>
<?php } else { ?>
    <p>No se registraron comentarios aún.</p>
<?php } ?>
