<h1>Fotografia
<strong class="task">
<?php if ($this->resource->amAuthor()) { ?>
    <a href="<?= $this->url(array('photo' => $this->resource->ident), 'photos_photo_edit') ?>"><img src="<?= $this->TEMPLATE->htmlbase . 'images/pencil.png' ?>" alt="Editar" title="Editar" /></a>
<?php } ?>
<?php if ($this->acl('ratings', 'new')) { ?>
    <a href="<?= $this->url(array('resource' => $this->resource->ident), 'photos_photo_rating_down') ?>"><img src="<?= $this->TEMPLATE->htmlbase . 'images/arrow_down.png' ?>" alt="Valoración negativa" title="Valoración negativa" /></a>
<?php } ?>
    <?= $this->resource->ratings ?> / <?= $this->resource->raters ?>
<?php if ($this->acl('ratings', 'new')) { ?>
    <a href="<?= $this->url(array('resource' => $this->resource->ident), 'photos_photo_rating_up') ?>"><img src="<?= $this->TEMPLATE->htmlbase . 'images/arrow_up.png' ?>" alt="Valoración positiva" title="Valoración positiva" /></a>
<?php } ?>
</strong>
</h1>

<div id="user-resource">
    <div class="photo"><img src="<?= $this->media . 'users/thumbnail_medium/' . $this->resource->getAuthor()->getAvatar() ?>" alt="" title="" /></div>
    <p><span class="bold">Autor: </span>
    <?php if ($this->acl('users', 'view')) { ?>
        <a href="<?= $this->url(array('user' => $this->resource->getAuthor()->url), 'users_user_view') ?>"><?= $this->resource->getAuthor()->getFullName() ?></a>
    <?php } else { ?>
        <?= $this->resource->getAuthor()->getFullName() ?>
    <?php } ?>
    </p>
    <p><span class="bold">Publicado en: </span><?= $this->recipient($this->resource->recipient) ?></p>
    <p><span class="bold">Etiquetas: </span>
    <?php foreach ($this->tags as $tag) { ?>
        <a href="<?= $this->url(array('tag' => $tag->url), 'tags_tag_view') ?>"><?= $tag->label ?></a>&nbsp;
    <?php } ?>
    </p>
    <p><span class="bold">Fecha: </span><?= $this->timestamp($this->resource->tsregister) ?></p>
</div>

<?php if (!empty($this->photo->description)) { ?>
    <p class="message"><?= $this->specialEscape($this->escape($this->photo->description)) ?></p>
<?php } ?>

<p class="center">
    <img src="<?= $this->CONFIG->wwwroot ?>media/photos/<?= $this->photo->resource ?>" alt="" title="" width="680" />
    <?= $this->photo->filename ?>&nbsp;
    <?= $this->size($this->photo->size) ?>
</p>

<?php if ($this->acl('comments', 'view')) { ?>
    <h2>Comentarios</h2>
    <?= $this->partial($this->template('comments', 'comments'), array('resource' => $this->resource, 'route' => 'photos_photo_comment', 'CONFIG' => $this->CONFIG, 'TEMPLATE' => $this->TEMPLATE, )) ?>
    <?php if ($this->acl('comments', 'new')) { ?>
    <?= $this->partial($this->template('comments', 'comment/post'), array('resource' => $this->resource, 'route' => 'photos_photo_comment', 'CONFIG' => $this->CONFIG, 'TEMPLATE' => $this->TEMPLATE, 'USER' => $this->USER)) ?>
    <?php } ?>
<?php } ?>
