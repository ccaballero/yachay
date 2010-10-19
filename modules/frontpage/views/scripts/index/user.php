<?php global $CONFIG; ?>
<h1><?= $CONFIG->site ?></h1>
<?= $this->partial('resource.php', array('resources' => $this->resources, 'route' => $this->route)) ?>
