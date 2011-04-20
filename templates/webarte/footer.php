<ul class="menu">
    <?php foreach ($this->FOOTER->items as $item) { ?>
    <li><a href="<?= $item['link'] ?>"><?= $item['label'] ?></a></li>
    <?php } ?>
</ul>

<ul class="menu">
    <li><a href="<?= $this->url(array(), 'frontpage_development') ?>">&nbsp;</a></li>
    <li><a href="<?= $this->url(array(), 'frontpage_terms') ?>">&nbsp;</a></li>
    <li><a href="<?= $this->url(array(), 'frontpage_privacy') ?>">&nbsp;</a></li>
</ul>

<span><?= $this->FOOTER->copyright ?></span>
