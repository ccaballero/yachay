<h1>Video
<strong class="task">
<?php if ($this->resource->amAuthor()) { ?>
    <a href="<?= $this->url(array('video' => $this->resource->ident), 'videos_video_edit') ?>"><img src="<?= $this->TEMPLATE->htmlbase . 'images/pencil.png' ?>" alt="Editar" title="Editar" /></a>
<?php } ?>
<?php if ($this->acl('ratings', 'new')) { ?>
    <a href="<?= $this->url(array('resource' => $this->resource->ident), 'videos_video_rating_down') ?>"><img src="<?= $this->TEMPLATE->htmlbase . 'images/arrow_down.png' ?>" alt="Valoración negativa" title="Valoración negativa" /></a>
<?php } ?>
    <?= $this->resource->ratings ?> / <?= $this->resource->raters ?>
<?php if ($this->acl('ratings', 'new')) { ?>
    <a href="<?= $this->url(array('resource' => $this->resource->ident), 'videos_video_rating_up') ?>"><img src="<?= $this->TEMPLATE->htmlbase . 'images/arrow_up.png' ?>" alt="Valoración positiva" title="Valoración positiva" /></a>
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

<?php
    list($w, $h) = @split(':', $this->video->proportion);
    $proportion = $w / $h;
    global $PALETTE;
?>

<object class="playerpreview" type="application/x-shockwave-flash" data="<?= $this->CONFIG->wwwroot ?>media/videos/flvplayer.swf" width="668" height="<?= intval(668 / $proportion) ?>">
    <param name="movie" value="<?= $this->CONFIG->wwwroot ?>media/videos/flvplayer.swf" />
    <param name="allowFullScreen" value="true" />
    <param name="FlashVars" value="flv=<?= $this->CONFIG->wwwroot ?>media/videos/<?= $this->video->resource ?>&showstop=1&showvolume=1&showtime=1&showfullscreen=1&bgcolor1=<?= substr($PALETTE['background_headers2'], 1) ?>&bgcolor2=<?= substr($PALETTE['background_headers'], 1) ?>&playercolor=<?= substr($PALETTE['background_headers'], 1) ?>&buttoncolor=<?= substr($PALETTE['color_headers'], 1) ?>&buttonovercolor=<?= substr($PALETTE['background_headers2'], 1) ?>&slidercolor1=<?= substr($PALETTE['color_headers'], 1) ?>&slidercolor2=<?= substr($PALETTE['color_headers'], 1) ?>&sliderovercolor=<?= substr($PALETTE['background_headers2'], 1) ?>&videobgcolor=<?= substr($PALETTE['background'], 1) ?>&buffermessage=Cargando..." />
</object>

<p class="message"><?= $this->specialEscape($this->escape($this->video->description)) ?></p>

<?php if ($this->acl('comments', 'view')) { ?>
    <h2>Comentarios</h2>
    <?= $this->partial($this->template('comments', 'comments'), array('resource' => $this->resource, 'route' => 'videos_video_comment', 'CONFIG' => $this->CONFIG, 'TEMPLATE' => $this->TEMPLATE, )) ?>
    <?php if ($this->acl('comments', 'new')) { ?>
    <?= $this->partial($this->template('comments', 'comment/post'), array('resource' => $this->resource, 'route' => 'videos_video_comment', 'CONFIG' => $this->CONFIG, 'TEMPLATE' => $this->TEMPLATE, 'USER' => $this->USER)) ?>
    <?php } ?>
<?php } ?>
