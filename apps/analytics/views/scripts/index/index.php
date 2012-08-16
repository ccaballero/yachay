<h1><?php echo $this->route->label ?></h1>

<div class="tabs top">
    <a class="<?php echo $this->active == 'users'       ? 'active' : 'inactive' ?>" href="<?php echo $this->url(array('page' => 'users'), 'analytics_view') ?>">Usuarios</a>
    <a class="<?php echo $this->active == 'valorations' ? 'active' : 'inactive' ?>" href="<?php echo $this->url(array('page' => 'valorations'), 'analytics_view') ?>">Valoraciones</a>
    <a class="<?php echo $this->active == 'contacts'    ? 'active' : 'inactive' ?>" href="<?php echo $this->url(array('page' => 'contacts'), 'analytics_view') ?>">Contactos</a>
    <a class="<?php echo $this->active == 'spaces'      ? 'active' : 'inactive' ?>" href="<?php echo $this->url(array('page' => 'spaces'), 'analytics_view') ?>">Espacios</a>
    <a class="<?php echo $this->active == 'resources'   ? 'active' : 'inactive' ?>" href="<?php echo $this->url(array('page' => 'resources'), 'analytics_view') ?>">Recursos</a>
    <a class="<?php echo $this->active == 'timeline'    ? 'active' : 'inactive' ?>" href="<?php echo $this->url(array('page' => 'timeline'), 'analytics_view') ?>">Linea de tiempo</a>
</div>
<div id="analytics">
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <?php echo $this->partial('index/_' . $this->active. '.php', array('stat' => $this->stat, 'fg' => $this->fg, 'bg' => $this->bg)) ?>
</div>
<div class="tabs bottom">
    <a class="<?php echo $this->active == 'users'       ? 'active' : 'inactive' ?>" href="<?php echo $this->url(array('page' => 'users'), 'analytics_view') ?>">Usuarios</a>
    <a class="<?php echo $this->active == 'valorations' ? 'active' : 'inactive' ?>" href="<?php echo $this->url(array('page' => 'valorations'), 'analytics_view') ?>">Valoraciones</a>
    <a class="<?php echo $this->active == 'contacts'    ? 'active' : 'inactive' ?>" href="<?php echo $this->url(array('page' => 'contacts'), 'analytics_view') ?>">Contactos</a>
    <a class="<?php echo $this->active == 'spaces'      ? 'active' : 'inactive' ?>" href="<?php echo $this->url(array('page' => 'spaces'), 'analytics_view') ?>">Espacios</a>
    <a class="<?php echo $this->active == 'resources'   ? 'active' : 'inactive' ?>" href="<?php echo $this->url(array('page' => 'resources'), 'analytics_view') ?>">Recursos</a>
    <a class="<?php echo $this->active == 'timeline'    ? 'active' : 'inactive' ?>" href="<?php echo $this->url(array('page' => 'timeline'), 'analytics_view') ?>">Linea de tiempo</a>
</div>
