<h1><?= $this->PAGE->label ?></h1>

<?php if (count($this->tags) <> 0) { ?>
    <?php foreach ($this->tags as $tag) { ?>
        <a href="<?= $this->url(array('tag' => $tag['tag']->url), 'tags_tag_view') ?>">
            <font size="<?= $tag['scale'] <= 3 ? 1 : $tag['scale'] - 3 ?>"><?= $tag['tag']->label ?></font>
        </a>&nbsp;
    <?php } ?>
<?php } else { ?>
    <p>No se encontraron etiquetas</p>
<?php } ?>
