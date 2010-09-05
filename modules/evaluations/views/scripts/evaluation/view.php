<?php global $USER; ?>
<h1>Evaluaci&oacute;n: <?= $this->utf2html($this->evaluation->label) ?>
    <?php if ($this->evaluation->author == $USER->ident && count($this->groups) == 0) { ?>
    [<i><a href="<?= $this->url(array('evaluation' => $this->evaluation->ident), 'evaluations_evaluation_edit') ?>">Editar</a></i>]
    <?php } ?>
</h1>

<b>Creada por: <i><?= $this->utf2html($this->evaluation->getAuthor()->getFullName()) ?></i></b>
<br />
<b>Accesibilidad: <i><?= $this->access($this->evaluation->access) ?></i></b>
<br />
<b>Usable: <i><?= $this->boolean($this->evaluation->useful) ?></i></b>
<br />

<p><?= $this->utf2html($this->evaluation->description) ?></p>

<h2>Calificaciones previstas
<?php if ($this->evaluation->author == $USER->ident && count($this->groups) == 0) { ?>
	[<i><a href="<?= $this->url(array('evaluation' => $this->evaluation->ident), 'evaluations_evaluation_test_add') ?>">Agregar</a></i>]
<?php } ?>
</h2>
<?php if (count($this->tests)) { ?>
<dl>
<?php foreach ($this->tests as $test) { ?>
    <dt>
        <b>[<?= $test->key ?>]&nbsp;<a href="<?= $this->url(array('evaluation' => $this->evaluation->ident, 'test' => $test->ident), 'evaluations_evaluation_test_config') ?>"><?= $this->utf2html($test->label) ?></a></b>
        <?php if ($test->formula) { ?>
        	: <?= $test->formula ?>
        <?php } ?>
        <?php if ($this->evaluation->author == $USER->ident && count($this->groups) == 0) { ?>
        	[<i><a href="<?= $this->url(array('evaluation' => $this->evaluation->ident, 'test' => $test->ident), 'evaluations_evaluation_test_delete') ?>">Eliminar</a></i>]
        <?php } ?>
    </dt>
    <dd>
    	<b>Nota minima: </b><?= $test->minimumnote ?><br />
    	<b>Nota por omision: </b><?= $test->defaultnote ?><br />
    	<b>Nota maxima: </b><?= $test->maximumnote ?><br />
    </dd>
<?php } ?>
</dl>
<?php } else { ?>
<p>No se registraron calificaciones previstas.</p>
<?php } ?>

<h2>Grupos en los que ha sido implementado</h2>
<?php if (count($this->groups)) { ?>
<ul>
<?php foreach ($this->groups as $group) { ?>
	<li>
		<?php 
		    $subject = $group->getSubject();
		    $gestion = $subject->getGestion();
		?>
	    <?= "[{$this->utf2html($gestion->label)}] {$this->utf2html($subject->label)} <b>Grupo {$group->label}</b>"?>
	</li>
<?php } ?>
</ul>
<?php } else { ?>
<p>No se ha implementado en ningun grupo a&uacute;n.</p>
<?php } ?>