<?php if (Yeah_Acl::hasPermission('resources', 'view')) { ?>
<h2>Publicaciones</h2>
    <?php if (count($this->resources)) { ?>
        <?= $this->paginator($this->resources, $this->route) ?>
        <div id="resources">
        <?php foreach ($this->resources as $resource) { ?>
            <?php $extended = $resource->getExtended(); ?>
            <div class="resource">
                <div class="avatar">
                    <?php if (Yeah_Acl::hasPermission('users', 'view')) { ?>
                        <a href="<?= $this->url(array('user' => $resource->getAuthor()->url), 'users_user_view') ?>">
                            <img src="<?= $this->config->wwwroot . 'media/users/thumbnail_small/' . $resource->getAuthor()->getAvatar() ?>" alt="" />
                        </a>
                    <?php } else { ?>
                        <img src="<?= $this->config->wwwroot . 'media/users/thumbnail_small/' . $resource->getAuthor()->getAvatar() ?>" alt="" />
                    <?php } ?>
                </div>
                <div class="details">
                    <div class="label">
                        <?= strtoupper($extended->__label) ?>
                    </div>
                    <div class="user">
                        <?php if (Yeah_Acl::hasPermission('users', 'view')) { ?>
                            <a href="<?= $this->url(array('user' => $resource->getAuthor()->url), 'users_user_view') ?>"><?= $resource->getAuthor()->getFullName() ?></a>
                        <?php } else { ?>
                            <?= $resource->getAuthor()->getFullName() ?>
                        <?php } ?>
                    </div>
                    <div class="timestamp">
                        <?= $this->timestamp($resource->tsregister) ?>
                    </div>

                    <?= $this->partial($extended->__type . '.php', array($extended->__type => $extended)) ?>

                    <div class="addons">
                        Comentarios (<?= $resource->comments ?>) |
                        Valoración (<?= $resource->ratings ?>/<?= $resource->raters ?>) |
                        [<a href="<?= $this->url(array($extended->__type => $extended->resource), $extended->__element . '_' . $extended->__type . '_view') ?>">Ver mas</a>]
                        <?php if (Yeah_Acl::hasPermission('resources', 'drop')) { ?>
                            [<a href="<?= $this->url(array($extended->__type => $extended->resource), $extended->__element . '_' . $extended->__type . '_drop') ?>">Eliminar</a>]
                        <?php } ?>
                    </div>
                    <div class="recipient">
                        <?php if (isset($resource->recipient)) { ?>
                            <?= $this->recipient($resource->recipient) ?>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="clear"></div>
        <?php } ?>
        </div>
        <?= $this->paginator($this->resources, $this->route) ?>
    <?php } else { ?>
        <p>No se registraron recursos aún.</p>
    <?php } ?>
<?php } ?>
