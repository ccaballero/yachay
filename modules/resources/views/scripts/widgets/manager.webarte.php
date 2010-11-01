<?php if (Yeah_Acl::hasPermission('resources', 'new')) { ?>
    <ul>
        <li>
            <a href="<?= $this->url(array('filter' => 'notes'), 'resources_filtered') ?>">Notas</a>
            <a class="align_right text_small" href="<?= $this->url(array(), 'notes_new') ?>">Crear</a>
        </li>
        <li>
            <a href="<?= $this->url(array('filter' => 'files'), 'resources_filtered') ?>">Archivos</a>
            <a class="align_right text_small" href="<?= $this->url(array(), 'files_new') ?>">Crear</a>
        </li>
        <li>
            <a href="<?= $this->url(array('filter' => 'events'), 'resources_filtered') ?>">Eventos</a>
            <a class="align_right text_small" href="<?= $this->url(array(), 'events_new') ?>">Crear</a>
        </li>
        <li>
            <a href="<?= $this->url(array('filter' => 'feedback'), 'resources_filtered') ?>">Sugerencias</a>
            <a class="align_right text_small" href="<?= $this->url(array(), 'feedback_new') ?>">Crear</a>
        </li>
    <?php if (Yeah_Acl::hasPermission('subjects', 'teach')) { ?>
        <li>
            <a href="<?= $this->url(array('filter' => 'evaluations'), 'resources_filtered') ?>">Evaluaciones</a>
            <a class="align_right text_small" href="<?= $this->url(array(), 'evaluations_new') ?>">Crear</a>
        </li>
        <li>
            <a href="<?= $this->url(array(), 'groupsets_manager') ?>">Conjuntos</a>
            <a class="align_right text_small" href="<?= $this->url(array(), 'groupsets_new') ?>">Crear</a>
        </li>
    <?php } ?>
        <li><a href="<?= $this->url(array(), 'resources_list') ?>">Ver todos</a></li>
    </ul>
<?php }?>
