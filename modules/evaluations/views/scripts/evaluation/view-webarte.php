<h1><?= $this->evaluation->label ?>
<strong class="task">
<?php if ($this->evaluation->author == $this->USER->ident && count($this->groups) == 0) { ?>
    <a href="<?= $this->url(array('evaluation' => $this->evaluation->ident), 'evaluations_evaluation_edit') ?>"><img src="<?= $this->TEMPLATE->htmlbase . 'images/pencil.png' ?>" alt="Editar" title="Editar" /></a>
<?php } ?>
</strong>
</h1>

<p>
    <span class="mark">Creada por:</span> <?= $this->evaluation->getAuthor()->getFullName() ?><br />
    <span class="mark">Accesibilidad:</span> <?= $this->access($this->evaluation->access) ?><br />
    <span class="mark">Usable:</span> <?= $this->boolean($this->evaluation->useful) ?><br />
</p>

<p><?= $this->evaluation->description ?></p>

<h2>Calificaciones previstas
<strong class="task">
<?php if ($this->evaluation->author == $this->USER->ident && count($this->groups) == 0) { ?>
    <a href="<?= $this->url(array('evaluation' => $this->evaluation->ident), 'evaluations_evaluation_test_add') ?>"><img src="<?= $this->TEMPLATE->htmlbase . 'images/add.png' ?>" alt="Agregar" title="Agregar" /></a>
<?php } ?>
</strong>
</h2>

<?php if (count($this->tests_evaluation)) { ?>
    <?php foreach ($this->tests_evaluation as $test) { ?>
        <h3>
            <span class="mark"><?= $test->key ?></span>
            <a href="<?= $this->url(array('evaluation' => $this->evaluation->ident, 'test' => $test->ident), 'evaluations_evaluation_test_config') ?>"><?= $test->label ?></a>
            <strong class="task">
            <?php if ($this->evaluation->author == $this->USER->ident && count($this->groups) == 0) { ?>
                <a href="<?= $this->url(array('evaluation' => $this->evaluation->ident, 'test' => $test->ident), 'evaluations_evaluation_test_delete') ?>"><img src="<?= $this->TEMPLATE->htmlbase . 'images/delete.png' ?>" alt="Eliminar" title="Eliminar" /></a>
            <?php } ?>
            </strong>
        </h3>
        <p>
            <?php if ($test->formula) { ?><span class="bold">Formula de calculo: </span><?= $test->formula ?><br /><?php } ?>
            <span class="bold">Nota minima: </span><?= $test->minimumnote ?><br />
            <span class="bold">Nota por omision: </span><?= $test->defaultnote ?><br />
            <span class="bold">Nota maxima: </span><?= $test->maximumnote ?>
        </p>
    <?php } ?>
<?php } else { ?>
    <p>No se registraron calificaciones previstas.</p>
<?php } ?>

<h2>Grupos en los que ha sido implementado</h2>

<?php if (count($this->groups)) { ?>
    <?php foreach ($this->groups as $group) { ?>
        <span class="mark"><?= "{$group->getSubject()->getGestion()->label}" ?></span> <?= "{$group->getSubject()->label} <b>Grupo {$group->label}</b>"?><br />
    <?php } ?>
<?php } else { ?>
    <p>No se ha implementado en ningun grupo aún.</p>
<?php } ?>
