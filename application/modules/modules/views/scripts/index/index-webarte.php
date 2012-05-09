<h1><?php echo $this->page->label ?></h1>
<dl>
<?php foreach ($this->modules as $module) { ?>
    <?php
        $title = $module->label;
        if ($this->acl('modules', 'view')) {
            $title = '<a href="' . $this->url(array('mod' => $module->url), 'modules_module_view') . '">' . $title . '</a>';
        }
    ?>
    <dt><?php echo $title ?></dt>
    <dd><?php echo $module->description ?></dd>
<?php } ?>
</dl>
