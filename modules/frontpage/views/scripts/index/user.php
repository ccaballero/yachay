<h1>Yeah!</h1>
<?php foreach ($this->icons as $icon) { ?><a style="border:0px;" href="<?= $icon['url'] ?>"><img style="border:0px;" src="<?= $this->media . 'thumbnail_medium/' . $icon['icon'] ?>" alt="<?= $icon['alt'] ?>" /></a><?php } ?>
<?= $this->partial('resource.php', array('resources' => $this->resources, 'route' => $this->route)) ?>
