<h1><?= $this->PAGE->label ?></h1>

<?php if ($this->acl('resources', 'new')) { ?>
    [<a href="<?= $this->url(array(), 'feedback_new') ?>">Crear nueva sugerencia</a>]
<?php } ?>

<?php if (count($this->feedback)) { ?>
    <ul>
    <?php foreach ($this->feedback as $entry) { ?>
        <li>
            <a href="<?= $this->url(array('entry' => $entry->resource), 'feedback_entry_view') ?>">
                <?= $this->wrapper($entry->description, 20) ?>
            </a>
            &nbsp;
            <?php if ($entry->getResource()->amAuthor()) { ?>
                <b><i>[<a href="<?= $this->url(array('entry' => $entry->resource), 'feedback_entry_edit') ?>">Editar</a>]</i></b>
            <?php } ?>
        </li>
    <?php } ?>
    </ul>
<?php } else { ?>
<p>No existen sugerencias</p>
<?php } ?>
