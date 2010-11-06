<ul class="menu">
    <?php foreach ($this->FOOTER->items as $item) { ?>
    <li><a href="<?= $item['link'] ?>"><?= $item['label'] ?></a></li>
    <?php } ?>
</ul>
<span><?= $this->FOOTER->copyright ?></span>
