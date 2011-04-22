<?php if (!empty($this->link->description)) { ?>
    <p><?= $this->specialEscape($this->escape($this->link->description)) ?></p>
<?php } ?>

<p class="center">
    <img src="<?= $this->TEMPLATE->htmlbase . 'images/link.png' ?>" alt="" title="" />
    <a href="<?= $this->link->link ?>"><?= $this->link->link ?></a>
</p>
