<h1>Etiqueta: <?= $this->tag->label ?></h1>

<table width="100%">
    <tr>
    <?php if (count($this->communities) <> 0) { ?>
        <td valign="top">
            <h2>Comunidades</h2>
            <ul>
            <?php foreach ($this->communities as $community) { ?>
                <li>
                <?php if ($this->acl('communities', 'view')) { ?>
                    <a href="<?= $this->url(array('community' => $community->url), 'communities_community_view') ?>">
                <?php } ?>
                    <?= $community->label ?>
                <?php if ($this->acl('communities', 'view')) { ?>
                    </a>
                <?php } ?>
                </li>
            <?php } ?>
            </ul>
        </td>
    <?php } ?>
    <?php if (count($this->users) <> 0) { ?>
        <td valign="top">
            <h2>Usuarios</h2>
            <ul>
            <?php foreach ($this->users as $user) { ?>
                <li>
                <?php if ($this->acl('users', 'view')) { ?>
                    <a href="<?= $this->url(array('user' => $user->url), 'users_user_view') ?>">
                <?php } ?>
                    <?= $user->getFullName() ?>
                <?php if ($this->acl('users', 'view')) { ?>
                    </a>
                <?php } ?>
                </li>
            <?php } ?>
            </ul>
        </td>
    <?php } ?>
    </tr>
</table>

<?= $this->partial('resource.php', array('resources' => $this->resources, 'route' => $this->route)) ?>
