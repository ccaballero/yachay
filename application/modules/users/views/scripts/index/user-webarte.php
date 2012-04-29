<?php $user = $this->user ?>        
<div class="box">
    <div class="title">
        <?php if ($this->acl('users', 'view')) { ?>
            <a href="<?php echo $this->url(array('user' => $user->url), 'users_user_view') ?>"><?php echo $user->getFullName() ?></a>
        <?php } else { ?>
            <?php echo $user->getFullName() ?>
        <?php } ?>
    </div>
    <div class="photo">
        <?php if ($this->acl('users', 'view')) { ?>
            <a href="<?php echo $this->url(array('user' => $user->url), 'users_user_view') ?>"><img src="<?php echo $this->config->resources->frontController->baseUrl . '/media/users/thumbnail_medium/' . $user->getAvatar() ?>" alt="<?php echo $user->getFullName() ?>" title="<?php echo $user->getFullName() ?>" /></a>
        <?php } else { ?>
            <img src="<?php echo $this->config->resources->frontController->baseUrl . '/media/users/thumbnail_medium/' . $user->getAvatar() ?>" alt="<?php echo $user->getFullName() ?>" title="<?php echo $user->getFullName() ?>" />
        <?php } ?>
    </div>
    <div class="tools">
        <?php if ($this->acl('users', 'edit') && $this->USER->hasFewerPrivileges($user)) { ?>
            <a href="<?php echo $this->url(array('user' => $user->url), 'users_user_edit') ?>"><img src="<?php echo $this->TEMPLATE->htmlbase . 'images/pencil.png' ?>" alt="Editar" title="Editar" /></a>
        <?php } ?>
        <?php if ($this->acl('friends', 'contact')) { ?>
            <?php if ($this->USER->ident != $user->ident) { ?>
                <?php if ($this->model_friends->hasContact($this->USER->ident, $user->ident)) { ?>
                <a href="<?php echo $this->url(array('user' => $user->url), 'friends_delete') ?>"><img src="<?php echo $this->TEMPLATE->htmlbase . 'images/user_delete.png' ?>" alt="Retirar contacto" title="Retirar contacto" /></a>
                <?php } else { ?>
                <a href="<?php echo $this->url(array('user' => $user->url), 'friends_add') ?>"><img src="<?php echo $this->TEMPLATE->htmlbase . 'images/user_add.png' ?>" alt="Agregar contacto" title="Agregar contacto" /></a>
                <?php } ?>
            <?php } ?>
        <?php } ?>
    </div>
    <p>
        <?php echo $this->partial($this->template('valorations', 'valoration'), array('type' => 'activity', 'value' => $user->activity, 'TEMPLATE' => $this->TEMPLATE)) ?>
        <?php echo $this->partial($this->template('valorations', 'valoration'), array('type' => 'participation', 'value' => $user->participation, 'TEMPLATE' => $this->TEMPLATE)) ?>
        <?php echo $this->partial($this->template('valorations', 'valoration'), array('type' => 'sociability', 'value' => $user->sociability, 'TEMPLATE' => $this->TEMPLATE)) ?>
        <?php echo $this->partial($this->template('valorations', 'valoration'), array('type' => 'popularity', 'value' => $user->popularity, 'TEMPLATE' => $this->TEMPLATE)) ?>
    </p>
    <p><span class="bold">Cargo: </span><?php echo $user->getRole()->label ?></p>
    <p><span class="bold">Carrera: </span><?php echo $this->none($user->getCareer()->label) ?></p>
    <?php $tags = $user->getTags() ?>
    <?php if (count($tags)) { ?>
    <p>
        <img src="<?php echo $this->TEMPLATE->htmlbase . 'images/tag.png' ?>" alt="Etiquetas" title="Etiquetas" />
        <?php foreach ($tags as $tag) { ?>
            <a href="<?php echo $this->url(array('tag' => $tag->url), 'tags_tag_view') ?>"><?php echo $tag->label ?></a>
        <?php } ?>
    </p>
    <?php } ?>
</div>