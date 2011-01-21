<h1><?= $this->PAGE->label ?></h1>

    <div>
<input type="button" name="all" value="Todos" onclick="location.href='<?= $this->url(array(), 'resources_list') ?>'" /><input type="button" name="notes" value="Notas" onclick="location.href='<?= $this->url(array('filter' => 'notes'), 'resources_filtered') ?>'" /><input type="button" name="files" value="Archivos" onclick="location.href='<?= $this->url(array('filter' => 'files'), 'resources_filtered') ?>'" /><input type="button" name="events" value="Eventos" onclick="location.href='<?= $this->url(array('filter' => 'events'), 'resources_filtered') ?>'" /><input type="button" name="feedback" value="Sugerencias" onclick="location.href='<?= $this->url(array('filter' => 'feedback'), 'resources_filtered') ?>'" /><?php if ($this->acl('subjects', 'teach')) { ?><input type="button" name="evaluations" value="Evaluaciones" onclick="location.href='<?= $this->url(array('filter' => 'evaluations'), 'resources_filtered') ?>'" /><?php } ?>
    </div>

<?php if (count($this->resources)) { ?>
    <?= $this->partial($this->template('resources', 'resource'), array('resources' => $this->resources, 'route' => $this->route, 'CONFIG' => $this->CONFIG, 'TEMPLATE' => $this->TEMPLATE, 'paginator' => false,)) ?>
<?php } else { ?>
    <p>No existen recursos registrados</p>
<?php } ?>

    <div>
<input type="button" name="all" value="Todos" onclick="location.href='<?= $this->url(array(), 'resources_list') ?>'" /><input type="button" name="notes" value="Notas" onclick="location.href='<?= $this->url(array('filter' => 'notes'), 'resources_filtered') ?>'" /><input type="button" name="files" value="Archivos" onclick="location.href='<?= $this->url(array('filter' => 'files'), 'resources_filtered') ?>'" /><input type="button" name="events" value="Eventos" onclick="location.href='<?= $this->url(array('filter' => 'events'), 'resources_filtered') ?>'" /><input type="button" name="feedback" value="Sugerencias" onclick="location.href='<?= $this->url(array('filter' => 'feedback'), 'resources_filtered') ?>'" /><?php if ($this->acl('subjects', 'teach')) { ?><input type="button" name="evaluations" value="Evaluaciones" onclick="location.href='<?= $this->url(array('filter' => 'evaluations'), 'resources_filtered') ?>'" /><?php } ?>
    </div>
