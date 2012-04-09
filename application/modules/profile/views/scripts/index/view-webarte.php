<h1><?php echo $this->PAGE->label ?>
<strong class="task">
    <?php echo $this->partial($this->template('valorations', 'valoration'), array('type' => 'activity', 'value' => $this->user->activity, 'TEMPLATE' => $this->TEMPLATE)) ?>
    <?php echo $this->partial($this->template('valorations', 'valoration'), array('type' => 'participation', 'value' => $this->user->participation, 'TEMPLATE' => $this->TEMPLATE)) ?>
    <?php echo $this->partial($this->template('valorations', 'valoration'), array('type' => 'sociability', 'value' => $this->user->sociability, 'TEMPLATE' => $this->TEMPLATE)) ?>
    <?php echo $this->partial($this->template('valorations', 'valoration'), array('type' => 'popularity', 'value' => $this->user->popularity, 'TEMPLATE' => $this->TEMPLATE)) ?>
    <a href="<?php echo $this->url(array(), 'profile_edit') ?>"><img src="<?php echo $this->TEMPLATE->htmlbase . 'images/pencil.png' ?>" alt="Editar" title="Editar" /></a>
</strong>
</h1>

<p>En esta pagina usted puede ver sus datos registrados en el sistema, se recomienda que mantenga al dia esta información de manera que pueda sacarle el maximo provecho a este sistema.</p>

<div id="user">
    <div class="photo">
        <span class="bold">Imagen grande:</span><br />
        <img src="<?php echo $this->media . 'users/thumbnail_large/' . $this->user->getAvatar() ?>" alt="Imagen grande (200x200)" title="Imagen grande (200x200)" /><br />
        <span class="bold">Imagen mediana:</span><br />
        <img src="<?php echo $this->media . 'users/thumbnail_medium/' . $this->user->getAvatar() ?>" alt="Imagen mediana (100x100)" title="Imagen mediana (100x100)" /><br />
        <span class="bold">Imagen pequeña:</span><br />
        <img src="<?php echo $this->media . 'users/thumbnail_small/' . $this->user->getAvatar() ?>" alt="Imagen pequeña (50x50)" title="Imagen pequeña (50x50)" />
    </div>
    <p><span class="bold">Usuario: </span><?php echo $this->user->label ?></p>
    <p><span class="bold">Codigo: </span><?php echo $this->user->code ?></p>
    <p><span class="bold">Correo electronico: </span><?php echo $this->user->email ?></p>
    <p><span class="bold">Apellidos: </span><?php echo $this->user->surname ?></p>
    <p><span class="bold">Nombres: </span><?php echo $this->user->name ?></p>
    <p><span class="bold">Fecha de nacimiento: </span><?php echo $this->none($this->user->birthdate) ?></p>
    <p><span class="bold">Cargo: </span><?php echo $this->user->getRole()->label ?></p>
    <p><span class="bold">Carrera: </span><?php echo $this->none($this->user->getCareer()->label) ?></p>
    <p><span class="bold">Telefono: </span><?php echo $this->none($this->user->phone) ?></p>
    <p><span class="bold">Celular: </span><?php echo $this->none($this->user->cellphone) ?></p>
    <p><span class="bold">Miembro desde: </span><?php echo $this->timestamp($this->user->tsregister) ?></p>
    <p><span class="bold">Ultimo acceso: </span><?php echo $this->timestamp($this->user->tslastlogin) ?></p>
    <p><span class="bold">Pasatiempos: </span><?php echo $this->none($this->user->hobbies) ?></p>
    <p><span class="bold">Descripción personal: </span><?php echo $this->none($this->user->description) ?></p>
    <p><span class="bold">Firma: </span><?php echo $this->none($this->user->sign) ?></p>
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
