<h1><?= $this->PAGE->label ?></h1>

<?php
if ($this->step == 1) {
    echo $this->partial('assign/import1-webarte.php', array());
} else {
    echo $this->partial('assign/import2-webarte.php', array('subject' => $this->subject, 'results' => $this->results, 'TEMPLATE' => $this->TEMPLATE));
}
