<h1>Lista de gestiones</h1>

<ul>
<?php foreach ($this->gestions as $gestion) { ?>
    <li>
        <?php if (Yeah_Acl::hasPermission('gestions', 'view')) { ?>
        <a href="<?= $this->url(array('gestion' => $gestion->url), 'gestions_gestion_view') ?>">
            <b><?= $this->utf2html($gestion->label) ?></b>
        </a>
        <?php } else { ?>
            <b><?= $this->utf2html($gestion->label) ?></b>
        <?php } ?>
    </li>
<?php } ?>
</ul>
