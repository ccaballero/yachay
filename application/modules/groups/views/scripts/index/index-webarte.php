<h1><?php echo $this->PAGE->label ?></h1>

<?php if (!empty($this->gestion)) { ?>
    <p><span class="mark">Gestion:</span>
        <?php echo $this->gestion->label ?>
    </p>
<?php } ?>

<?php if (count($this->subjects)) { ?>
    <dl>
    <?php foreach ($this->subjects as $subject) { ?>
        <dt>
        <?php if ($this->acl('subjects', 'view')) { ?>
            <a href="<?php echo $this->url(array('subject' => $subject->url), 'subjects_subject_view') ?>"><?php echo $subject->label ?></a>
        <?php } else { ?>
            <?php echo $subject->label ?>
        <?php } ?>
        <?php if ($this->acl('subjects', 'edit')) { ?>
            <a href="<?php echo $this->url(array('subject' => $subject->url), 'subjects_subject_edit') ?>"><img src="<?php echo $this->TEMPLATE->htmlbase . 'images/pencil.png' ?>" alt="Editar" title="Editar" /></a>
        <?php } ?>
        </dt>
        <dd>
            <?php echo $subject->description ?>
            <ul>
                <?php foreach ($this->groups[$subject->ident] as $group) { ?>
                <li>
                    <a href="<?php echo $this->url(array('subject' => $subject->url, 'group' => $group->url), 'groups_group_view') ?>">Grupo <?php echo $group->label ?></a>
                    <?php $assign = $this->model_groups_users->findByGroupAndUser($group->ident, $this->user->ident); ?>
                    <?php if (!empty($assign)) { ?>
                        <span class="mark"><?php echo $this->typeAssign($assign->type) ?></span>
                    <?php } else { ?>
                        <span class="mark"><?php echo $this->typeAssign('teacher') ?></span>
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
