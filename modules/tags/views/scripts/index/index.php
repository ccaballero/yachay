<h1>Nube de etiquetas</h1>

<?php foreach ($this->tags as $tag) { ?>
    <a href="<?= $this->url(array('tag' => $tag['tag']->url), 'tags_tag_view') ?>"><font size="<?= $tag['scale'] <= 3 ? 1 : $tag['scale'] - 3 ?>"><?= $tag['tag']->label ?></font></a>&nbsp;
<?php } ?>
