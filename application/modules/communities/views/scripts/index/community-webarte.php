<?php $community = $this->community ?>
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
            <a href="<?php echo $this->url(array('community' => $community->url), 'communities_community_view') ?>"><img src="<?php echo $this->config->resources->frontController->baseUrl . '/media/communities/thumbnail_medium/' . $community->getAvatar() ?>" alt="<?php echo $community->label ?>" title="<?php echo $community->label ?>" /></a>
        <?php } else { ?>
            <img src="<?php echo $this->config->resources->frontController->baseUrl . '/media/communities/thumbnail_medium/' . $community->getAvatar() ?>" alt="<?php echo $community->label ?>" title="<?php echo $community->label ?>" />
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
    <p class="description"><span class="bold">Descripción: </span><?php echo $community->description ?></p>
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
