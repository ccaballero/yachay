<?php if ($this->acl('resources', 'view')) { ?>
<h2>Publicaciones</h2>
    <?php if (count($this->resources)) { ?>
        <?php if ($this->paginator) { ?>
        <?php echo $this->paginator($this->resources, $this->route) ?>
        <?php } ?>
        <div id="resources">
        <?php foreach ($this->resources as $resource) { ?>
            <?php $author = $resource->getAuthor(); ?>
            <?php $extended = $resource->getExtended(); ?>
            <div class="resource">
                <span class="recipient"><?php echo $this->recipient($resource->recipient) ?></span>
                <span class="label"><?php echo $extended->getLabel() ?></span>
                <div class="avatar">
                <?php if ($this->acl('users', 'view')) { ?>
                    <a href="<?php echo $this->url(array('user' => $author->url), 'users_user_view') ?>"><img src="<?php echo $this->CONFIG->wwwroot . 'media/users/thumbnail_small/' . $author->getAvatar() ?>" alt="<?php echo $author->getFullName() ?>" title="<?php echo $author->getFullName() ?>" /></a>
                <?php } else { ?>
                    <img src="<?php echo $this->CONFIG->wwwroot . 'media/users/thumbnail_small/' . $author->getAvatar() ?>" alt="<?php echo $author->getFullName() ?>" title="<?php echo $author->getFullName() ?>" />
                <?php } ?>
                </div>
                <div class="message">
                    <?php echo $this->partial($this->template($extended->__element, $extended->__type), array($extended->__type => $extended, 'CONFIG' => $this->CONFIG, 'TEMPLATE' => $this->TEMPLATE)) ?>
                </div>
                <span class="addon">
            <?php if (isset($resource->viewers)) { ?>
                    <img src="<?php echo $this->TEMPLATE->htmlbase . 'images/eye.png' ?>" alt="Visitado" title="Visitas" />
                    <span>(<?php echo $resource->viewers ?>)</span>
            <?php } ?>
            <?php if (isset($resource->comments)) { ?>
                    <img src="<?php echo $this->TEMPLATE->htmlbase . 'images/comment.png' ?>" alt="Comentarios" title="Comentarios" />
                    <span>(<?php echo $resource->comments ?>)</span>
                <?php if ($resource->ratings >= 0) { ?>
                    <img src="<?php echo $this->TEMPLATE->htmlbase . 'images/thumb_up.png' ?>" alt="Valoración" title="Valoración" />
                <?php } else { ?>
                    <img src="<?php echo $this->TEMPLATE->htmlbase . 'images/thumb_down.png' ?>" alt="Valoración" title="Valoración" />
                <?php } ?>
                    <span>(<?php echo $resource->ratings ?>/<?php echo $resource->raters ?>)</span>
            <?php } ?>
                    <span class="viewall">
                        <img src="<?php echo $this->TEMPLATE->htmlbase . 'images/page_white_text.png' ?>" alt="" title="" />
                        <a href="<?php echo $this->url(array($extended->__type => $extended->resource), $extended->__element . '_' . $extended->__type . '_view') ?>">Ver mas</a>
                <?php if ($resource->amAuthor()) { ?>
                    <img src="<?php echo $this->TEMPLATE->htmlbase . 'images/pencil.png' ?>" alt="" title="" />
                    <a href="<?php echo $this->url(array($extended->__type => $extended->resource), $extended->__element . '_' . $extended->__type . '_edit') ?>">Editar</a>
                    <img src="<?php echo $this->TEMPLATE->htmlbase . 'images/delete.png' ?>" alt="" title="" />
                    <a href="<?php echo $this->url(array($extended->__type => $extended->resource), $extended->__element . '_' . $extended->__type . '_delete') ?>">Eliminar</a>
                <?php } else if ($this->acl('resources', 'drop')) { ?>
                    <img src="<?php echo $this->TEMPLATE->htmlbase . 'images/error.png' ?>" alt="" title="" />
                    <a href="<?php echo $this->url(array($extended->__type => $extended->resource), $extended->__element . '_' . $extended->__type . '_drop') ?>">Eliminar</a>
                <?php } ?>
                    </span>
                </span>
                <span class="timestamp"><?php echo $this->timestamp($resource->tsregister) ?></span>
            </div>
        <?php } ?>
        </div>
        <?php if ($this->paginator) { ?>
        <?php echo $this->paginator($this->resources, $this->route) ?>
        <?php } ?>
    <?php } else { ?>
        <p>No se registraron recursos aún.</p>
    <?php } ?>
<?php } ?>
