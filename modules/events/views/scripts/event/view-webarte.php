<h1><?= $this->event->label ?>
<strong class="task">
<?php if ($this->resource->amAuthor()) { ?>
    <a href="<?= $this->url(array('event' => $this->resource->ident), 'events_event_edit') ?>"><img src="<?= $this->TEMPLATE->htmlbase . 'images/pencil.png' ?>" alt="Editar" title="Editar" /></a>
<?php } ?>
<?php if ($this->acl('ratings', 'new')) { ?>
    <a href="<?= $this->url(array('resource' => $this->resource->ident), 'notes_note_rating_down') ?>"><img src="<?= $this->TEMPLATE->htmlbase . 'images/arrow_down.png' ?>" alt="Valoración negativa" title="Valoración negativa" /></a>
<?php } ?>
    <?= $this->resource->ratings ?> / <?= $this->resource->raters ?>
<?php if ($this->acl('ratings', 'new')) { ?>
    <a href="<?= $this->url(array('resource' => $this->resource->ident), 'notes_note_rating_up') ?>"><img src="<?= $this->TEMPLATE->htmlbase . 'images/arrow_up.png' ?>" alt="Valoración positiva" title="Valoración positiva" /></a>
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

<p class="center">
<?php if ($this->event->duration == 0) { ?>
    A partir del: <?= $this->timestamp($this->event->event) ?>
<?php } else { ?>
    Del: <?= $this->timestamp($this->event->event) ?> al <?= $this->timestamp($this->event->event + $this->event->duration) ?>
<?php } ?>
</p>

<?php if (!empty($this->event->message)) { ?>
    <p class="message"><?= $this->specialEscape($this->escape($this->event->message)) ?></p>
<?php } ?>

<?php if ($this->acl('comments', 'view')) { ?>
    <h2>Comentarios</h2>
    <?= $this->partial($this->template('comments', 'comments'), array('resource' => $this->resource, 'route' => 'events_event_comment', 'CONFIG' => $this->CONFIG, 'TEMPLATE' => $this->TEMPLATE, )) ?>
    <?php if ($this->acl('comments', 'new')) { ?>
    <?= $this->partial($this->template('comments', 'comment/post'), array('resource' => $this->resource, 'route' => 'events_event_comment', 'CONFIG' => $this->CONFIG, 'TEMPLATE' => $this->TEMPLATE, 'USER' => $this->USER)) ?>
    <?php } ?>
<?php } ?>
