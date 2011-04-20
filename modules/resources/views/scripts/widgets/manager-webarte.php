<?php if (Yeah_Acl::hasPermission('resources', 'new')) { ?>
    <ul class="list">
        <li>
            <img src="<?= $this->TEMPLATE->htmlbase . 'images/note.png' ?>" alt="" title="" />
            <a href="<?= $this->url(array('filter' => 'notes'), 'resources_filtered') ?>">Notas</a>
            <a class="right small" href="<?= $this->url(array(), 'notes_new') ?>">Crear</a>
        </li>
        <li>
            <img src="<?= $this->TEMPLATE->htmlbase . 'images/link.png' ?>" alt="" title="" />
            <a href="<?= $this->url(array('filter' => 'links'), 'resources_filtered') ?>">Enlaces</a>
            <a class="right small" href="<?= $this->url(array(), 'links_new') ?>">Crear</a>
        </li>
        <li>
            <img src="<?= $this->TEMPLATE->htmlbase . 'images/attach.png' ?>" alt="" title="" />
            <a href="<?= $this->url(array('filter' => 'files'), 'resources_filtered') ?>">Archivos</a>
            <a class="right small" href="<?= $this->url(array(), 'files_new') ?>">Crear</a>
        </li>
        <li>
            <img src="<?= $this->TEMPLATE->htmlbase . 'images/calendar.png' ?>" alt="" title="" />
            <a href="<?= $this->url(array('filter' => 'events'), 'resources_filtered') ?>">Eventos</a>
            <a class="right small" href="<?= $this->url(array(), 'events_new') ?>">Crear</a>
        </li>
        <li>
            <img src="<?= $this->TEMPLATE->htmlbase . 'images/camera.png' ?>" alt="" title="" />
            <a href="<?= $this->url(array('filter' => 'photos'), 'resources_filtered') ?>">Fotografias</a>
            <a class="right small" href="<?= $this->url(array(), 'photos_new') ?>">Crear</a>
        </li>
    <?php if (Yeah_Acl::hasPermission('videos', 'upload')) { ?>
        <li>
            <img src="<?= $this->TEMPLATE->htmlbase . 'images/film.png' ?>" alt="" title="" />
            <a href="<?= $this->url(array('filter' => 'videos'), 'resources_filtered') ?>">Videos</a>
            <a class="right small" href="<?= $this->url(array(), 'videos_new') ?>">Crear</a>
        </li>
    <?php } ?>
        <li>
            <img src="<?= $this->TEMPLATE->htmlbase . 'images/arrow_refresh.png' ?>" alt="" title="" />
            <a href="<?= $this->url(array('filter' => 'feedback'), 'resources_filtered') ?>">Sugerencias</a>
            <a class="right small" href="<?= $this->url(array(), 'feedback_new') ?>">Crear</a>
        </li>
    <?php if (Yeah_Acl::hasPermission('subjects', 'teach')) { ?>
        <li>
            <img src="<?= $this->TEMPLATE->htmlbase . 'images/chart_bar.png' ?>" alt="" title="" />
            <a href="<?= $this->url(array('filter' => 'evaluations'), 'resources_filtered') ?>">Evaluaciones</a>
            <a class="right small" href="<?= $this->url(array(), 'evaluations_new') ?>">Crear</a>
        </li>
        <li>
            <img src="<?= $this->TEMPLATE->htmlbase . 'images/layers.png' ?>" alt="" title="" />
            <a href="<?= $this->url(array(), 'groupsets_manager') ?>">Conjuntos</a>
            <a class="right small" href="<?= $this->url(array(), 'groupsets_new') ?>">Crear</a>
        </li>
    <?php } ?>
        <li>
            <img src="<?= $this->TEMPLATE->htmlbase . 'images/email.png' ?>" alt="" title="" />
            <a href="<?= $this->url(array(), 'invitations_manager') ?>">Invitaciones</a>
            <a class="right small" href="<?= $this->url(array(), 'invitations_new') ?>">Crear</a>
        </li>
        <li class="center top_space">
            <img src="<?= $this->TEMPLATE->htmlbase . 'images/asterisk_yellow.png' ?>" alt="" title="" />
            <a href="<?= $this->url(array(), 'resources_list') ?>">Ver todos</a>
        </li>
    </ul>
<?php }?>
