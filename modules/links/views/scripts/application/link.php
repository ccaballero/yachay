<?php

echo '<b>' . strtoupper($this->link->getLabel()) . '</b>';
echo '<br />';
echo $this->specialEscape($this->escape($this->link->description));
echo '<br />';
echo '<center><a href="' . $this->link->link . '">' . $this->link->link .'</a> ' . '</center>';
