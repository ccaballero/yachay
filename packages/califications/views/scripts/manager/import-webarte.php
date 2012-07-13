<h1><?php echo $this->page->label ?>: Grupo <?php echo $this->group->label ?></h1>
<p>
    <span class="mark">Dictada por:</span> <?php echo $this->group->getTeacher()->getFullName() ?><br />
    <span class="mark">Método de evaluación:</span> <?php echo $this->group->getEvaluation()->label ?><br />
    <span class="mark">Materia:</span> <?php echo $this->subject->label ?><br />
    <span class="mark">Gestion:</span> <?php echo $this->subject->getGestion()->label ?>
</p>

<?php
if ($this->step == 1) {
    echo $this->partial('manager/import1-webarte.php', array('options' => $this->options));
} else {
    echo $this->partial('manager/import2-webarte.php', array('options' => $this->options, 'type' => $this->type, 'subject' => $this->subject, 'group' => $this->group, 'tests' => $this->tests, 'results' => $this->results, 'template' => $this->template));
}
