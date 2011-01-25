<h1><?= $this->PAGE->label ?></h1>

<?php
if ($this->step == 1) {
    echo $this->partial('manager/import1-webarte.php', array('options' => $this->options));
} else {
    echo $this->partial('manager/import2-webarte.php', array('options' => $this->options, 'type' => $this->type, 'subject' => $this->subject, 'group' => $this->group, 'tests' => $this->tests, 'results' => $this->results, 'TEMPLATE' => $this->TEMPLATE));
}
