<?php

echo '<b>' . strtoupper($this->photo->getLabel()) . '</b>';
echo '<br />';
echo $this->specialEscape($this->escape($this->photo->description));
echo '<br />';
echo '<center><img src="' . $this->config->resources->frontController->baseUrl . '/media/photos/' . $this->photo->resource . '.thumb' . '" alt="" title="" /></center>';
