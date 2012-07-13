<ul class="menu">
    <?php foreach ($this->MENUBAR->items as $item) { ?>
    <li class="left"><a href="<?php echo $item['link'] ?>"><?php echo $item['label'] ?></a></li>
    <?php } ?>
</ul>
