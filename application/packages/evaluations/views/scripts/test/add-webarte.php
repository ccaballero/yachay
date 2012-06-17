<h1><?php echo $this->evaluation->label ?>
<strong class="task">
<?php if ($this->evaluation->useful) { ?>
    <img src="<?php echo $this->template->htmlbase . 'images/tick.png' ?>" alt="Evaluación usable" title="Evaluación usable" />
<?php } else { ?>
    <img src="<?php echo $this->template->htmlbase . 'images/cross.png' ?>" alt="Evaluación inconclusa" title="Evaluación inconclusa" />
<?php } ?>
</strong>
</h1>

<p>
    <span class="mark">Creada por:</span> <?php echo $this->evaluation->getAuthor()->getFullName() ?><br />
    <span class="mark">Accesibilidad:</span> <?php echo $this->access($this->evaluation->access) ?><br />
</p>

<h2>Calificaciones previstas
<strong class="task">
<?php if ($this->evaluation->author == $this->user->ident && count($this->groups) == 0) { ?>
    <a href="<?php echo $this->url(array('evaluation' => $this->evaluation->ident), 'evaluations_evaluation_test_add') ?>"><img src="<?php echo $this->template->htmlbase . 'images/add.png' ?>" alt="Agregar" title="Agregar" /></a>
<?php } ?>
</strong>
</h2>

<?php if (count($this->tests_evaluation)) { ?>
    <?php foreach ($this->tests_evaluation as $test) { ?>
        <h3>
            <span class="mark"><?php echo $test->key ?></span>
            <a href="<?php echo $this->url(array('evaluation' => $this->evaluation->ident, 'test' => $test->ident), 'evaluations_evaluation_test_config') ?>"><?php echo $test->label ?></a>
            <strong class="task">
            <?php if ($this->evaluation->author == $this->user->ident && count($this->groups) == 0) { ?>
                <a href="<?php echo $this->url(array('evaluation' => $this->evaluation->ident, 'test' => $test->ident), 'evaluations_evaluation_test_delete') ?>"><img src="<?php echo $this->template->htmlbase . 'images/delete.png' ?>" alt="Eliminar" title="Eliminar" /></a>
            <?php } ?>
            </strong>
        </h3>
        <p>
            <?php if ($test->formula) { ?><span class="bold">Formula de calculo: </span><?php echo $test->formula ?><br /><?php } ?>
            <span class="bold">Nota minima: </span><?php echo $test->minimumnote ?><br />
            <span class="bold">Nota por omision: </span><?php echo $test->defaultnote ?><br />
            <span class="bold">Nota maxima: </span><?php echo $test->maximumnote ?><br />
            <span class="bold">Formula: </span><?php echo $this->none($test->formula) ?><br />
            <span class="bold">Precedencia: </span><?php echo $test->order ?>
        </p>
    <?php } ?>
<?php } else { ?>
    <p>No se registraron calificaciones previstas.</p>
<?php } ?>

<h2>Nueva calificación</h2>

<form method="post" action="" accept-charset="utf-8">
    <input type="hidden" name="return" value="<?php echo $this->lastPage() ?>" />

    <p><label for="evaluation_test_label">Nombre de la calificación (*): </label><input type="text" name="label" size="15" maxlength="64" value="<?php echo $this->test_evaluation->label ?>" /></p>
    <p><label for="evaluation_test_key">Codigo a utilizar (*): </label><input type="text" name="key" size="15" maxlength="4" value="<?php echo $this->test_evaluation->key ?>" /></p>
    <p><label for="evaluation_test_minimum">Nota minima: </label><input type="text" name="minimum" size="15" maxlength="3" value="<?php echo $this->test_evaluation->minimumnote ?>" /></p>
    <p><label for="evaluation_test_default">Nota por omision: </label><input type="text" name="default" size="15" maxlength="3" value="<?php echo $this->test_evaluation->defaultnote?>" /></p>
    <p><label for="evaluation_test_maximum">Nota maxima: </label><input type="text" name="maximum" size="15" maxlength="3" value="<?php echo $this->test_evaluation->maximumnote ?>" /></p>
    <p><label for="evaluation_test_formula">Formula de calculo (**): </label><input type="text" name="formula" size="15" maxlength="512" value="<?php echo $this->test_evaluation->formula ?>" /></p>
    <p><label for="evaluation_test_order">Orden de precedencia: </label><input type="text" name="order" size="15" maxlength="3" value="<?php echo $this->test_evaluation->order ?>" /></p>
    <p>(*) Campos obligatorios.</p>
    <p>(**) Si no se establece, se considera una entrada.</p>
    <p class="submit"><input type="submit" value="Agregar calificación" /><input type="button" value="Volver a la evaluación" onclick="location.href='<?php echo $this->lastPage() ?>'" /></p>
</form>
