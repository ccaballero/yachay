<h1>Fotografia
<strong class="task">
<?php if ($this->resource->amAuthor()) { ?>
    <a href="<?php echo $this->url(array('photo' => $this->resource->ident), 'photos_photo_edit') ?>"><img src="<?php echo $this->TEMPLATE->htmlbase . 'images/pencil.png' ?>" alt="Editar" title="Editar" /></a>
<?php } ?>
<?php if ($this->acl('ratings', 'new')) { ?>
    <a href="<?php echo $this->url(array('resource' => $this->resource->ident), 'photos_photo_rating_down') ?>"><img src="<?php echo $this->TEMPLATE->htmlbase . 'images/arrow_down.png' ?>" alt="Valoración negativa" title="Valoración negativa" /></a>
<?php } ?>
    <?php echo $this->resource->ratings ?> / <?php echo $this->resource->raters ?>
<?php if ($this->acl('ratings', 'new')) { ?>
    <a href="<?php echo $this->url(array('resource' => $this->resource->ident), 'photos_photo_rating_up') ?>"><img src="<?php echo $this->TEMPLATE->htmlbase . 'images/arrow_up.png' ?>" alt="Valoración positiva" title="Valoración positiva" /></a>
<?php } ?>
</strong>
</h1>

<div id="user-resource">
    <div class="photo"><img src="<?php echo $this->media . 'users/thumbnail_medium/' . $this->resource->getAuthor()->getAvatar() ?>" alt="" title="" /></div>
    <p><span class="bold">Autor: </span>
    <?php if ($this->acl('users', 'view')) { ?>
        <a href="<?php echo $this->url(array('user' => $this->resource->getAuthor()->url), 'users_user_view') ?>"><?php echo $this->resource->getAuthor()->getFullName() ?></a>
    <?php } else { ?>
        <?php echo $this->resource->getAuthor()->getFullName() ?>
    <?php } ?>
    </p>
    <p><span class="bold">Publicado en: </span><?php echo $this->recipient($this->resource->recipient) ?></p>
    <p><span class="bold">Etiquetas: </span>
    <?php foreach ($this->tags as $tag) { ?>
        <a href="<?php echo $this->url(array('tag' => $tag->url), 'tags_tag_view') ?>"><?php echo $tag->label ?></a>&nbsp;
    <?php } ?>
    </p>
    <p><span class="bold">Fecha: </span><?php echo $this->timestamp($this->resource->tsregister) ?></p>
</div>

<?php if (!empty($this->photo->description)) { ?>
    <p class="message"><?php echo $this->specialEscape($this->escape($this->photo->description)) ?></p>
<?php } ?>

<p class="center">
    <img src="<?php echo $this->CONFIG->wwwroot ?>media/photos/<?php echo $this->photo->resource ?>" alt="" title="" width="680" />
    <?php echo $this->photo->filename ?>&nbsp;
    <?php echo $this->size($this->photo->size) ?>
</p>

<?php if ($this->acl('comments', 'view')) { ?>
    <h2>Comentarios</h2>
    <?php echo $this->partial($this->template('comments', 'comments'), array('resource' => $this->resource, 'route' => 'photos_photo_comment', 'CONFIG' => $this->CONFIG, 'TEMPLATE' => $this->TEMPLATE, )) ?>
    <?php if ($this->acl('comments', 'new')) { ?>
    <?php echo $this->partial($this->template('comments', 'comment/post'), array('resource' => $this->resource, 'route' => 'photos_photo_comment', 'CONFIG' => $this->CONFIG, 'TEMPLATE' => $this->TEMPLATE, 'USER' => $this->USER)) ?>
    <?php } ?>
<?php } ?>
