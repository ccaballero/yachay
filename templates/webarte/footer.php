<ul class="menu">
    <?php foreach ($this->FOOTER->items as $item) { ?>
    <li><a href="<?= $item['link'] ?>"><?= $item['label'] ?></a></li>
    <?php } ?>
</ul>

<ul class="menu">
    <li><a href="<?= $this->url(array(), 'frontpage_licence') ?>">Licencia</a></li>
    <li><a href="<?= $this->url(array(), 'frontpage_terms') ?>">Terminos</a></li>
    <li><a href="<?= $this->url(array(), 'frontpage_privacy') ?>">Privacidad</a></li>
    <li>|&nbsp;<span><?= $this->FOOTER->copyright ?></span></li>
</ul>
