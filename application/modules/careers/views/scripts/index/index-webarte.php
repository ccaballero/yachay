<h1><?php echo $this->PAGE->label ?></h1>
<?php if (count($this->careers)) { ?>
    <dl>
    <?php foreach ($this->careers as $career) { ?>
        <dt>
            <?php if ($this->acl('careers', 'view')) { ?>
                <a href="<?php echo $this->url(array('career' => $career->url), 'careers_career_view') ?>"><?php echo $career->label ?></a>
            <?php } else { ?>
                <?php echo $career->label ?>
            <?php } ?>
            <?php if ($this->acl('careers', 'edit')) { ?>
                <a href="<?php echo $this->url(array('career' => $career->url), 'careers_career_edit') ?>"><img src="<?php echo $this->TEMPLATE->htmlbase . 'images/pencil.png' ?>" alt="Editar" title="Editar" /></a>
            <?php } ?>
        </dt>
        <dd><p><?php echo $career->description ?></p></dd>
    <?php } ?>
    </dl>
<?php } else { ?>
    <p>No existen carreras registradas</p>
<?php } ?>
