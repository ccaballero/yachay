<h1>Area: <?= $this->utf2html($this->area->label) ?>
    <?php if (Yeah_Acl::hasPermission('areas', 'edit')) { ?>
    <i><a href="<?= $this->url(array('area' => $this->area->url), 'areas_area_edit') ?>">[Editar]</a></i>
    <?php } ?>
</h1>

<p><?= $this->utf2html($this->area->description) ?></p>

<h2>Materias registradas</h2>
<?php if (count($this->subjects)) { ?>
<ul>
<?php foreach ($this->subjects as $subject) { ?>
    <li>
        <b><a href="<?= $this->url(array('subject' => $subject->url), 'subjects_subject_view') ?>"><?= $this->utf2html($subject->label) ?></a></b>
    </li>
<?php } ?>
</ul>
<?php } else { ?>
<p>No se registraron materias a&uacute;n.</p>
<?php } ?>

<?= $this->partial('resource.php', array('resources' => $this->resources, 'route' => $this->route)) ?>
