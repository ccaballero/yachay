<h1><?php echo $this->user->getFullName() ?>
<strong class="task">
    <?php echo $this->partial($this->template('valorations', 'valoration'), array('type' => 'activity', 'value' => $this->user->activity, 'TEMPLATE' => $this->TEMPLATE)) ?>
    <?php echo $this->partial($this->template('valorations', 'valoration'), array('type' => 'participation', 'value' => $this->user->participation, 'TEMPLATE' => $this->TEMPLATE)) ?>
    <?php echo $this->partial($this->template('valorations', 'valoration'), array('type' => 'sociability', 'value' => $this->user->sociability, 'TEMPLATE' => $this->TEMPLATE)) ?>
    <?php echo $this->partial($this->template('valorations', 'valoration'), array('type' => 'popularity', 'value' => $this->user->popularity, 'TEMPLATE' => $this->TEMPLATE)) ?>
<?php if ($this->acl('users', 'edit') && $this->USER->hasFewerPrivileges($this->user)) { ?>
    <a href="<?php echo $this->url(array('user' => $this->user->url), 'users_user_edit') ?>"><img src="<?php echo $this->TEMPLATE->htmlbase . 'images/pencil.png' ?>" alt="Editar" title="Editar" /></a>
<?php } ?>
<?php if ($this->acl('friends', 'contact')) { ?>
    <?php if ($this->USER->ident != $this->user->ident) { ?>
        <?php if ($this->model_friends->hasContact($this->USER->ident, $this->user->ident)) { ?>
            <a href="<?php echo $this->url(array('user' => $this->user->url), 'friends_delete') ?>"><img src="<?php echo $this->TEMPLATE->htmlbase . 'images/user_delete.png' ?>" alt="Retirar contacto" title="Retirar contacto" /></a>
        <?php } else { ?>
            <a href="<?php echo $this->url(array('user' => $this->user->url), 'friends_add') ?>"><img src="<?php echo $this->TEMPLATE->htmlbase . 'images/user_add.png' ?>" alt="Agregar contacto" title="Agregar contacto" /></a>
        <?php } ?>
    <?php } ?>
<?php } ?>
</strong>
</h1>

<div id="user">
    <div class="photo"><img src="<?php echo $this->media . 'users/thumbnail_large/' . $this->user->getAvatar() ?>" alt="" title="" /></div>
    <p><span class="bold">Nombre Completo: </span><?php echo $this->user->getFullName() ?></p>
    <p><span class="bold">Cargo: </span><?php echo $this->user->getRole()->label ?></p>
    <p><span class="bold">Carrera: </span><?php echo $this->none($this->user->getCareer()->label) ?></p>
    <p><span class="bold">Descripción personal: </span><?php echo $this->none($this->user->description) ?></p>
    <p><span class="bold">Pasatiempos: </span><?php echo $this->none($this->user->hobbies) ?></p>
    <?php $tags = $this->user->getTags() ?>
<?php if (count($tags)) { ?>
    <p>
        <img src="<?php echo $this->TEMPLATE->htmlbase . 'images/tag.png' ?>" alt="Etiquetas" title="Etiquetas" />
    <?php foreach ($tags as $tag) { ?>
        <span class="tag"><a href="<?php echo $this->url(array('tag' => $tag->url), 'tags_tag_view') ?>"><?php echo $tag->label ?></a></span>
    <?php } ?>
    </p>
<?php } ?>
</div>
<?php echo $this->partial($this->template('resources', 'resource'), array('resources' => $this->resources, 'route' => $this->route, 'CONFIG' => $this->CONFIG, 'TEMPLATE' => $this->TEMPLATE, 'paginator' => true,)) ?>
