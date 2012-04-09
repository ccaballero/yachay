<?php if (!empty($this->link->description)) { ?>
    <p><?php echo $this->specialEscape($this->escape($this->link->description)) ?></p>
<?php } ?>

<p class="center">
    <img src="<?php echo $this->TEMPLATE->htmlbase . 'images/link.png' ?>" alt="" title="" />
    <a target="_BLANK" href="<?php echo $this->link->link ?>"><?php echo $this->link->link ?></a>
</p>
