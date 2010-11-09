<h1>Gestion <?= $this->gestion->label ?></h1>

<h2>Materias registradas</h2>
<?php if (count($this->subjects)) { ?>
<ul>
<?php foreach ($this->subjects as $subject) { ?>
    <li>
        <span class="mark"><?= $subject->code ?></span>
        <a href="<?= $this->url(array('gestion' => $this->gestion->url, 'subject' => $subject->url), 'gestions_gestion_subject') ?>"><?= $subject->label ?></a>
    </li>
<?php } ?>
</ul>
<?php } else { ?>
    <p>No se registraron materias aún.</p>
<?php } ?>
