<h1>Materia: <?= $this->utf2html($this->subject->label) ?>
    <?php if (!$this->historial) { ?>
        <?php if (Yeah_Acl::hasPermission('subjects', 'edit')) { ?>
        [<i><a href="<?= $this->url(array('subject' => $this->subject->url), 'subjects_subject_edit') ?>">Editar</a></i>]
        <?php } ?>
    <?php } ?>
</h1>

<b>Moderada por: <i><?= $this->utf2html($this->subject->getModerator()->getFullName()) ?></i></b>
<br />
<b>Estado: <i><?= $this->status($this->subject->status) ?></i></b>
<br />
<b>Visibilidad: <i><?= $this->visibility(null, $this->subject->visibility) ?></i></b>
<br />

<p><?= $this->subject->description ?></p>

<?php if (!$this->historial) { ?>
    <?php if ($this->subject->amModerator() || $this->subject->amMember()) { ?>
        [<i><a href="<?= $this->url(array('subject' => $this->subject->url), 'subjects_subject_assign') ?>">Ver miembros</a></i>]
    <?php } ?>
<?php } ?>

<h2>Areas involucradas
    <?php if (!$this->historial) { ?>
        <?php if (Yeah_Acl::hasPermission('areas', array('new', 'delete'))) { ?>
        [<i><a href="<?= $this->url(array('subject' => $this->subject->url), 'subjects_subject_edit') ?>">Administrar</a></i>]
        <?php } ?>
    <?php } ?>
</h2>
<?php if (count($this->areas)) { ?>
<ul>
<?php foreach ($this->areas as $area) { ?>
    <li>
        <i><a href="<?= $this->url(array('area' => $area->url), 'areas_area_view') ?>"><?= $this->utf2html($area->label) ?></a></i>
    </li>
<?php } ?>
</ul>
<?php } else { ?>
<p>La materia no se encuentra registrada en ningun area.</p>
<?php } ?>

<?php if (!$this->historial) { ?>
    <h2>Grupos registrados
    <?php if ($this->subject->amModerator()) { ?>
        [<i><a href="<?= $this->url(array('subject' => $this->subject->url), 'groups_manager') ?>">Administrar</a></i>]
    <?php } ?>
    </h2>
    <?php if (count($this->groups)) { ?>
    <ul>
        <?php foreach ($this->groups as $group) { ?>
        <li>
            <i><a href="<?= $this->url(array('subject' => $this->subject->url, 'group' => $group->url), 'groups_group_view') ?>">Grupo <?= $this->utf2html($group->label) ?></a> [<?= $this->utf2html($group->getTeacher()->getFullName()) ?>]</i>
        </li>
        <?php } ?>
    </ul>
    <?php } else { ?>
        <p>La materia no se posee ningun grupo registrado.</p>
    <?php } ?>
<?php } ?>

<?= $this->partial('resource.php', array('resources' => $this->resources, 'route' => $this->route)) ?>
