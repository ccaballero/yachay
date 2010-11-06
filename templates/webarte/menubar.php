<ul class="menu">
    <?php foreach ($this->MENUBAR->items as $item) { ?>
    <li class="left"><a href="<?= $item['link'] ?>"><?= $item['label'] ?></a></li>
    <?php } ?>
</ul>
