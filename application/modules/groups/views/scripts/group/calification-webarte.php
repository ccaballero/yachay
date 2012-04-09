<h1>Calificaciones: Grupo <?php echo $this->group->label ?></h1>

<p>
    <span class="mark">Dictada por:</span> <?php echo $this->group->getTeacher()->getFullName() ?><br />
    <span class="mark">Método de evaluación:</span> <?php echo $this->group->getEvaluation()->label ?><br />
    <span class="mark">Materia:</span> <?php echo $this->subject->label ?><br />
    <span class="mark">Gestion:</span> <?php echo $this->subject->getGestion()->label ?>
</p>

<table>
    <tr>
    <?php foreach ($this->test_evaluations as $test) { ?>
        <th><?php echo $test->label ?></th>
    <?php } ?>
    </tr>
    <tr>
    <?php foreach ($this->test_evaluations as $test) { ?>
        <td class="center">
        <?php if ($test->hasValues()) { ?>
            <?php echo $this->testValues(NULL, $this->model->getCalification($this->group->ident, $this->user->ident, $this->evaluation->ident, $test), $test, !empty($test->formula)) ?>
        <?php } else { ?>
            <?php echo $this->califications[$test->ident] ?>
        <?php } ?>
        </td>
    <?php } ?>
    </tr>
</table>
