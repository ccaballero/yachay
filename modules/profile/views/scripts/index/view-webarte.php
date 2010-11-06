<h1><?= $this->PAGE->label ?>
<strong class="task">
    <?= $this->partial($this->template('valorations', 'valoration'), array('type' => 'activity', 'value' => $this->user->activity, 'TEMPLATE' => $this->TEMPLATE)) ?>
    <?= $this->partial($this->template('valorations', 'valoration'), array('type' => 'participation', 'value' => $this->user->participation, 'TEMPLATE' => $this->TEMPLATE)) ?>
    <?= $this->partial($this->template('valorations', 'valoration'), array('type' => 'sociability', 'value' => $this->user->sociability, 'TEMPLATE' => $this->TEMPLATE)) ?>
    <?= $this->partial($this->template('valorations', 'valoration'), array('type' => 'popularity', 'value' => $this->user->popularity, 'TEMPLATE' => $this->TEMPLATE)) ?>
    <a href="<?= $this->url(array(), 'profile_edit') ?>"><img src="<?= $this->TEMPLATE->htmlbase . 'images/pencil.png' ?>" alt="Editar" title="Editar" /></a>
</strong>
</h1>

<p>En esta pagina usted puede ver sus datos registrados en el sistema, se recomienda que mantenga al dia esta información de manera que pueda sacarle el maximo provecho a este sistema.</p>

<div id="user">
    <div class="photo">
        <span class="bold">Imagen grande:</span><br />
        <img src="<?= $this->media . 'users/thumbnail_large/' . $this->user->getAvatar() ?>" alt="Imagen grande (200x200)" title="Imagen grande (200x200)" /><br />
        <span class="bold">Imagen mediana:</span><br />
        <img src="<?= $this->media . 'users/thumbnail_medium/' . $this->user->getAvatar() ?>" alt="Imagen mediana (100x100)" title="Imagen mediana (100x100)" /><br />
        <span class="bold">Imagen pequeña:</span><br />
        <img src="<?= $this->media . 'users/thumbnail_small/' . $this->user->getAvatar() ?>" alt="Imagen pequeña (50x50)" title="Imagen pequeña (50x50)" />
    </div>
    <p><span class="bold">Usuario: </span><?= $this->user->label ?></p>
    <p><span class="bold">Codigo: </span><?= $this->user->code ?></p>
    <p><span class="bold">Correo electronico: </span><?= $this->user->email ?></p>
    <p><span class="bold">Apellidos: </span><?= $this->user->surname ?></p>
    <p><span class="bold">Nombres: </span><?= $this->user->name ?></p>
    <p><span class="bold">Fecha de nacimiento: </span><?= $this->none($this->user->birthdate) ?></p>
    <p><span class="bold">Cargo: </span><?= $this->user->getRole()->label ?></p>
    <p><span class="bold">Carrera: </span><?= $this->none($this->user->career) ?></p>
    <p><span class="bold">Telefono: </span><?= $this->none($this->user->phone) ?></p>
    <p><span class="bold">Celular: </span><?= $this->none($this->user->cellphone) ?></p>
    <p><span class="bold">Miembro desde: </span><?= $this->timestamp($this->user->tsregister) ?></p>
    <p><span class="bold">Ultimo acceso: </span><?= $this->timestamp($this->user->tslastlogin) ?></p>
    <p><span class="bold">Pasatiempos: </span><?= $this->none($this->user->hobbies) ?></p>
    <p><span class="bold">Descripción personal: </span><?= $this->none($this->user->description) ?></p>
    <p><span class="bold">Firma: </span><?= $this->none($this->user->sign) ?></p>
    <?php $tags = $this->user->getTags() ?>
<?php if (count($tags)) { ?>
    <p>
        <img src="<?= $this->TEMPLATE->htmlbase . 'images/tag.png' ?>" alt="Etiquetas" title="Etiquetas" />
    <?php foreach ($tags as $tag) { ?>
        <span class="mark"><a href="<?= $this->url(array('tag' => $tag->url), 'tags_tag_view') ?>"><?= $tag->label ?></a></span>
    <?php } ?>
    </p>
<?php } ?>
</div>
