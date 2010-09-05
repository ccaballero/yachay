<h1>Calificaciones</h1>

<?php if (empty($this->user)) { ?>
    <?php if ($this->error == 'no user') { ?>
        <p>Ingrese su codigo SISS en el formulario</p>
    <?php } else if ($this->error == 'user invalid') { ?>
        <p>El codigo SISS que introdujo no es valido</p>
    <?php } ?>
<?php } else { ?>

<i><b>Nombre Completo: </b><?= $this->utf2html($this->user->getFullName()) ?></i><br />
<i><b>Gestion: </b><?= $this->utf2html($this->gestion->label) ?></i><br />

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
                    <br />
                    <i><b>Metodo de Evaluaci&oacute;n: </b><?= $this->evaluations[$group->ident]->label ?></i>

                    <table width="100%">
                        <tr>
                    <?php foreach ($this->test_evaluations[$group->ident] as $test) { ?>
                            <th><?= $test->label ?></th>
                    <?php } ?>
                        </tr>
                        <tr>
                    <?php foreach ($this->test_evaluations[$group->ident] as $test) { ?>
                            <td>
                                <?= $this->califications[$group->ident][$test->ident] ?>
                            </td>
                    <?php } ?>
                        </tr>
                    </table>
                </li>
                <?php } ?>
            </ul>
        </li>
    <?php } ?>
    </ul>
<?php } else { ?>
<p>No existen asignaciones suyas en ninguna materia.</p>
<?php } ?>

<?php } ?>
