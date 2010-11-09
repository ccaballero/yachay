<h1>Area: <?= $this->area->label ?>
    <?php if ($this->acl('areas', 'edit')) { ?>
    [<i><a href="<?= $this->url(array('area' => $this->area->url), 'areas_area_edit') ?>">Editar</a></i>]
    <?php } ?>
</h1>

<p><?= $this->area->description ?></p>

<h2>Materias registradas</h2>
<?php if (count($this->subjects)) { ?>
<ul>
<?php foreach ($this->subjects as $subject) { ?>
    <li>
        <b><a href="<?= $this->url(array('subject' => $subject->url), 'subjects_subject_view') ?>"><?= $subject->label ?></a></b>
    </li>
<?php } ?>
</ul>
<?php } else { ?>
<p>No se registraron materias aún.</p>
<?php } ?>

<?= $this->partial($this->template('resources', 'resource'), array('resources' => $this->resources, 'route' => $this->route, 'CONFIG' => $this->CONFIG, 'TEMPLATE' => $this->TEMPLATE, )) ?>
