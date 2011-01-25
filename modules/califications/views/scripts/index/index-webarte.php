<h1>Calificaciones</h1>

<?php if (empty($this->user)) { ?>
    <?php if ($this->error == 'no user') { ?>
        <p>Ingrese su codigo SISS en el formulario</p>
    <?php } else if ($this->error == 'user invalid') { ?>
        <p>El codigo SISS que introdujo no es valido</p>
    <?php } ?>

<?php } else { ?>

<p>
    <span class="mark">Gestion:</span> <?= $this->gestion->label ?><br/>
    <span class="mark">Nombre Completo:</span> <?= $this->user->getFullName() ?>
</p>

    <?php if (count($this->subjects)) { ?>
        <?php foreach ($this->subjects as $subject) { ?>
            <h2>
                <?php if ($this->acl('subjects', 'view')) { ?>
                    <a href="<?= $this->url(array('subject' => $subject->url), 'subjects_subject_view') ?>"><?= $subject->label ?></a>
                <?php } else { ?>
                    <?= $subject->label ?>
                <?php } ?>
                    <strong class="task">
                        <?php if ($this->acl('subjects', 'edit')) { ?>
                            <a href="<?= $this->url(array('subject' => $subject->url), 'subjects_subject_edit') ?>"><img src="<?= $this->TEMPLATE->htmlbase . 'images/pencil.png' ?>" alt="Editar" title="Editar" /></a>
                        <?php } ?>
                    </strong>
            </h2>
            <p><?= $subject->description ?></p>
                <ul>
                    <?php foreach ($this->groups[$subject->ident] as $group) { ?>
                    <li>
                        <a href="<?= $this->url(array('subject' => $subject->url, 'group' => $group->url), 'groups_group_view') ?>">Grupo <?= $group->label ?></a> (<?= $group->getTeacher()->getFullName() ?>)
                        <br />
                        <span class="bold">Metodo de Evaluación: </span><?= $this->evaluations[$group->ident]->label ?>
                        <table>
                            <tr>
                            <?php foreach ($this->test_evaluations[$group->ident] as $test) { ?>
                                <th><?= $test->label ?></th>
                            <?php } ?>
                            </tr>
                            <tr>
                            <?php foreach ($this->test_evaluations[$group->ident] as $test) { ?>
                                <td class="center">
                                <?php if ($test->hasValues()) { ?>
                                    <?= $this->testValues(NULL, $this->model->getCalification($group->ident, $this->user->ident, $this->evaluations[$group->ident]->ident, $test), $test, !empty($test->formula)) ?>
                                <?php } else { ?>
                                    <?= $this->califications[$group->ident][$test->ident] ?>
                                <?php } ?>
                                </td>
                            <?php } ?>
                            </tr>
                        </table>
                    </li>
                    <?php } ?>
                </ul>
        <?php } ?>
    <?php } else { ?>
        <p>No existen asignaciones suyas en ninguna materia.</p>
    <?php } ?>
<?php } ?>
