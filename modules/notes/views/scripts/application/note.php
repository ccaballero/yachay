<?php

echo '<b>' . strtoupper($this->note->getLabel()) . '</b>';
echo '<br />';
echo $this->wrapper($this->note->note);
