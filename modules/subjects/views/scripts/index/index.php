<h1>Lista de materias</h1>
<i><b>Gestion: </b><?= $this->utf2html($this->gestion->label) ?></i>

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
            <a href="<?= $this->url(array('subject' => $subject->url), 'subjects_subject_edit') ?>">
                <b><i>[Editar]</i></b>
            </a>
            <?php } ?>
            <?php 
                global $USER;
                $assign = $this->assignement->findBySubjectAndUser($subject->ident, $USER->ident); ?>
            <?php if (!empty($assign)) { ?>
            	[<?= $this->typeAssign($assign->type) ?>]
            <?php } ?>
            <br />
            <i><?= $this->utf2html($subject->description) ?></i>
        </li>
    <?php } ?>
    </ul>
<?php } else { ?>
<p>No existen materias registradas en la gestion.</p>
<?php } ?>
