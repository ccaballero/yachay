<?php if (!empty($this->photo->description)) { ?>
    <p><?= $this->specialEscape($this->escape($this->photo->description)) ?></p>
<?php } ?>

<p class="center">
    <img src="<?= $this->CONFIG->wwwroot ?>media/photos/<?= $this->photo->resource ?>.thumb" alt="" title="" />
</p>
