<h1>Etiqueta: <?= $this->tag->label ?></h1>

<?php if (count($this->communities) <> 0 || count($this->users) <> 0) { ?>
<div id="block">
    <?php if (count($this->communities) <> 0) { ?>
        <h2>Comunidades</h2>
        <?php foreach ($this->communities as $community) { ?>
            <div class="box">
                <div class="title">
                    <?php if ($this->acl('communities', 'view')) { ?>
                        <a href="<?= $this->url(array('community' => $community->url), 'communities_community_view') ?>"><?= $community->label ?></a>
                    <?php } else { ?>
                        <?= $community->label ?>
                    <?php } ?>
                </div>
                <div class="photo">
                    <?php if ($this->acl('communities', 'view')) { ?>
                        <a href="<?= $this->url(array('community' => $community->url), 'communities_community_view') ?>"><img src="<?= $this->CONFIG->wwwroot . 'media/communities/thumbnail_medium/' . $community->getAvatar() ?>" alt="<?= $community->label ?>" title="<?= $community->label ?>" /></a>
                    <?php } else { ?>
                        <img src="<?= $this->CONFIG->wwwroot . 'media/communities/thumbnail_medium/' . $community->getAvatar() ?>" alt="<?= $community->label ?>" title="<?= $community->label ?>" />
                    <?php } ?>
                </div>
                <div class="tools">
                    <?php if ($community->amAuthor()) { ?>
                        <a href="<?= $this->url(array('community' => $community->url), 'communities_community_edit') ?>"><img src="<?= $this->TEMPLATE->htmlbase . 'images/pencil.png' ?>" alt="Editar" title="Editar" /></a>
                    <?php } ?>
                    <?php if ($this->acl('communities', 'enter')) { ?>
                        <?php if (!$community->amModerator() && !$community->amMember()) { ?>
                            <a href="<?= $this->url(array('community' => $community->url), 'communities_community_join') ?>"><img src="<?= $this->TEMPLATE->htmlbase . 'images/group_add.png' ?>" alt="Unirse" title="Unirse" /></a>
                        <?php } else if (!$community->amAuthor()) { ?>
                            <a href="<?= $this->url(array('community' => $community->url), 'communities_community_leave') ?>"><img src="<?= $this->TEMPLATE->htmlbase . 'images/group_delete.png' ?>" alt="Retirarse" title="Retirarse" /></a>
                        <?php } ?>
                    <?php } ?>
                    <?php if ($community->mode == 'close') { ?>
                        <img src="<?= $this->TEMPLATE->htmlbase . 'images/key.png' ?>" alt="Comunidad privada" title="Comunidad privada" />
                    <?php } ?>
                </div>
                <p><span class="bold">Descripción: </span><?= $community->description ?></p>
                <p><span class="bold">Miembros: </span><?= $community->members ?></p>
                <?php $tags = $community->getTags() ?>
                <?php if (count($tags)) { ?>
                <p>
                    <img src="<?= $this->TEMPLATE->htmlbase . 'images/tag.png' ?>" alt="Etiquetas" title="Etiquetas" />
                    <?php foreach ($tags as $tag) { ?>
                        <a href="<?= $this->url(array('tag' => $tag->url), 'tags_tag_view') ?>"><?= $tag->label ?></a>
                    <?php } ?>
                </p>
                <?php } ?>
            </div>
        <?php } ?>
        <div class="clear"></div>
    <?php } ?>
    <?php if (count($this->users) <> 0) { ?>
        <h2>Usuarios</h2>
        <?php foreach ($this->users as $user) { ?>
            <div class="box">
                <div class="title">
                    <?php if ($this->acl('users', 'view')) { ?>
                        <a href="<?= $this->url(array('user' => $user->url), 'users_user_view') ?>"><?= $user->getFullName() ?></a>
                    <?php } else { ?>
                        <?= $user->getFullName() ?>
                    <?php } ?>
                </div>
                <div class="photo">
                    <?php if ($this->acl('users', 'view')) { ?>
                        <a href="<?= $this->url(array('user' => $user->url), 'users_user_view') ?>"><img src="<?= $this->CONFIG->wwwroot . 'media/users/thumbnail_medium/' . $user->getAvatar() ?>" alt="<?= $user->getFullName() ?>" title="<?= $user->getFullName() ?>" /></a>
                    <?php } else { ?>
                        <img src="<?= $this->CONFIG->wwwroot . 'media/users/thumbnail_medium/' . $user->getAvatar() ?>" alt="<?= $user->getFullName() ?>" title="<?= $user->getFullName() ?>" />
                    <?php } ?>
                </div>
                <div class="tools">
                    <?php if ($this->acl('users', 'edit') && $this->USER->hasFewerPrivileges($user)) { ?>
                        <a href="<?= $this->url(array('user' => $user->url), 'users_user_edit') ?>"><img src="<?= $this->TEMPLATE->htmlbase . 'images/pencil.png' ?>" alt="Editar" title="Editar" /></a>
                    <?php } ?>
                    <?php if ($this->acl('friends', 'contact')) { ?>
                        <?php if ($this->USER->ident != $user->ident) { ?>
                            <?php if ($this->model_friends->hasContact($this->USER->ident, $user->ident)) { ?>
                            <a href="<?= $this->url(array('user' => $user->url), 'friends_delete') ?>"><img src="<?= $this->TEMPLATE->htmlbase . 'images/user_delete.png' ?>" alt="Retirar contacto" title="Retirar contacto" /></a>
                            <?php } else { ?>
                            <a href="<?= $this->url(array('user' => $user->url), 'friends_add') ?>"><img src="<?= $this->TEMPLATE->htmlbase . 'images/user_add.png' ?>" alt="Agregar contacto" title="Agregar contacto" /></a>
                            <?php } ?>
                        <?php } ?>
                    <?php } ?>
                </div>
                <p>
                    <?= $this->partial($this->template('valorations', 'valoration'), array('type' => 'activity', 'value' => $user->activity, 'TEMPLATE' => $this->TEMPLATE)) ?>
                    <?= $this->partial($this->template('valorations', 'valoration'), array('type' => 'participation', 'value' => $user->participation, 'TEMPLATE' => $this->TEMPLATE)) ?>
                    <?= $this->partial($this->template('valorations', 'valoration'), array('type' => 'sociability', 'value' => $user->sociability, 'TEMPLATE' => $this->TEMPLATE)) ?>
                    <?= $this->partial($this->template('valorations', 'valoration'), array('type' => 'popularity', 'value' => $user->popularity, 'TEMPLATE' => $this->TEMPLATE)) ?>
                </p>
                <p><span class="bold">Cargo: </span><?= $user->getRole()->label ?></p>
                <p><span class="bold">Carrera: </span><?= $this->none($user->getCareer()->label) ?></p>
                <?php $tags = $user->getTags() ?>
                <?php if (count($tags)) { ?>
                <p>
                    <img src="<?= $this->TEMPLATE->htmlbase . 'images/tag.png' ?>" alt="Etiquetas" title="Etiquetas" />
                    <?php foreach ($tags as $tag) { ?>
                        <a href="<?= $this->url(array('tag' => $tag->url), 'tags_tag_view') ?>"><?= $tag->label ?></a>
                    <?php } ?>
                </p>
                <?php } ?>
            </div>
        <?php } ?>
        <div class="clear"></div>
    <?php } ?>
</div>
<?php } ?>

<?= $this->partial($this->template('resources', 'resource'), array('resources' => $this->resources, 'route' => $this->route, 'CONFIG' => $this->CONFIG, 'TEMPLATE' => $this->TEMPLATE, )) ?>
