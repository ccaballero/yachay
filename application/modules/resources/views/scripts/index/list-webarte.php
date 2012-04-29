<h1><?php echo $this->PAGE->label ?></h1>

    <div class="tabs top">
        <a class="<?php echo $this->active == 'all' ? 'active' : 'inactive' ?>" href="<?php echo $this->url(array(), 'resources_list') ?>">Todos</a>
        <a class="<?php echo $this->active == 'notes' ? 'active' : 'inactive' ?>" href="<?php echo $this->url(array('filter' => 'notes'), 'resources_filtered') ?>">Notas</a>
        <a class="<?php echo $this->active == 'links' ? 'active' : 'inactive' ?>" href="<?php echo $this->url(array('filter' => 'links'), 'resources_filtered') ?>">Enlaces</a>
        <a class="<?php echo $this->active == 'files' ? 'active' : 'inactive' ?>" href="<?php echo $this->url(array('filter' => 'files'), 'resources_filtered') ?>">Archivos</a>
        <a class="<?php echo $this->active == 'events' ? 'active' : 'inactive' ?>" href="<?php echo $this->url(array('filter' => 'events'), 'resources_filtered') ?>">Eventos</a>
        <a class="<?php echo $this->active == 'photos' ? 'active' : 'inactive' ?>" href="<?php echo $this->url(array('filter' => 'photos'), 'resources_filtered') ?>">Fotografias</a>
        <a class="<?php echo $this->active == 'videos' ? 'active' : 'inactive' ?>" href="<?php echo $this->url(array('filter' => 'videos'), 'resources_filtered') ?>">Videos</a>
        <a class="<?php echo $this->active == 'feedback' ? 'active' : 'inactive' ?>" href="<?php echo $this->url(array('filter' => 'feedback'), 'resources_filtered') ?>">Sugerencias</a>
    <?php if ($this->acl('subjects', 'teach')) { ?>
        <a class="<?php echo $this->active == 'evaluations' ? 'active' : 'inactive' ?>" href="<?php echo $this->url(array('filter' => 'evaluations'), 'resources_filtered') ?>">Evaluaciones</a>
    <?php } ?>
    </div>

<?php if (count($this->resources)) { ?>
    <?php echo $this->partial($this->template('resources', 'resource'), array('resources' => $this->resources, 'route' => $this->route, 'config' => $this->config, 'TEMPLATE' => $this->TEMPLATE, 'paginator' => false,)) ?>
<?php } else { ?>
    <p>No existen recursos registrados</p>
<?php } ?>

    <div class="tabs bottom">
        <a class="<?php echo $this->active == 'all' ? 'active' : 'inactive' ?>" href="<?php echo $this->url(array(), 'resources_list') ?>">Todos</a>
        <a class="<?php echo $this->active == 'notes' ? 'active' : 'inactive' ?>" href="<?php echo $this->url(array('filter' => 'notes'), 'resources_filtered') ?>">Notas</a>
        <a class="<?php echo $this->active == 'links' ? 'active' : 'inactive' ?>" href="<?php echo $this->url(array('filter' => 'links'), 'resources_filtered') ?>">Enlaces</a>
        <a class="<?php echo $this->active == 'files' ? 'active' : 'inactive' ?>" href="<?php echo $this->url(array('filter' => 'files'), 'resources_filtered') ?>">Archivos</a>
        <a class="<?php echo $this->active == 'events' ? 'active' : 'inactive' ?>" href="<?php echo $this->url(array('filter' => 'events'), 'resources_filtered') ?>">Eventos</a>
        <a class="<?php echo $this->active == 'photos' ? 'active' : 'inactive' ?>" href="<?php echo $this->url(array('filter' => 'photos'), 'resources_filtered') ?>">Fotografias</a>
        <a class="<?php echo $this->active == 'videos' ? 'active' : 'inactive' ?>" href="<?php echo $this->url(array('filter' => 'videos'), 'resources_filtered') ?>">Videos</a>
        <a class="<?php echo $this->active == 'feedback' ? 'active' : 'inactive' ?>" href="<?php echo $this->url(array('filter' => 'feedback'), 'resources_filtered') ?>">Sugerencias</a>
    <?php if ($this->acl('subjects', 'teach')) { ?>
        <a class="<?php echo $this->active == 'evaluations' ? 'active' : 'inactive' ?>" href="<?php echo $this->url(array('filter' => 'evaluations'), 'resources_filtered') ?>">Evaluaciones</a>
    <?php } ?>
    </div>
