<h1><?php echo $this->page->label ?></h1>

<div id="tagcloud">
<?php foreach ($this->list as $node) { ?>
    <?php echo str_repeat('<span class="box">&nbsp;</span>', $node->level()) ?>
    <span class="tag"><?php echo $this->reference($node->label, $this->url(array('package' => $node->url), 'packages_package_view'), array(array('packages', 'view'))) ?></span>
    <?php echo $node->description ?>
    <br />
<?php } ?>
</div>
