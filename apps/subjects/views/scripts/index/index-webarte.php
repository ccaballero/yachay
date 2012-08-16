<h1><?php echo $this->route->label ?></h1>

<?php if (!empty($this->gestion)) { ?>
    <p><span class="mark">Gestion:</span>
        <?php echo $this->gestion->label ?>
    </p>
<?php } ?>

<?php if (count($this->subjects)) { ?>
    <dl>
    <?php foreach ($this->subjects as $subject) { ?>
        <dt>
            <?php if ($this->acl('subjects', 'view')) { ?><a href="<?php echo $this->url(array('subject' => $subject->url), 'subjects_subject_view') ?>"><?php echo $subject->label ?></a><?php } else { ?><?php echo $subject->label ?><?php } ?>
            <?php if ($this->acl('subjects', 'edit')) { ?>
                <a href="<?php echo $this->url(array('subject' => $subject->url), 'subjects_subject_edit') ?>"><img src="<?php echo $this->template->htmlbase . 'images/pencil.png' ?>" alt="Editar" title="Editar" /></a>
            <?php } ?>
            <?php if (!empty($this->assign[$subject->url])) { ?><span class="mark"><?php echo $this->typeAssign($this->assign[$subject->url]) ?></span><?php } ?>
        </dt>
        <dd><p><?php echo $subject->description ?></p></dd>
    <?php } ?>
    </dl>
<?php } else { ?>
    <p>No existen materias registradas en la gestion.</p>
<?php } ?>
