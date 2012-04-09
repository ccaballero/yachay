<?php

echo '<b>' . strtoupper($this->note->getLabel()) . '</b>';
echo '<br />';
echo $this->specialEscape($this->escape($this->note->note));
