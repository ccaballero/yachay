<?php

echo '<b>' . strtoupper($this->event->getLabel()) . '</b>';
echo '<br />';
echo str_replace(" ", "&nbsp;", str_replace("\n", "<br/>", $this->escape($this->event->label)));
echo '<br />';

if ($this->event->duration == 0) {
    echo 'A partir del: ' . $this->timestamp($this->event->event);
} else {
    echo 'Del: ' . $this->timestamp($this->event->event) . ' al ' . $this->timestamp($this->event->event + $this->event->duration);
}
