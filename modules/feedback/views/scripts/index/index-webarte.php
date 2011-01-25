<h1><?= $this->PAGE->label ?></h1>

    <div>
<?php if ($this->acl('resources', 'new')) { ?><input type="button" name="new" value="Crear nueva sugerencia" onclick="location.href='<?= $this->url(array(), 'feedback_new') ?>'" /><?php } ?>
    </div>

<?= $this->partial($this->template('resources', 'resource'), array('resources' => $this->resources, 'route' => $this->route, 'CONFIG' => $this->CONFIG, 'TEMPLATE' => $this->TEMPLATE, )) ?>

    <div>
<?php if ($this->acl('resources', 'new')) { ?><input type="button" name="new" value="Crear nueva sugerencia" onclick="location.href='<?= $this->url(array(), 'feedback_new') ?>'" /><?php } ?>
    </div>
