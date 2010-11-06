<?php $first = TRUE; ?>
<ul class="menu">
<?php foreach ($this->TOOLBAR->items as $item) { ?>
    <? if ($first) { ?>
    <li class="first"><?= $item ?></li>
    <?php $first = FALSE; ?>
    <?php } else { ?>
    <li class="right"><?= $item ?></li>
    <?php } ?>
<?php } ?>
</ul>
