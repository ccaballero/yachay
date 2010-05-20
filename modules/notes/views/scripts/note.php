<?php if ($this->note->priority) { ?>
	<b>AVISO:</b>
<?php } else {?>
	<b>NOTA:</b>
<?php } ?>
<br />
<?= $this->utf2html($this->wrapper($this->note->note)) ?>