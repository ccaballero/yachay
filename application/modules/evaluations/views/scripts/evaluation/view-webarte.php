<h1><?php echo $this->evaluation->label ?>
<strong class="task">
<?php if ($this->evaluation->useful) { ?>
    <img src="<?php echo $this->TEMPLATE->htmlbase . 'images/tick.png' ?>" alt="Evaluación usable" title="Evaluación usable" />
<?php } else { ?>
    <img src="<?php echo $this->TEMPLATE->htmlbase . 'images/cross.png' ?>" alt="Evaluación inconclusa" title="Evaluación inconclusa" />
<?php } ?>
<?php if ($this->evaluation->author == $this->USER->ident) { ?>
    <a href="<?php echo $this->url(array('evaluation' => $this->evaluation->ident), 'evaluations_evaluation_edit') ?>"><img src="<?php echo $this->TEMPLATE->htmlbase . 'images/pencil.png' ?>" alt="Editar" title="Editar" /></a>
<?php } ?>
<a href="<?php echo $this->url(array(), 'evaluations_sandbox') ?>"><img src="<?php echo $this->TEMPLATE->htmlbase . 'images/bug.png' ?>" alt="Test de formulas" title="Test de formulas" /></a>
</strong>
</h1>

<p>
    <span class="mark">Creada por:</span> <?php echo $this->evaluation->getAuthor()->getFullName() ?><br />
    <span class="mark">Accesibilidad:</span> <?php echo $this->access($this->evaluation->access) ?><br />
</p>

<?php if (!empty($this->evaluation->description)) { ?>
    <p class="message"><?php echo $this->evaluation->description ?></p>
<?php } ?>

<h2>Calificaciones previstas
<strong class="task">
<?php if ($this->evaluation->author == $this->USER->ident && count($this->groups) == 0) { ?>
    <a href="<?php echo $this->url(array('evaluation' => $this->evaluation->ident), 'evaluations_evaluation_test_add') ?>"><img src="<?php echo $this->TEMPLATE->htmlbase . 'images/add.png' ?>" alt="Agregar" title="Agregar" /></a>
<?php } ?>
</strong>
</h2>

<?php if (count($this->tests_evaluation)) { ?>
    <?php foreach ($this->tests_evaluation as $test) { ?>
        <h3>
            <span class="mark"><?php echo $test->key ?></span>
            <a href="<?php echo $this->url(array('evaluation' => $this->evaluation->ident, 'test' => $test->ident), 'evaluations_evaluation_test_config') ?>"><?php echo $test->label ?></a>
            <strong class="task">
            <?php if ($this->evaluation->author == $this->USER->ident && count($this->groups) == 0) { ?>
                <a href="<?php echo $this->url(array('evaluation' => $this->evaluation->ident, 'test' => $test->ident), 'evaluations_evaluation_test_delete') ?>"><img src="<?php echo $this->TEMPLATE->htmlbase . 'images/delete.png' ?>" alt="Eliminar" title="Eliminar" /></a>
            <?php } ?>
            </strong>
        </h3>
        <p>
            <?php if ($test->formula) { ?><span class="bold">Formula de calculo: </span><?php echo $test->formula ?><br /><?php } ?>
            <span class="bold">Nota minima: </span><?php echo $test->minimumnote ?><br />
            <span class="bold">Nota por omision: </span><?php echo $test->defaultnote ?><br />
            <span class="bold">Nota maxima: </span><?php echo $test->maximumnote ?>
        </p>
    <?php } ?>
<?php } else { ?>
    <p>No se registraron calificaciones previstas.</p>
<?php } ?>

<h2>Grupos en los que ha sido implementado</h2>

<?php if (count($this->groups)) { ?>
    <?php foreach ($this->groups as $group) { ?>
        <span class="mark"><?php echo "{$group->getSubject()->getGestion()->label}" ?></span> <?php echo "{$group->getSubject()->label} <b>Grupo {$group->label}</b>"?><br />
    <?php } ?>
<?php } else { ?>
    <p>No se ha implementado en ningun grupo aún.</p>
<?php } ?>
