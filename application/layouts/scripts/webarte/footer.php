<ul class="menu">
    <?php foreach ($this->FOOTER->items as $item) { ?>
    <li><a href="<?php echo $item['link'] ?>"><?php echo $item['label'] ?></a></li>
    <?php } ?>
</ul>

<ul class="menu">
    <li><a href="<?php echo $this->url(array(), 'frontpage_development') ?>">&nbsp;</a></li>
    <li><a href="<?php echo $this->url(array(), 'frontpage_terms') ?>">&nbsp;</a></li>
    <li><a href="<?php echo $this->url(array(), 'frontpage_privacy') ?>">&nbsp;</a></li>
</ul>

<span><?php echo $this->FOOTER->copyright ?></span>
