<h1><?= $this->PAGE->label ?></h1>

<?php if (count($this->gestions)) { ?>
    <ul>
    <?php foreach ($this->gestions as $gestion) { ?>
        <li>
            <?php if ($this->acl('gestions', 'view')) { ?><a href="<?= $this->url(array('gestion' => $gestion->url), 'gestions_gestion_view') ?>"><?= $gestion->label ?></a><?php } else { ?><?= $gestion->label ?><?php } ?>
        </li>
    <?php } ?>
    </ul>
<?php } else { ?>
    <p>No existen gestiones registradas</p>
<?php } ?>
