<?php

list($w, $h) = @split(':', $this->video->proportion);
$proportion = $w / $h;

echo '<b>' . strtoupper($this->video->getLabel()) . '</b>';
echo '<br />';
echo $this->specialEscape($this->escape($this->video->description));
echo '<br />';

echo '<center>';
echo '<object class="playerpreview" type="application/x-shockwave-flash" ';
echo 'data="' . $this->config->resources->frontController->baseUrl . '/media/videos/flvplayer.swf" width="600" height="' . intval(600 / $proportion) . '">';
echo '<param name="movie" value="' . $this->config->resources->frontController->baseUrl . '/media/videos/flvplayer.swf" />';
echo '<param name="allowFullScreen" value="true" />';
echo '<param name="FlashVars" value="flv=' . $this->config->resources->frontController->baseUrl . '/media/videos/' . $this->video->resource;
echo '&showstop=1&showvolume=1&showtime=1&showfullscreen=1&buffermessage=...' . '" />';
echo '</object>';
echo '</center>';
