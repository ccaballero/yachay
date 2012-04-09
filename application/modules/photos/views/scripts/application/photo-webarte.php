<?php if (!empty($this->photo->description)) { ?>
    <p><?php echo $this->specialEscape($this->escape($this->photo->description)) ?></p>
<?php } ?>

<p class="center">
    <img src="<?php echo $this->CONFIG->wwwroot ?>media/photos/<?php echo $this->photo->resource ?>.thumb" alt="" title="" />
</p>
