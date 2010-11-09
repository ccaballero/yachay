<h1><?= $this->PAGE->label ?></h1>

<?php if (!empty($this->gestion)) { ?>
    <p><span class="mark">Gestion:</span>
        <?= $this->gestion->label ?>
    </p>
<?php } ?>

<?php if (count($this->subjects) > 0) { ?>
    <dl>
    <?php foreach ($this->subjects as $subject) { ?>
        <dt>
            <?php if ($this->acl('subjects', 'view')) { ?><a href="<?= $this->url(array('subject' => $subject->url), 'subjects_subject_view') ?>"><?= $subject->label ?></a><?php } else { ?><?= $subject->label ?><?php } ?>
            <?php if ($this->acl('subjects', 'edit')) { ?>
                <a href="<?= $this->url(array('subject' => $subject->url), 'subjects_subject_edit') ?>"><img src="<?= $this->TEMPLATE->htmlbase . 'images/pencil.png' ?>" alt="Editar" title="Editar" /></a>
            <?php } ?>
            <?php if (!empty($this->assign[$subject->url])) { ?><span class="mark"><?= $this->typeAssign($this->assign[$subject->url]) ?></span><?php } ?>
        </dt>
        <dd><p><?= $subject->description ?></p></dd>
    <?php } ?>
    </dl>
<?php } else { ?>
    <p>No existen materias registradas en la gestion.</p>
<?php } ?>
