<?php if ($this->acl('resources', 'view')) { ?>
<h2>Publicaciones</h2>
    <?php if (count($this->resources)) { ?>
        <?php if ($this->paginator) { ?>
            <?= $this->paginator($this->resources, $this->route) ?>
        <?php } ?>
        <div id="resources">
        <?php foreach ($this->resources as $resource) { ?>
            <?php $author = $resource->getAuthor(); ?>
            <?php $extended = $resource->getExtended(); ?>
            <div class="resource">
                <span class="recipient"><?= $this->recipient($resource->recipient) ?></span>
                <span class="label"><?= $extended->getLabel() ?></span>
                <div class="avatar">
                <?php if ($this->acl('users', 'view')) { ?>
                    <a href="<?= $this->url(array('user' => $author->url), 'users_user_view') ?>"><img src="<?= $this->CONFIG->wwwroot . 'media/users/thumbnail_small/' . $author->getAvatar() ?>" alt="<?= $author->getFullName() ?>" title="<?= $author->getFullName() ?>" /></a>
                <?php } else { ?>
                    <img src="<?= $this->CONFIG->wwwroot . 'media/users/thumbnail_small/' . $author->getAvatar() ?>" alt="<?= $author->getFullName() ?>" title="<?= $author->getFullName() ?>" />
                <?php } ?>
                </div>
                <div class="message">
                    <?= $this->partial($this->template($extended->__element, $extended->__type), array($extended->__type => $extended, 'CONFIG' => $this->CONFIG, 'TEMPLATE' => $this->TEMPLATE)) ?>
                </div>
                <span class="addon">
            <?php if (isset($resource->comments)) { ?>
                    <img src="<?= $this->TEMPLATE->htmlbase . 'images/comment.png' ?>" alt="Comentarios" title="Comentarios" />
                    <span>(<?= $resource->comments ?>)</span>
                <?php if ($resource->ratings >= 0) { ?>
                    <img src="<?= $this->TEMPLATE->htmlbase . 'images/thumb_up.png' ?>" alt="Valoración" title="Valoración" />
                <?php } else { ?>
                    <img src="<?= $this->TEMPLATE->htmlbase . 'images/thumb_down.png' ?>" alt="Valoración" title="Valoración" />
                <?php } ?>
                    <span>(<?= $resource->ratings ?>/<?= $resource->raters ?>)</span>
            <?php } ?>
                    <span class="viewall">
                        <img src="<?= $this->TEMPLATE->htmlbase . 'images/page_white_text.png' ?>" alt="" title="" />
                        <a href="<?= $this->url(array($extended->__type => $extended->resource), $extended->__element . '_' . $extended->__type . '_view') ?>">Ver mas</a>
                <?php if ($resource->amAuthor()) { ?>
                    <img src="<?= $this->TEMPLATE->htmlbase . 'images/pencil.png' ?>" alt="" title="" />
                    <a href="<?= $this->url(array($extended->__type => $extended->resource), $extended->__element . '_' . $extended->__type . '_edit') ?>">Editar</a>
                    <img src="<?= $this->TEMPLATE->htmlbase . 'images/delete.png' ?>" alt="" title="" />
                    <a href="<?= $this->url(array($extended->__type => $extended->resource), $extended->__element . '_' . $extended->__type . '_delete') ?>">Eliminar</a>
                <?php } else if ($this->acl('resources', 'drop')) { ?>
                    <img src="<?= $this->TEMPLATE->htmlbase . 'images/error.png' ?>" alt="" title="" />
                    <a href="<?= $this->url(array($extended->__type => $extended->resource), $extended->__element . '_' . $extended->__type . '_drop') ?>">Eliminar</a>
                <?php } ?>
                    </span>
                </span>
                <span class="timestamp"><?= $this->timestamp($resource->tsregister) ?></span>
            </div>
        <?php } ?>
        </div>
        <?php if ($this->paginator) { ?>
            <?= $this->paginator($this->resources, $this->route) ?>
        <?php } ?>
    <?php } else { ?>
        <p>No se registraron recursos aún.</p>
    <?php } ?>
<?php } ?>
