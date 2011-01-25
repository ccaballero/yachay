<h1><?= $this->PAGE->label ?></h1>

<?php if (count($this->tags) <> 0) { ?>
    <div id="tagcloud">
    <?php foreach ($this->tags as $tag) { ?>
        <a class="tag tag-<?= $tag['scale']?>" href="<?= $this->url(array('tag' => $tag['tag']->url), 'tags_tag_view') ?>"><?= str_replace(" ", "&nbsp;", $tag['tag']->label) ?></a>
    <?php } ?>
    </div>
<?php } else { ?>
    <p>No se encontraron etiquetas</p>
<?php } ?>
