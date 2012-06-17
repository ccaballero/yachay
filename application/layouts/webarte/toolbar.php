<?php $first = TRUE; ?>
<ul class="menu">
<?php foreach ($this->TOOLBAR->items as $item) { ?>
    <?php if ($first) { ?>
    <li class="first"><?php echo $item ?></li>
    <?php $first = FALSE; ?>
    <?php } else { ?>
    <li class="right"><?php echo $item ?></li>
    <?php } ?>
<?php } ?>
</ul>
