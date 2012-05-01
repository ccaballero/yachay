<h1>Video
<strong class="task">
<?php if ($this->resource->amAuthor()) { ?>
    <a href="<?php echo $this->url(array('video' => $this->resource->ident), 'videos_video_edit') ?>"><img src="<?php echo $this->TEMPLATE->htmlbase . 'images/pencil.png' ?>" alt="Editar" title="Editar" /></a>
<?php } ?>
<?php if ($this->acl('ratings', 'new')) { ?>
    <a href="<?php echo $this->url(array('resource' => $this->resource->ident), 'videos_video_rating_down') ?>"><img src="<?php echo $this->TEMPLATE->htmlbase . 'images/arrow_down.png' ?>" alt="Valoración negativa" title="Valoración negativa" /></a>
<?php } ?>
    <?php echo $this->resource->ratings ?> / <?php echo $this->resource->raters ?>
<?php if ($this->acl('ratings', 'new')) { ?>
    <a href="<?php echo $this->url(array('resource' => $this->resource->ident), 'videos_video_rating_up') ?>"><img src="<?php echo $this->TEMPLATE->htmlbase . 'images/arrow_up.png' ?>" alt="Valoración positiva" title="Valoración positiva" /></a>
<?php } ?>
</strong>
</h1>

<div id="user-resource">
    <div class="photo"><img src="<?php echo $this->config->resources->frontController->baseUrl . '/media/users/thumbnail_medium/' . $this->resource->getAuthor()->getAvatar() ?>" alt="" title="" /></div>
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

<?php
    list($w, $h) = @split(':', $this->video->proportion);
    $proportion = $w / $h;
    global $PALETTE;
?>

<object class="playerpreview" type="application/x-shockwave-flash" data="<?php echo $this->config->resources->frontController->baseUrl ?>/media/videos/flvplayer.swf" width="668" height="<?php echo intval(668 / $proportion) ?>">
    <param name="movie" value="<?php echo $this->config->resources->frontController->baseUrl ?>/media/videos/flvplayer.swf" />
    <param name="allowFullScreen" value="true" />
    <param name="FlashVars" value="flv=<?php echo $this->config->resources->frontController->baseUrl ?>/media/videos/<?php echo $this->video->resource ?>&showstop=1&showvolume=1&showtime=1&showfullscreen=1&bgcolor1=<?php echo substr($PALETTE['background_headers2'], 1) ?>&bgcolor2=<?php echo substr($PALETTE['background_headers'], 1) ?>&playercolor=<?php echo substr($PALETTE['background_headers'], 1) ?>&buttoncolor=<?php echo substr($PALETTE['color_headers'], 1) ?>&buttonovercolor=<?php echo substr($PALETTE['background_headers2'], 1) ?>&slidercolor1=<?php echo substr($PALETTE['color_headers'], 1) ?>&slidercolor2=<?php echo substr($PALETTE['color_headers'], 1) ?>&sliderovercolor=<?php echo substr($PALETTE['background_headers2'], 1) ?>&videobgcolor=000000&buffermessage=..." />
</object>

<?php if (!empty($this->video->description)) { ?>
    <p class="message"><?php echo $this->specialEscape($this->escape($this->video->description)) ?></p>
<?php } ?>

<?php if ($this->acl('comments', 'view')) { ?>
    <h2>Comentarios</h2>
    <?php echo $this->partial($this->template('comments', 'comments'), array('resource' => $this->resource, 'route' => 'videos_video_comment', 'config' => $this->config, 'TEMPLATE' => $this->TEMPLATE, )) ?>
    <?php if ($this->acl('comments', 'new')) { ?>
    <?php echo $this->partial($this->template('comments', 'comment/post'), array('resource' => $this->resource, 'route' => 'videos_video_comment', 'config' => $this->config, 'TEMPLATE' => $this->TEMPLATE, 'USER' => $this->USER)) ?>
    <?php } ?>
<?php } ?>
