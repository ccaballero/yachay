<?php

echo '<b>' . strtoupper($this->entry->getLabel()) . '</b>';
echo '<br />';
echo str_replace("\n", "<br/>", $this->escape($this->entry->description));
