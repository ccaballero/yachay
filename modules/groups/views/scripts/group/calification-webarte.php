<h1>Calificaciones: Grupo <?= $this->group->label ?></h1>

<p>
    <span class="mark">Dictada por:</span> <?= $this->group->getTeacher()->getFullName() ?><br />
    <span class="mark">Método de evaluación:</span> <?= $this->group->getEvaluation()->label ?><br />
    <span class="mark">Materia:</span> <?= $this->subject->label ?><br />
    <span class="mark">Gestion:</span> <?= $this->subject->getGestion()->label ?>
</p>

<table>
    <tr>
    <?php foreach ($this->test_evaluations as $test) { ?>
        <th><?= $test->label ?></th>
    <?php } ?>
    </tr>
    <tr>
    <?php foreach ($this->test_evaluations as $test) { ?>
        <td class="center">
        <?php if ($test->hasValues()) { ?>
            <?= $this->testValues(NULL, $this->model->getCalification($this->group->ident, $this->user->ident, $this->evaluation->ident, $test), $test, !empty($test->formula)) ?>
        <?php } else { ?>
            <?= $this->califications[$test->ident] ?>
        <?php } ?>
        </td>
    <?php } ?>
    </tr>
</table>
