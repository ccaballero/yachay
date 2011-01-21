<?php

echo '<b>' . strtoupper($this->note->getLabel()) . '</b>';
echo '<br />';
echo str_replace(" ", "&nbsp;", str_replace("\n", "<br/>", $this->escape($this->note->note)));
