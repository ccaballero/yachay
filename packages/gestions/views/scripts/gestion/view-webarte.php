<h1>Gestion <?php echo $this->gestion->label ?></h1>

<h2>Materias registradas</h2>
<?php if (count($this->subjects)) { ?>
<ul>
<?php foreach ($this->subjects as $subject) { ?>
    <li>
        <span class="mark"><?php echo $subject->code ?></span>
        <a href="<?php echo $this->url(array('gestion' => $this->gestion->url, 'subject' => $subject->url), 'gestions_gestion_subject') ?>"><?php echo $subject->label ?></a>
    </li>
<?php } ?>
</ul>
<?php } else { ?>
    <p>No se registraron materias aún.</p>
<?php } ?>
