<h1><?= $this->PAGE->label ?></h1>

<?php if (!empty($this->gestion)) { ?>
    <p><span class="mark">Gestion:</span>
        <?= $this->gestion->label ?>
    </p>
<?php } ?>

<?php if (count($this->subjects)) { ?>
    <dl>
    <?php foreach ($this->subjects as $subject) { ?>
        <dt>
        <?php if ($this->acl('subjects', 'view')) { ?>
            <a href="<?= $this->url(array('subject' => $subject->url), 'subjects_subject_view') ?>"><?= $subject->label ?></a>
        <?php } else { ?>
            <?= $subject->label ?>
        <?php } ?>
        <?php if ($this->acl('subjects', 'edit')) { ?>
            <a href="<?= $this->url(array('subject' => $subject->url), 'subjects_subject_edit') ?>"><img src="<?= $this->TEMPLATE->htmlbase . 'images/pencil.png' ?>" alt="Editar" title="Editar" /></a>
        <?php } ?>
        </dt>
        <dd>
            <?= $subject->description ?>
            <ul>
                <?php foreach ($this->groups[$subject->ident] as $group) { ?>
                <li>
                    <a href="<?= $this->url(array('subject' => $subject->url, 'group' => $group->url), 'groups_group_view') ?>">Grupo <?= $group->label ?></a>
                    <?php
                    global $USER;
                    $assign = $this->model_groups_users->findByGroupAndUser($group->ident, $USER->ident); ?>
                    <?php if (!empty($assign)) { ?>
                        <span class="mark"><?= $this->typeAssign($assign->type) ?></span>
                    <?php } else { ?>
                        <span class="mark"><?= $this->typeAssign('teacher') ?></span>
                    <?php } ?>
                </li>
                <?php } ?>
            </ul>
        </dd>
    <?php } ?>
    </dl>
<?php } else { ?>
    <p>No existen asignaciones suyas en ninguna materia.</p>
<?php } ?>
