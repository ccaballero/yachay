<h1>Importar miembros: Grupo <?php echo $this->group->label ?></h1>
<p>
    <span class="mark">Dictada por:</span> <?php echo $this->group->getTeacher()->getFullName() ?><br />
    <span class="mark">Método de evaluación:</span> <?php echo $this->group->getEvaluation()->label ?><br />
    <span class="mark">Materia:</span> <?php echo $this->subject->label ?><br />
    <span class="mark">Gestion:</span> <?php echo $this->subject->getGestion()->label ?>
</p>

<?php
if ($this->step == 1) {
    echo $this->partial('assign/import1-webarte.php', array());
} else {
    echo $this->partial('assign/import2-webarte.php', array('subject' => $this->subject, 'group' => $this->group, 'include' => $this->include, 'results' => $this->results, 'template' => $this->template));
}
