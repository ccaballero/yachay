<h1>Lista de grupos</h1>

<?php if (!empty($this->gestion)) { ?>
<i><b>Gestion: </b><?= $this->utf2html($this->gestion->label) ?></i>
<?php } ?>

<?php if (count($this->subjects)) { ?>
    <ul>
    <?php foreach ($this->subjects as $subject) { ?>
        <li>
            <?php if (Yeah_Acl::hasPermission('subjects', 'view')) { ?>
            <a href="<?= $this->url(array('subject' => $subject->url), 'subjects_subject_view') ?>">
                <b><?= $this->utf2html($subject->label) ?></b>
            </a>
            <?php } else { ?>
                <b><?= $this->utf2html($subject->label) ?></b>
            <?php } ?>
            &nbsp;
            <?php if (Yeah_Acl::hasPermission('subjects', 'edit')) { ?>
                <b><i>[<a href="<?= $this->url(array('subject' => $subject->url), 'subjects_subject_edit') ?>">Editar</a>]</i></b>
            <?php } ?>
            <br />
            <i><?= $this->utf2html($subject->description) ?></i>
            <ul>
                <?php foreach ($this->groups[$subject->ident] as $group) { ?>
                <li>
                    <a href="<?= $this->url(array('subject' => $subject->url, 'group' => $group->url), 'groups_group_view') ?>">Grupo <?= $group->label ?></a>
                    <?php 
                    global $USER;
                    $assign = $this->assignement->findByGroupAndUser($group->ident, $USER->ident); ?>
                    <?php if (!empty($assign)) { ?>
                        [<?= $this->typeAssign($assign->type) ?>]
                    <?php } else { ?>
                        [<?= $this->typeAssign('teacher') ?>]
                    <?php } ?>
                </li>
                <?php } ?>
            </ul>
        </li>
    <?php } ?>
    </ul>
<?php } else { ?>
<p>No existen asignaciones suyas en ninguna materia.</p>
<?php } ?>
