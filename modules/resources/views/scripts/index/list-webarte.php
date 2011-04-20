<h1><?= $this->PAGE->label ?></h1>

    <div class="tabs top">
        <a class="<?= $this->active == 'all' ? 'active' : 'inactive' ?>" href="<?= $this->url(array(), 'resources_list') ?>">Todos</a>
        <a class="<?= $this->active == 'notes' ? 'active' : 'inactive' ?>" href="<?= $this->url(array('filter' => 'notes'), 'resources_filtered') ?>">Notas</a>
        <a class="<?= $this->active == 'links' ? 'active' : 'inactive' ?>" href="<?= $this->url(array('filter' => 'links'), 'resources_filtered') ?>">Enlaces</a>
        <a class="<?= $this->active == 'files' ? 'active' : 'inactive' ?>" href="<?= $this->url(array('filter' => 'files'), 'resources_filtered') ?>">Archivos</a>
        <a class="<?= $this->active == 'events' ? 'active' : 'inactive' ?>" href="<?= $this->url(array('filter' => 'events'), 'resources_filtered') ?>">Eventos</a>
        <a class="<?= $this->active == 'photos' ? 'active' : 'inactive' ?>" href="<?= $this->url(array('filter' => 'photos'), 'resources_filtered') ?>">Fotografias</a>
        <a class="<?= $this->active == 'videos' ? 'active' : 'inactive' ?>" href="<?= $this->url(array('filter' => 'videos'), 'resources_filtered') ?>">Videos</a>
        <a class="<?= $this->active == 'feedback' ? 'active' : 'inactive' ?>" href="<?= $this->url(array('filter' => 'feedback'), 'resources_filtered') ?>">Sugerencias</a>
    <?php if ($this->acl('subjects', 'teach')) { ?>
        <a class="<?= $this->active == 'evaluations' ? 'active' : 'inactive' ?>" href="<?= $this->url(array('filter' => 'evaluations'), 'resources_filtered') ?>">Evaluaciones</a>
    <?php } ?>
    </div>

<?php if (count($this->resources)) { ?>
    <?= $this->partial($this->template('resources', 'resource'), array('resources' => $this->resources, 'route' => $this->route, 'CONFIG' => $this->CONFIG, 'TEMPLATE' => $this->TEMPLATE, 'paginator' => false,)) ?>
<?php } else { ?>
    <p>No existen recursos registrados</p>
<?php } ?>

    <div class="tabs bottom">
        <a class="<?= $this->active == 'all' ? 'active' : 'inactive' ?>" href="<?= $this->url(array(), 'resources_list') ?>">Todos</a>
        <a class="<?= $this->active == 'notes' ? 'active' : 'inactive' ?>" href="<?= $this->url(array('filter' => 'notes'), 'resources_filtered') ?>">Notas</a>
        <a class="<?= $this->active == 'links' ? 'active' : 'inactive' ?>" href="<?= $this->url(array('filter' => 'links'), 'resources_filtered') ?>">Enlaces</a>
        <a class="<?= $this->active == 'files' ? 'active' : 'inactive' ?>" href="<?= $this->url(array('filter' => 'files'), 'resources_filtered') ?>">Archivos</a>
        <a class="<?= $this->active == 'events' ? 'active' : 'inactive' ?>" href="<?= $this->url(array('filter' => 'events'), 'resources_filtered') ?>">Eventos</a>
        <a class="<?= $this->active == 'photos' ? 'active' : 'inactive' ?>" href="<?= $this->url(array('filter' => 'photos'), 'resources_filtered') ?>">Fotografias</a>
        <a class="<?= $this->active == 'videos' ? 'active' : 'inactive' ?>" href="<?= $this->url(array('filter' => 'videos'), 'resources_filtered') ?>">Videos</a>
        <a class="<?= $this->active == 'feedback' ? 'active' : 'inactive' ?>" href="<?= $this->url(array('filter' => 'feedback'), 'resources_filtered') ?>">Sugerencias</a>
    <?php if ($this->acl('subjects', 'teach')) { ?>
        <a class="<?= $this->active == 'evaluations' ? 'active' : 'inactive' ?>" href="<?= $this->url(array('filter' => 'evaluations'), 'resources_filtered') ?>">Evaluaciones</a>
    <?php } ?>
    </div>
