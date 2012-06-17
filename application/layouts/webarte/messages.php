<?php if (!empty($this->messages)) { ?>
<div id="messages">
    <?php foreach ($this->messages as $message) { ?>
        <span class="message"><?php echo $message ?></span>
    <?php } ?>
</div>
<?php } ?>
