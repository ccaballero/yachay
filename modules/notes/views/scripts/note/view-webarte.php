<h1>
<?php if ($this->note->priority) { ?>Aviso<?php } else { ?>Nota<?php } ?>
<strong class="task">
<?php if ($this->resource->amAuthor()) { ?>
    <a href="<?= $this->url(array('note' => $this->resource->ident), 'notes_note_edit') ?>"><img src="<?= $this->TEMPLATE->htmlbase . 'images/pencil.png' ?>" alt="Editar" title="Editar" /></a>
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

<p class="message"><?= str_replace("\n", "<br/>", $this->escape($this->note->note)) ?></p>

<?php if ($this->acl('comments', 'view')) { ?>
    <h2>Comentarios</h2>
    <?= $this->partial($this->template('comments', 'comments'), array('resource' => $this->resource, 'route' => 'notes_note_comment', 'CONFIG' => $this->CONFIG, 'TEMPLATE' => $this->TEMPLATE, )) ?>
    <?php if ($this->acl('comments', 'new')) { ?>
    <?= $this->partial($this->template('comments', 'comment/post'), array('resource' => $this->resource, 'route' => 'notes_note_comment', 'CONFIG' => $this->CONFIG, 'TEMPLATE' => $this->TEMPLATE, 'USER' => $this->USER)) ?>
    <?php } ?>
<?php } ?>
