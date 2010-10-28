<h1>Etiqueta: <?= $this->tag->label ?></h1>

<table width="100%">
    <tr>
    <?php if (count($this->communities) <> 0) { ?>
        <td valign="top">
            <h2>Comunidades</h2>
            <?php foreach ($this->communities as $community) { ?>
                <?php if (Yeah_Acl::hasPermission('communities', 'view')) { ?>
                    <a href="<?= $this->url(array('community' => $community->url), 'communities_community_view') ?>">
                <?php } ?>
                    <img src="<?= $this->media . '../communities/thumbnail_medium/' . $community->getAvatar() ?>" alt="<?= $community->label ?>"/>
                <?php if (Yeah_Acl::hasPermission('communities', 'view')) { ?>
                    </a>
                <?php } ?>
            <?php } ?>
        </td>
    <?php } ?>
    <?php if (count($this->users) <> 0) { ?>
        <td valign="top">
            <h2>Usuarios</h2>
            <?php foreach ($this->users as $user) { ?>
                <?php if (Yeah_Acl::hasPermission('users', 'view')) { ?>
                    <a href="<?= $this->url(array('user' => $user->url), 'users_user_view') ?>">
                <?php } ?>
                    <img src="<?= $this->media . '../users/thumbnail_medium/' . $user->getAvatar() ?>" alt="<?= $user->getFullName() ?>"/>
                <?php if (Yeah_Acl::hasPermission('users', 'view')) { ?>
                    </a>
                <?php } ?>
            <?php } ?>
        </td>
    <?php } ?>
    </tr>
</table>

<?= $this->partial('resource.php', array('resources' => $this->resources, 'route' => $this->route)) ?>
