<h1><?php echo $this->PAGE->label ?></h1>

    <div>
<?php if ($this->acl('resources', 'new')) { ?><input type="button" name="new" value="Crear nueva sugerencia" onclick="location.href='<?php echo $this->url(array(), 'feedback_new') ?>'" /><?php } ?>
    </div>

<?php echo $this->partial($this->template('resources', 'resource'), array('resources' => $this->resources, 'route' => $this->route, 'config' => $this->config, 'TEMPLATE' => $this->TEMPLATE, 'paginator' => false,)) ?>

    <div>
<?php if ($this->acl('resources', 'new')) { ?><input type="button" name="new" value="Crear nueva sugerencia" onclick="location.href='<?php echo $this->url(array(), 'feedback_new') ?>'" /><?php } ?>
    </div>
