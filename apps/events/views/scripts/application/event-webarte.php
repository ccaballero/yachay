<p><?php echo $this->event->label ?></p>

<?php if (!empty($this->event->message)) { ?>
    <p><?php echo $this->specialEscape($this->escape($this->event->message)) ?></p>
<?php } ?>

<p>
<?php if ($this->event->duration == 0) { ?>
    A partir del: <?php echo $this->timestamp($this->event->event) ?>
<?php } else { ?>
    Del: <?php echo $this->timestamp($this->event->event) ?> al <?php echo $this->timestamp($this->event->event + $this->event->duration) ?>
<?php } ?>
</p>