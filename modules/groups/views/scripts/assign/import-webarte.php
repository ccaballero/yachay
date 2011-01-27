<h1>Importar miembros: Grupo <?= $this->group->label ?></h1>
<p>
    <span class="mark">Dictada por:</span> <?= $this->group->getTeacher()->getFullName() ?><br />
    <span class="mark">Método de evaluación:</span> <?= $this->group->getEvaluation()->label ?><br />
    <span class="mark">Materia:</span> <?= $this->subject->label ?><br />
    <span class="mark">Gestion:</span> <?= $this->subject->getGestion()->label ?>
</p>

<?php
if ($this->step == 1) {
    echo $this->partial('assign/import1-webarte.php', array());
} else {
    echo $this->partial('assign/import2-webarte.php', array('subject' => $this->subject, 'group' => $this->group, 'include' => $this->include, 'results' => $this->results, 'TEMPLATE' => $this->TEMPLATE));
}
