<h1>Etiqueta: <?php echo $this->tag->label ?></h1>

<?php if (count($this->communities) <> 0 || count($this->users) <> 0) { ?>
<div id="block">
    <?php if (count($this->communities) <> 0) { ?>
        <h2>Comunidades</h2>
        <?php foreach ($this->communities as $community) { ?>
            <div class="box">
                <div class="title">
                    <?php if ($this->acl('communities', 'view')) { ?>
                        <a href="<?php echo $this->url(array('community' => $community->url), 'communities_community_view') ?>"><?php echo $community->label ?></a>
                    <?php } else { ?>
                        <?php echo $community->label ?>
                    <?php } ?>
                </div>
                <div class="photo">
                    <?php if ($this->acl('communities', 'view')) { ?>
                        <a href="<?php echo $this->url(array('community' => $community->url), 'communities_community_view') ?>"><img src="<?php echo $this->CONFIG->wwwroot . 'media/communities/thumbnail_medium/' . $community->getAvatar() ?>" alt="<?php echo $community->label ?>" title="<?php echo $community->label ?>" /></a>
                    <?php } else { ?>
                        <img src="<?php echo $this->CONFIG->wwwroot . 'media/communities/thumbnail_medium/' . $community->getAvatar() ?>" alt="<?php echo $community->label ?>" title="<?php echo $community->label ?>" />
                    <?php } ?>
                </div>
                <div class="tools">
                    <?php if ($community->amAuthor()) { ?>
                        <a href="<?php echo $this->url(array('community' => $community->url), 'communities_community_edit') ?>"><img src="<?php echo $this->TEMPLATE->htmlbase . 'images/pencil.png' ?>" alt="Editar" title="Editar" /></a>
                    <?php } ?>
                    <?php if ($this->acl('communities', 'enter')) { ?>
                        <?php if (!$community->amModerator() && !$community->amMember()) { ?>
                            <a href="<?php echo $this->url(array('community' => $community->url), 'communities_community_join') ?>"><img src="<?php echo $this->TEMPLATE->htmlbase . 'images/group_add.png' ?>" alt="Unirse" title="Unirse" /></a>
                        <?php } else if (!$community->amAuthor()) { ?>
                            <a href="<?php echo $this->url(array('community' => $community->url), 'communities_community_leave') ?>"><img src="<?php echo $this->TEMPLATE->htmlbase . 'images/group_delete.png' ?>" alt="Retirarse" title="Retirarse" /></a>
                        <?php } ?>
                    <?php } ?>
                    <?php if ($community->mode == 'close') { ?>
                        <img src="<?php echo $this->TEMPLATE->htmlbase . 'images/key.png' ?>" alt="Comunidad privada" title="Comunidad privada" />
                    <?php } ?>
                </div>
                <p><span class="bold">Descripción: </span><?php echo $community->description ?></p>
                <p><span class="bold">Miembros: </span><?php echo $community->members ?></p>
                <?php $tags = $community->getTags() ?>
                <?php if (count($tags)) { ?>
                <p>
                    <img src="<?php echo $this->TEMPLATE->htmlbase . 'images/tag.png' ?>" alt="Etiquetas" title="Etiquetas" />
                    <?php foreach ($tags as $tag) { ?>
                        <a href="<?php echo $this->url(array('tag' => $tag->url), 'tags_tag_view') ?>"><?php echo $tag->label ?></a>
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
                        <a href="<?php echo $this->url(array('user' => $user->url), 'users_user_view') ?>"><?php echo $user->getFullName() ?></a>
                    <?php } else { ?>
                        <?php echo $user->getFullName() ?>
                    <?php } ?>
                </div>
                <div class="photo">
                    <?php if ($this->acl('users', 'view')) { ?>
                        <a href="<?php echo $this->url(array('user' => $user->url), 'users_user_view') ?>"><img src="<?php echo $this->CONFIG->wwwroot . 'media/users/thumbnail_medium/' . $user->getAvatar() ?>" alt="<?php echo $user->getFullName() ?>" title="<?php echo $user->getFullName() ?>" /></a>
                    <?php } else { ?>
                        <img src="<?php echo $this->CONFIG->wwwroot . 'media/users/thumbnail_medium/' . $user->getAvatar() ?>" alt="<?php echo $user->getFullName() ?>" title="<?php echo $user->getFullName() ?>" />
                    <?php } ?>
                </div>
                <div class="tools">
                    <?php if ($this->acl('users', 'edit') && $this->USER->hasFewerPrivileges($user)) { ?>
                        <a href="<?php echo $this->url(array('user' => $user->url), 'users_user_edit') ?>"><img src="<?php echo $this->TEMPLATE->htmlbase . 'images/pencil.png' ?>" alt="Editar" title="Editar" /></a>
                    <?php } ?>
                    <?php if ($this->acl('friends', 'contact')) { ?>
                        <?php if ($this->USER->ident != $user->ident) { ?>
                            <?php if ($this->model_friends->hasContact($this->USER->ident, $user->ident)) { ?>
                            <a href="<?php echo $this->url(array('user' => $user->url), 'friends_delete') ?>"><img src="<?php echo $this->TEMPLATE->htmlbase . 'images/user_delete.png' ?>" alt="Retirar contacto" title="Retirar contacto" /></a>
                            <?php } else { ?>
                            <a href="<?php echo $this->url(array('user' => $user->url), 'friends_add') ?>"><img src="<?php echo $this->TEMPLATE->htmlbase . 'images/user_add.png' ?>" alt="Agregar contacto" title="Agregar contacto" /></a>
                            <?php } ?>
                        <?php } ?>
                    <?php } ?>
                </div>
                <p>
                    <?php echo $this->partial($this->template('valorations', 'valoration'), array('type' => 'activity', 'value' => $user->activity, 'TEMPLATE' => $this->TEMPLATE)) ?>
                    <?php echo $this->partial($this->template('valorations', 'valoration'), array('type' => 'participation', 'value' => $user->participation, 'TEMPLATE' => $this->TEMPLATE)) ?>
                    <?php echo $this->partial($this->template('valorations', 'valoration'), array('type' => 'sociability', 'value' => $user->sociability, 'TEMPLATE' => $this->TEMPLATE)) ?>
                    <?php echo $this->partial($this->template('valorations', 'valoration'), array('type' => 'popularity', 'value' => $user->popularity, 'TEMPLATE' => $this->TEMPLATE)) ?>
                </p>
                <p><span class="bold">Cargo: </span><?php echo $user->getRole()->label ?></p>
                <p><span class="bold">Carrera: </span><?php echo $this->none($user->getCareer()->label) ?></p>
                <?php $tags = $user->getTags() ?>
                <?php if (count($tags)) { ?>
                <p>
                    <img src="<?php echo $this->TEMPLATE->htmlbase . 'images/tag.png' ?>" alt="Etiquetas" title="Etiquetas" />
                    <?php foreach ($tags as $tag) { ?>
                        <a href="<?php echo $this->url(array('tag' => $tag->url), 'tags_tag_view') ?>"><?php echo $tag->label ?></a>
                    <?php } ?>
                </p>
                <?php } ?>
            </div>
        <?php } ?>
        <div class="clear"></div>
    <?php } ?>
</div>
<?php } ?>

<?php echo $this->partial($this->template('resources', 'resource'), array('resources' => $this->resources, 'route' => $this->route, 'CONFIG' => $this->CONFIG, 'TEMPLATE' => $this->TEMPLATE, 'paginator' => true,)) ?>
