<h1><?php echo $this->page->label ?></h1>

    <div>
<?php if ($this->acl('resources', 'new')) { ?><input type="button" name="new" value="Crear nueva sugerencia" onclick="location.href='<?php echo $this->url(array(), 'feedback_new') ?>'" /><?php } ?>
    </div>

<?php echo $this->partial($this->template('resources', 'resource'), array('resources' => $this->resources, 'pager' => $this->pager, 'config' => $this->config, 'template' => $this->template, 'paginator' => false,)) ?>

    <div>
<?php if ($this->acl('resources', 'new')) { ?><input type="button" name="new" value="Crear nueva sugerencia" onclick="location.href='<?php echo $this->url(array(), 'feedback_new') ?>'" /><?php } ?>
    </div>
