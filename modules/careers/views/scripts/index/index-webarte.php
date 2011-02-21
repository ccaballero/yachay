<h1><?= $this->PAGE->label ?></h1>
<?php if (count($this->careers)) { ?>
    <dl>
    <?php foreach ($this->careers as $career) { ?>
        <dt>
            <?php if ($this->acl('careers', 'view')) { ?>
                <a href="<?= $this->url(array('career' => $career->url), 'careers_career_view') ?>"><?= $career->label ?></a>
            <?php } else { ?>
                <?= $career->label ?>
            <?php } ?>
            <?php if ($this->acl('careers', 'edit')) { ?>
                <a href="<?= $this->url(array('career' => $career->url), 'careers_career_edit') ?>"><img src="<?= $this->TEMPLATE->htmlbase . 'images/pencil.png' ?>" alt="Editar" title="Editar" /></a>
            <?php } ?>
        </dt>
        <dd><p><?= $career->description ?></p></dd>
    <?php } ?>
    </dl>
<?php } else { ?>
    <p>No existen carreras registradas</p>
<?php } ?>
