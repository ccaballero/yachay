<?php if (!empty($this->video->description)) { ?>
    <p><?= $this->specialEscape($this->escape($this->video->description)) ?></p>
<?php } ?>

<?php
    list($w, $h) = @split(':', $this->video->proportion);
    $proportion = $w / $h;
    global $PALETTE;
?>

<object class="playerpreview" type="application/x-shockwave-flash" data="<?= $this->CONFIG->wwwroot ?>media/videos/flvplayer.swf" width="600" height="<?= intval(600 / $proportion) ?>">
    <param name="movie" value="<?= $this->CONFIG->wwwroot ?>media/videos/flvplayer.swf" />
    <param name="allowFullScreen" value="true" />
    <param name="FlashVars" value="flv=<?= $this->CONFIG->wwwroot ?>media/videos/<?= $this->video->resource ?>&showstop=1&showvolume=1&showtime=1&showfullscreen=1&bgcolor1=<?= substr($PALETTE['background_headers2'], 1) ?>&bgcolor2=<?= substr($PALETTE['background_headers'], 1) ?>&playercolor=<?= substr($PALETTE['background_headers'], 1) ?>&buttoncolor=<?= substr($PALETTE['color_headers'], 1) ?>&buttonovercolor=<?= substr($PALETTE['background_headers2'], 1) ?>&slidercolor1=<?= substr($PALETTE['color_headers'], 1) ?>&slidercolor2=<?= substr($PALETTE['color_headers'], 1) ?>&sliderovercolor=<?= substr($PALETTE['background_headers2'], 1) ?>&videobgcolor=<?= substr($PALETTE['background'], 1) ?>&buffermessage=Cargando..." />
</object>
