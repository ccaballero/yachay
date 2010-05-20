<h1>Lista de modulos</h1>

<ul>
<?php foreach ($this->modules as $module) { ?>
    <li>
        <?php if (Yeah_Acl::hasPermission('modules', 'view')) { ?>
        <a href="<?= $this->url(array('mod' => $module->url), 'modules_module_view') ?>">
            <b><?= $this->utf2html($module->label) ?></b>
        </a>
        <?php } else { ?>
            <b><?= $this->utf2html($module->label) ?></b>
        <?php } ?>
        <br />
        <i><?= $this->utf2html($module->description) ?></i>
    </li>
<?php } ?>
</ul>
