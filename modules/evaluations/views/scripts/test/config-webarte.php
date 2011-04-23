<h1><?= $this->evaluation->label ?>
<strong class="task">
<?php if ($this->evaluation->useful) { ?>
    <img src="<?= $this->TEMPLATE->htmlbase . 'images/tick.png' ?>" alt="Evaluación usable" title="Evaluación usable" />
<?php } else { ?>
    <img src="<?= $this->TEMPLATE->htmlbase . 'images/cross.png' ?>" alt="Evaluación inconclusa" title="Evaluación inconclusa" />
<?php } ?>
</strong>
</h1>

<p>
    <span class="mark">Creada por:</span> <?= $this->evaluation->getAuthor()->getFullName() ?><br />
    <span class="mark">Accesibilidad:</span> <?= $this->access($this->evaluation->access) ?><br />
</p>

<h2><span class="mark"><?= $this->test_evaluation->key ?></span><?= $this->test_evaluation->label ?></h2>

<p>
    <?php if ($this->test_evaluation->formula) { ?><span class="bold">Formula de calculo: </span><?= $this->test_evaluation->formula ?><br /><?php } ?>
    <span class="bold">Nota minima: </span><?= $this->test_evaluation->minimumnote ?><br />
    <span class="bold">Nota por omision: </span><?= $this->test_evaluation->defaultnote ?><br />
    <span class="bold">Nota maxima: </span><?= $this->test_evaluation->maximumnote ?><br />
    <span class="bold">Formula: </span><?= $this->none($this->test_evaluation->formula) ?><br />
    <span class="bold">Precedencia: </span><?= $this->test_evaluation->order ?>
</p>

<h2>Valores cualitativos</h2>

<?php if (count($this->test_values_evaluation)) { ?>
    <table>
        <tr>
            <th>Valor cualitativo</th>
            <th>Nota que representa</th>
            <th>&nbsp;</th>
        </tr>
    <?php foreach ($this->test_values_evaluation as $key => $value) { ?>
        <tr class="<?= $key % 2 == 0 ? 'even' : 'odd' ?>">
            <td><?= $value->label ?></td>
            <td><?= $value->value ?></td>
            <td class="center">
            <?php if ($this->evaluation->author == $this->USER->ident && count($this->groups) == 0) { ?>
                <a href="<?= $this->url(array('evaluation' => $this->evaluation->ident, 'test' => $this->test_evaluation->ident, 'value' => $value->ident), 'evaluations_evaluation_test_value_delete') ?>"><img src="<?= $this->TEMPLATE->htmlbase . 'images/delete.png' ?>" alt="Eliminar" title="Eliminar" /></a>
            <?php } ?>
            </td>
        </tr>
    <?php } ?>
    </table>
<?php } else { ?>
    <p>No se registraron valores cualitativos.</p>
<?php } ?>

<h2>Crear nuevo valor cualitativo</h2>

<form method="post" action="" accept-charset="utf-8">
    <input type="hidden" name="return" value="<?= $this->lastPage() ?>" />

    <p><label for="evaluation_test_value_label">Valor cualitativo (*): </label><input id="evaluation_test_value_label" name="label" type="text" value="<?= $this->test_value_evaluation->label ?>" size="20" maxlength="64" /></p>
    <p><label for="evaluation_test_value_value">Nota que representa (*): </label><input id="evaluation_test_value_value" name="value" type="text" value="<?= $this->test_value_evaluation->value ?>" size="20" maxlength="3" /></p>
    <p>(*) Campos obligatorios.</p>
    <p class="submit"><input type="submit" value="Agregar valor" /><input type="button" value="Volver a la calificación" onclick="location.href='<?= $this->lastPage() ?>'" /></p>
</form>
