<h1>Calificaciones</h1>

<?php if (empty($this->user)) { ?>
    <?php if ($this->error == 'no user') { ?>
        <p>Ingrese su codigo SISS en el formulario</p>
    <?php } else if ($this->error == 'user invalid') { ?>
        <p>El codigo SISS que introdujo no es valido</p>
    <?php } ?>

<?php } else { ?>

<p>
    <span class="mark">Gestion:</span> <?php echo $this->gestion->label ?><br/>
    <span class="mark">Nombre Completo:</span> <?php echo $this->user->getFullName() ?>
</p>

    <?php if (count($this->subjects)) { ?>
        <?php foreach ($this->subjects as $subject) { ?>
            <h2>
                <?php if ($this->acl('subjects', 'view')) { ?>
                    <a href="<?php echo $this->url(array('subject' => $subject->url), 'subjects_subject_view') ?>"><?php echo $subject->label ?></a>
                <?php } else { ?>
                    <?php echo $subject->label ?>
                <?php } ?>
                    <strong class="task">
                        <?php if ($this->acl('subjects', 'edit')) { ?>
                            <a href="<?php echo $this->url(array('subject' => $subject->url), 'subjects_subject_edit') ?>"><img src="<?php echo $this->TEMPLATE->htmlbase . 'images/pencil.png' ?>" alt="Editar" title="Editar" /></a>
                        <?php } ?>
                    </strong>
            </h2>
            <p><?php echo $subject->description ?></p>
                <ul>
                    <?php foreach ($this->groups[$subject->ident] as $group) { ?>
                    <li>
                        <a href="<?php echo $this->url(array('subject' => $subject->url, 'group' => $group->url), 'groups_group_view') ?>">Grupo <?php echo $group->label ?></a> (<?php echo $group->getTeacher()->getFullName() ?>)
                        <br />
                        <span class="bold">Metodo de Evaluación: </span><?php echo $this->evaluations[$group->ident]->label ?>
                        <table>
                            <tr>
                            <?php foreach ($this->test_evaluations[$group->ident] as $test) { ?>
                                <th><?php echo $test->label ?></th>
                            <?php } ?>
                            </tr>
                            <tr>
                            <?php foreach ($this->test_evaluations[$group->ident] as $test) { ?>
                                <td class="center">
                                <?php if ($test->hasValues()) { ?>
                                    <?php echo $this->testValues(NULL, $this->model->getCalification($group->ident, $this->user->ident, $this->evaluations[$group->ident]->ident, $test), $test, !empty($test->formula)) ?>
                                <?php } else { ?>
                                    <?php echo $this->califications[$group->ident][$test->ident] ?>
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
