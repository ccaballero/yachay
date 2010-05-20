<h1>Gestion: <?= $this->utf2html($this->gestion->label) ?></h1>

<h2>Materias registradas</h2>
<?php if (count($this->subjects)) { ?>
<ul>
<?php foreach ($this->subjects as $subject) { ?>
    <li>
        <b>[<?= $subject->code ?>]<i>&nbsp;<a href="<?= $this->url(array('gestion' => $this->gestion->url, 'subject' => $subject->url), 'gestions_gestion_subject') ?>"><?= $this->utf2html($subject->label) ?></a></i></b>
    </li>
<?php } ?>
</ul>
<?php } else { ?>
<p>No se registraron materias a&uacute;n.</p>
<?php } ?>
