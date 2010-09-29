<?php global $CONFIG; ?>

<?php if (Yeah_Acl::hasPermission('resources', 'view')) { ?>
    <h2>Publicaciones</h2>
    <?php if (count($this->resources)) { ?>
    <center>
        <?= $this->paginator($this->resources, $this->route) ?>
        <hr />
        <table width="90%">
        <?php foreach ($this->resources as $resource) { ?>
            <tr>
                <td rowspan="3" valign="top" width="50px">
                <?php if (Yeah_Acl::hasPermission('users', 'view')) { ?>
                    <a href="<?= $this->url(array('user' => $resource->getAuthor()->url), 'users_user_view') ?>">
                        <img src="<?= $CONFIG->wwwroot . 'media/users/thumbnail_small/' . $resource->getAuthor()->getAvatar() ?>" />
                    </a>
                <?php } else { ?>
                    <img src="<?= $CONFIG->wwwroot . 'media/users/thumbnail_small/' . $resource->getAuthor()->getAvatar() ?>" />
                <?php } ?>
                </td>
                <td>
                <?php if (Yeah_Acl::hasPermission('users', 'view')) { ?>
                    <b><a href="<?= $this->url(array('user' => $resource->getAuthor()->url), 'users_user_view') ?>"><?= $this->utf2html($resource->getAuthor()->getFullName()) ?></a></b>
                <?php } else { ?>
                    <b><?= $this->utf2html($resource->getAuthor()->getFullName()) ?></b>
                <?php } ?>
                </td>
                <td width="250px" align="right"><?= $this->timestamp($resource->tsregister) ?></td>
            </tr>
            <tr>
                <td colspan="2">
                    <?php $extended = $resource->getExtended(); ?>
                    <?= $this->partial($extended->__type . '.php', array($extended->__type => $extended)) ?>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    Comentarios (<?= $resource->comments ?>) | 
                    [<a href="<?= $this->url(array($extended->__type => $extended->resource), $extended->__element . '_' . $extended->__type . '_view') ?>">Ver mas</a>]
                <?php if (Yeah_Acl::hasPermission('resources', 'drop')) { ?>
                    [<a href="<?= $this->url(array($extended->__type => $extended->resource), $extended->__element . '_' . $extended->__type . '_drop') ?>">Eliminar</a>]
                <?php } ?>
                </td>
            </tr>
            <tr>
                <td colspan="3">&nbsp;</td>
            </tr>
        <?php } ?>
        </table>
        <hr />
        <?= $this->paginator($this->resources, $this->route) ?>
    </center>
    <?php } else { ?>
    <p>No se registraron recursos a&uacute;n.</p>
    <?php } ?>
<?php } ?>
