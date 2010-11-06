<h1><?= $this->PAGE->label ?></h1>
<dl>
<?php foreach ($this->modules as $module) { ?>
    <?php
        $title = $module->label;
        if ($this->acl('modules', 'view')) {
            $title = '<a href="' . $this->url(array('mod' => $module->url), 'modules_module_view') . '">' . $title . '</a>';
        }
    ?>
    <dt><?= $title ?></dt>
    <dd><?= $module->description ?></dd>
<?php } ?>
</dl>
