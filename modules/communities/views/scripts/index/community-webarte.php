<?php $community = $this->community ?>
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
