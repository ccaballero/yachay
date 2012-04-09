<h1><?php echo $this->PAGE->label ?></h1>

<?php
if ($this->step == 1) {
    echo $this->partial('manager/import1-webarte.php', array('options' => $this->options));
} else {
    echo $this->partial('manager/import2-webarte.php', array('options' => $this->options, 'type' => $this->type, 'password' => $this->password, 'results' => $this->results, 'TEMPLATE' => $this->TEMPLATE));
}
