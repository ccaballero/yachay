<h1><?php echo $this->community->label ?>
<strong class="task">
<?php if ($this->community->amAuthor()) { ?>
    <a href="<?php echo $this->url(array('community' => $this->community->url), 'communities_community_edit') ?>"><img src="<?php echo $this->TEMPLATE->htmlbase . 'images/pencil.png' ?>" alt="Editar" title="Editar" /></a>
<?php } ?>
<?php if ($this->acl('communities', 'enter')) { ?>
    <?php if (!$this->community->amModerator() && !$this->community->amMember()) { ?>
        <a href="<?php echo $this->url(array('community' => $this->community->url), 'communities_community_join') ?>"><img src="<?php echo $this->TEMPLATE->htmlbase . 'images/group_add.png' ?>" alt="Unirse" title="Unirse" /></a>
    <?php } else if (!$this->community->amAuthor()) { ?>
        <a href="<?php echo $this->url(array('community' => $this->community->url), 'communities_community_leave') ?>"><img src="<?php echo $this->TEMPLATE->htmlbase . 'images/group_delete.png' ?>" alt="Retirarse" title="Retirarse" /></a>
    <?php } ?>
<?php } ?>
<?php if ($this->community->mode == 'close') { ?>
    <img src="<?php echo $this->TEMPLATE->htmlbase . 'images/key.png' ?>" alt="Comunidad privada" title="Comunidad privada" />
<?php } ?>
<?php if ($this->acl('communities', 'enter')) { ?>
    <a href="<?php echo $this->url(array('community' => $this->community->url), 'communities_community_assign') ?>"><img src="<?php echo $this->TEMPLATE->htmlbase . 'images/group_go.png' ?>" alt="Ver miembros" title="Ver miembros" /></a>
<?php } ?>
<?php if ($this->community->amModerator() && $this->community->mode == 'close') { ?>
    <a href="<?php echo $this->url(array('community' => $this->community->url), 'communities_community_petition') ?>"><img src="<?php echo $this->TEMPLATE->htmlbase . 'images/group_key.png' ?>" alt="Ver peticiones" title="Ver peticiones" /></a>
<?php } ?>
</strong>
</h1>

<div id="user">
    <div class="photo"><img src="<?php echo $this->media . 'communities/thumbnail_large/' . $this->community->getAvatar() ?>" alt="" title="" /></div>
    <p><span class="bold">Descripción: </span><?php echo $this->community->description ?></p>
    <p><span class="bold">Modalidad: </span><?php echo $this->mode(NULL, $this->community->mode) ?></p>
    <p><span class="bold">Autor: </span>
    <?php if ($this->acl('users', 'view')) { ?>
        <a href="<?php echo $this->url(array('user' => $this->community->getAuthor()->url), 'users_user_view') ?>"><?php echo $this->community->getAuthor()->getFullName() ?></a>
    <?php } else { ?>
        <?php echo $this->community->getAuthor()->getFullName() ?>
    <?php } ?>
    </p>
    <p><span class="bold">Miembros: </span>
        <?php if ($this->acl('communities', 'enter')) { ?>
            <a href="<?php echo $this->url(array('community' => $this->community->url), 'communities_community_assign') ?>"><?php echo $this->community->members ?></a>
        <?php } else { ?>
            <?php echo $this->community->members ?>
        <?php } ?>
    </p>
<?php if ($this->community->mode == 'close') { ?>
    <p><span class="bold">Peticiones: </span>
        <?php if ($this->community->amModerator()) { ?>
            <a href="<?php echo $this->url(array('community' => $this->community->url), 'communities_community_petition') ?>"><?php echo $this->community->petitions ?></a>
        <?php } else { ?>
            <?php echo $this->community->petitions ?>
        <?php } ?>
    </p>
<?php } ?>
    <?php $tags = $this->community->getTags() ?>
<?php if (count($tags)) { ?>
    <p>
        <img src="<?php echo $this->TEMPLATE->htmlbase . 'images/tag.png' ?>" alt="Etiquetas" title="Etiquetas" />
    <?php foreach ($tags as $tag) { ?>
        <span class="tag"><a href="<?php echo $this->url(array('tag' => $tag->url), 'tags_tag_view') ?>"><?php echo $tag->label ?></a></span>
    <?php } ?>
    </p>
<?php } ?>
</div>
<?php echo $this->partial($this->template('resources', 'resource'), array('resources' => $this->resources, 'route' => $this->route, 'config' => $this->config, 'TEMPLATE' => $this->TEMPLATE, 'paginator' => true,)) ?>
