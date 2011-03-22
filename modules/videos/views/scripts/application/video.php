<?php

list($w, $h) = @split(':', $this->video->proportion);
$proportion = $w / $h;

echo '<b>' . strtoupper($this->video->getLabel()) . '</b>';
echo '<br />';
echo $this->specialEscape($this->escape($this->video->description));
echo '<br />';

echo '<center>';
echo '<object class="playerpreview" type="application/x-shockwave-flash" ';
echo 'data="' . $this->CONFIG->wwwroot . 'media/videos/flvplayer.swf" width="600" height="' . intval(600 / $proportion) . '">';
echo '<param name="movie" value="' . $this->CONFIG->wwwroot . 'media/videos/flvplayer.swf" />';
echo '<param name="allowFullScreen" value="true" />';
echo '<param name="FlashVars" value="flv=' . $this->CONFIG->wwwroot . 'media/videos/' . $this->video->resource;
echo '&showstop=1&showvolume=1&showtime=1&showfullscreen=1&buffermessage=Cargando...' . '" />';
echo '</object>';
echo '</center>';
