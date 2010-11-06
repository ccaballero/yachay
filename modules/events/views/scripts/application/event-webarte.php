<p><?= $this->event->label ?></p>

<p>
<?php if ($this->event->duration == 0) { ?>
    A partir del: <?= $this->timestamp($this->event->event) ?>
<?php } else { ?>
    Del: <?= $this->timestamp($this->event->event) ?> al <?= $this->timestamp($this->event->event + $this->event->duration) ?>
<?php } ?>
</p>