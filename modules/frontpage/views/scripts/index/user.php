<h1>Yeah!</h1>

<center>
<?php foreach ($this->icons as $icon) { ?>
    <a href="<?= $icon['url'] ?>"><?= $icon['icon'] ?></a>
<?php } ?>
</center>

<?= $this->partial('resource.php', array('resources' => $this->resources, 'route' => $this->route)) ?>
