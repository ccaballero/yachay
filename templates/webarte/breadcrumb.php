<?php if (count($this->BREADCRUMB) <> 0) { ?>
<div id="breadcrumb">
    <?php foreach($this->BREADCRUMB->items as $item) { ?>
        &raquo;<a href="<?= $item['link'] ?>"><?= $item['label'] ?></a>&nbsp;
    <?php } ?>
</div>
<?php } ?>
