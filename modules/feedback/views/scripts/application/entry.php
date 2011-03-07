<?php

echo '<b>' . strtoupper($this->entry->getLabel()) . '</b>';
echo '<br />';
echo $this->specialEscape($this->escape($this->entry->description));
